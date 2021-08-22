---
layout: post
title: session更换存储，实现在多台服务器共享
categories: [PHP,Nginx ]
description:
keywords: php, session
---

# 场景
web服务器有多台，每台服务器都会存贮自己的session，session无法在多台服务器共享。所以就需要更换session的存贮空间，存贮在一个共用的空间。通常为了读写速度，我们会选择存贮在内存服务上，如redis、mysql的memory存贮引擎等，本文以reddis存贮贯串上下文。

## session共享
### nginx ip_hash 或者 url_hash
#### ip_hash
```shell
...
upstream backserver {
    ip_hash;
    server 192.168.0.14:88;
    server 192.168.0.15:80;
}
...
```
采用ip_hash指令解决这个问题，如果客户已经访问了某个服务器，当用户再次访问时，会将该请求通过哈希算法，自动定位到该服务器。
每个请求按访问ip的hash结果分配，这样每个访客固定访问一个后端服务器，解决session的问题。
#### url_hash
按访问url的hash结果来分配请求，使每个url定向到同一个（对应的）后端服务器，后端服务器为缓存时比较有效。
```shell
...
upstream backserver {
    server squid1:3128;
    server squid2:3128;
    hash $request_uri;
    hash_method crc32;
}
...
```
### php.ini修改配置
```
session.save_handler = redis
session.save_path = "tcp://127.0.0.1:6379"
```
修改完之后，重启 php-fpm。
### 通过 ini_set() 函数设置
```php
ini_set("session.save_handler", "redis");
ini_set("session.save_path", "tcp://127.0.0.1:6379");
```
### session_set_save_handler()函数设置
主流框架都选择用此类方法覆盖session的open、close、read、write、gc机制，容易扩展。我写了个redis的session存贮类,仅供参考：
```
<?php
//namespace openyii\framework;

class CSessionRedis //extends CSession
{
    protected $redisInstance;   //redis操作实例
    public $keyPrefix;          //键前缀
    public $lifeTime;           //生命周期

    public function __construct( $keyPrefix,$lifeTime=3600 )
    {
        $this->lifeTime = $lifeTime;
        $this->keyPrefix = $keyPrefix;
        session_set_save_handler(
            array($this, 'open'),
            array($this, 'close'),
            array($this, 'read'),
            array($this, 'write'),
            array($this, 'destroy'),
            array($this, 'gc')
        );
        if ($this->keyPrefix === null) {
            $this->keyPrefix = substr(md5(base::$app->id), 0, 5);
        }
        session_start();            //以全局变量形式保存在一个session中并且会生成一个唯一的session_id，
    }

    function open($savePath, $sessionName)
    {
        //todo $redis redis的操作实例要自己写下

          $this->redisInstance = $redis;
//        $this->redisInstance = base::$app->redis;
        return true;
    }

    function close()
    {
        return true;
    }

    function read($id)
    {
        if( !$this->redisInstance->exists($this->calculateKey($id)) ){
            $this->redisInstance->set( $this->calculateKey($id),'' );
        }
        return $this->redisInstance->get( $this->calculateKey($id) );
    }

    function write($id, $value)
    {
        return $this->redisInstance->set($this->calculateKey($id), $value, $this->lifeTime)?true:false;
    }

    function destroy($id)
    {
        $this->redisInstance->delete($this->calculateKey($id));
        if( !$this->redisInstance->exists($this->calculateKey($id)) ){
            return false;
        }
        return true;
    }

    function gc($lifetime)
    {
        //不做实现，redis本身有回收机制

        return true;
    }

    /**
     * 加密key
     * @param $id
     * @return string
     */
    protected function calculateKey($id)
    {
        return $this->keyPrefix . md5(json_encode([__CLASS__, $id]));
    }

}
```
具体细节可以看我写的[php框架代码](https://github.com/WalkingSun/openyii/blob/master/framework/CSessionRedis.php),如果想自己实现，上面的代码改改就可以实现的。

# 思考
## 如果使用mysql如何存贮？
mysql使用memory存贮引擎，设计数据表（sessionid、sessionValue 、过期时间）,重写session_set_save_handler方法。

## 如果redis是哨兵 master-slave模式，session如何共享？
没想清楚，咨询了老大，做法比较坑，php.ini修改配置指定redis master ip，有个守护进程的脚本检测哨兵，发生故障哨兵切换，检测到发邮件通知‘人’去手动修改php.ini master的ip，感觉匪夷所思啊！

我的思路是：哨兵模式会有三个redis服务ip端口，客户端连接获取每个redis服务的info信息，如果info里包含master role，则将此master redis服务操作实例交给上面的代码，实现写操作。

后面自己动手实现了吧，可行的，代码地址贴下，结合代码及说明看看，希望能帮助大家理解：

[哨兵主从模式(redis服务ip可直接访问)](https://github.com/WalkingSun/openyii/blob/master/framework/CRedisHa.php)

[哨兵主从模式(redis服务ip不可直接访问，ip映射访问)](https://github.com/WalkingSun/openyii/blob/master/framework/CRedisServer.php)