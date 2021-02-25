---
layout: blog
title: 限流方案分析
categories: [架构, 技术沉淀]
description: 应对突发流量的限流方案处理
keywords: 限流,redis
cnblogsClass: \[Markdown\],\[随笔分类\]架构
oschinaClass: \[Markdown\]
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

# 背景
应对突发流量或者是大流量涌入，为了保护系统不至于崩溃，需要做限流的处理。本文对限流处理做些分析，模拟语言PHP，数据库redis。

# 计数器方案
对限制时间内的连接做限制，通过时间点计数递增的形式，判断超过最大连接数，拒绝服务。

缺点也很明显，根据时钟时间点去计数，并不是连续的时间。
假设对1秒内的连接做限制，最大连接数M，连接发生在第1s的后0.5s过来M个请求，第二秒的前0.5秒内M的请求，在连续的1s内出现2M的请求，严格来说系统会超负荷运行，甚至挂掉。

# 简单限流 借助redis数据结构zset
计数器方案的缺点很明显，如果可以在一个连续的时间窗口来做限制就满足条件了。借助redis的zset数据结构，zset的score值存放毫秒时间戳，将用户的请求记录时间点，这样时间就是一个滑动的窗口，只要圈出时间窗口，统计计数，就可以
用来判断限流。而且我们只需要保留这个时间窗口，窗口之外的数据都可以砍掉，避免空间浪费。

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/20191102.png)

这个是把时间范围内的所有时间点记录下来，如果时间点特别很多，或者时间范围10分钟，假设有个1万的值，redis肯定玩不下去。如果要求比较高，下面的方案比较成熟，会比较合适

# 令牌桶算法
nginx的限流就是这个算法

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/20190610loutong.png)

假设令牌发放速度是每秒5个，容量是20，下一个请求过去4秒，则现在拥有20个令牌，相当与一秒可以处理20个突发请求的能力。

令牌桶算法对突发流量可以很好的支持。

笔者使用redis悲观锁模拟了下：

```php
<?php
        $redis = \Yii::$app->redis;
        $r = 5;  //每秒投放令牌数
        $c = 20;  //桶总容量

        $lock = $redis->set('lock',1,'EX',60,'NX');
        if( !$lock ){
            return $this->tokenBucket();
        }
        $w = $redis->get('w')?:0;   //桶剩余容量,初始值为满容量
        $preTime = $redis->get('preTime')?:0;   //前一个请求的时间点，初始值为0
        $nowTime = $this->microtime_float();  //当前请求时间点

        $w = min($c,intval($w+($nowTime-$preTime)*$r));//当前剩余容量

        $redis->set('preTime',$nowTime,'EX',3600);
        $redis->set('w',$w,'EX',3600);

        if( $w>0 ){
            $redis->decr('w');
            $redis->del('lock');
            return true;
        }else{
            $redis->del('lock');
            return false;
        }
```

限流日志片段如下：
```html
2019-06-10 14:15:34：34156014733415798_1560147334.5618_1560147334.6274_3

2019-06-10 14:15:34：34156014733415798 访问成功

2019-06-10 14:15:34：34156014733366588_1560147334.6274_1560147334.7413_2

2019-06-10 14:15:34：34156014733366588 访问成功

2019-06-10 14:15:34：961560147334752681_1560147334.7413_1560147334.8384_1

2019-06-10 14:15:34：961560147334752681 访问成功

2019-06-10 14:15:35：281560147334556592_1560147334.8384_1560147334.9778_0

2019-06-10 14:15:35：281560147334556592 访问失败

2019-06-10 14:15:35：1001560147334509357_1560147334.9778_1560147335.0564_0

2019-06-10 14:15:35：1001560147334509357 访问失败
```

基于上面算法来计算，如果直接用php会有很大的问题，redis的多个请求高并发下面临很多问题，无法保持原子性。故可使用redis+lua实现多个redis请求原子性操作。

php+redis+lua 实现令牌桶：

```php
<?php
    //获取当前时间戳（毫秒）
    function microtime_float()
    {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }
    
    //lua 语法
    //local data 代表局部变量
    //cjson.encode .decode json转换
    //math.min 取最小值
    //math.floor 向下取整
    //redis.call  执行redis脚本
    $redis = \Yii::$app->redis;
    $lua = "
        local data = redis.call('get',KEYS[1])
        if(data)
        then
           local dataJson = cjson.decode(data)
           local residualCapacity = math.min(KEYS[2],dataJson['residualCapacity']+(KEYS[4]-dataJson['curTime'])*KEYS[3])
           residualCapacity = math.floor(residualCapacity)
           if( residualCapacity>0 )
           then
               local setData = cjson.encode({residualCapacity=(residualCapacity-1),curTime=KEYS[4],preTime=dataJson['curTime']})
               redis.call('set',KEYS[1],setData,'EX',KEYS[5])
           else
               return -1
           end
        else
             local setData = cjson.encode({residualCapacity=KEYS[2],curTime=KEYS[4]})
             redis.call('set',KEYS[1],setData,'EX',KEYS[5])
        end
        
        return redis.call('get',KEYS[1])
        ";

    $key='current_limit';
    $nowTime = $this->microtime_float();  //当前请求unix时间
    $capacity=20;  //桶容量
    $tokenSpeed=10;   //令牌生成速度
    
    //EVAL script numkeys key [key ...] arg [arg ...]   numkeys 指定键名参数个数
    $tokenRes = $redis->eval($lua,5,$key,$capacity,$tokenSpeed,$nowTime,$key_timeout=3600);     //对key设置时间戳，防止持久化
    if($tokenRes==-1){
         echo '访问失败';
         exit;
    }
    
    echo '访问成功';
```

lua脚本运行效果：
```log
2019-07-25 15:09:33：651564038573891997_1564038573.7855_'{"residualCapacity":19,"curTime":"1564038573.7855","preTime":"1564038548.1081"}'

2019-07-25 15:09:34：341564038574902072_1564038574.5805_'{"residualCapacity":19,"curTime":"1564038574.5805","preTime":"1564038573.7855"}'

2019-07-25 15:09:34：371564038574656754_1564038574.6237_'{"residualCapacity":4,"curTime":"1564038574.6237","preTime":"1564038574.6312"}'

2019-07-25 15:09:34：801564038574632846_1564038574.5952_'-1'

2019-07-25 15:09:34：241564038574129130_1564038574.5921_'{"residualCapacity":16,"curTime":"1564038574.5921","preTime":"1564038574.5933"}'

2019-07-25 15:09:34：931564038574891869_1564038574.5847_'{"residualCapacity":14,"curTime":"1564038574.5847","preTime":"1564038574.5921"}'

2019-07-25 15:09:34：811564038574921747_1564038574.5933_'{"residualCapacity":18,"curTime":"1564038574.5933","preTime":"1564038574.5805"}'

2019-07-25 15:09:34：771564038574717631_1564038574.6312_'{"residualCapacity":6,"curTime":"1564038574.6312","preTime":"1564038574.6203"}'

2019-07-25 15:09:34：931564038574541957_1564038574.6135_'-1'

```

**注意**：lua脚本编写时需注意，切不可用变化极大的外部参数来定义变量，redis会对lua脚本创建lua函数，本身占内存，大量的函数生成会很快耗用redis的内存。

参考:

[php 使用 lua+redis 限流，计数器模式，令牌桶模式](https://segmentfault.com/a/1190000018761106)

[Lua脚本](https://redisbook.readthedocs.io/en/latest/feature/scripting.html)

或者 php另起一个进程或者线程来生成令牌token放入队列中，过来请求出队一个，token拿到就继续业务处理，反之拒绝此请求(不够灵活)。

参考coding
[传送门](https://github.com/WalkingSun/Jump/blob/master/controllers/CurrentlimitController.php)


# 漏桶算法

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/20190610loutonga.png)

```php
<?php
        $key = 'leakyBucketCurrentLimit';
        $capacity = 10; //桶容量
        $outflowSpeed = 10;  //流出速度
        $nowTime = $this->microtime_float();  //当前请求时间点

        $lua = "
            local data = redis.call('get',KEYS[1])
            if data
            then
                local dataJson = cjson.decode(data)
                local capacity = math.max(math.ceil( dataJson['residualCapacity']-(KEYS[4]-dataJson['curTime'])*KEYS[3] ),0)
                if capacity-KEYS[2]>0
                then
                    return -1
                else
                    local setData = cjson.encode({residualCapacity=(capacity+1),curTime=KEYS[4],preTime=dataJson['curTime']})
                    redis.call('set',KEYS[1],setData,'EX',KEYS[5])
                end
            else
               local setData = cjson.encode({residualCapacity=0,curTime=KEYS[4]})
               redis.call('set',KEYS[1],setData,'EX',KEYS[5])
            end   
   
           return redis.call('get',KEYS[1])
        ";

        $redis = \Yii::$app->redis;
        $tokenRes = $redis->eval($lua,5,$key,$capacity,$outflowSpeed,$nowTime,$key_timeout=3600);
        if( $tokenRes!=-1 )
                    return true;
                else
                    return false;
```

```log
2019-07-26 15:38:52：891564126732969386_1564126732.2845_'{"residualCapacity":9,"curTime":"1564126732.2845","preTime":"1564126732.2522"}'

2019-07-26 15:38:52：81564126732763964_1564126732.3442_'{"residualCapacity":10,"curTime":"1564126732.3442","preTime":"1564126732.2845"}'

2019-07-26 15:38:52：271564126732228350_1564126732.4937_'{"residualCapacity":10,"curTime":"1564126732.4937","preTime":"1564126732.3442"}'

2019-07-26 15:38:52：861564126732750011_1564126732.5089_'{"residualCapacity":11,"curTime":"1564126732.5089","preTime":"1564126732.4937"}'

2019-07-26 15:38:52：701564126732665743_1564126732.6324_'{"residualCapacity":11,"curTime":"1564126732.6324","preTime":"1564126732.5089"}'

2019-07-26 15:38:52：21564126732969240_1564126732.7191_'-1'
```

redis4.0已经提供了限流模块，redis-cell，就是漏桶算法，可以直接使用。

> 漏统 VS 令牌桶

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/20190610loutong2lingpaitong.png)


