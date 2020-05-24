---
layout: blog
title: Nginx Record
categories: [shell, 服务器]
description: nginx学习记录
keywords: shell
cnblogsClass: \[Markdown\],\[随笔分类\]服务器,,\[随笔分类\]网关
oschinaClass: \[Markdown\],服务器,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

# 简介
nginx是开发中常用的web server，又可以做反向代理，另外k8s中的ingress默认使用的也是nginx，所以有必要深入了解下nginx的相关知识，及一些必要的原理知识。

# 常用指令
## location
```
location [=|~|~*|^~|@] pattern { ... }
```
- =代表路径完全匹配
- ～区分大小写的正则匹配
```
server {
    server_name web.com;
    location ~ ^/abcd$ {
    […]
    }
}
```
^/abcd$这个正则表达式表示字符串必须以/开始，以$结束，中间必须是abcd
```
http://web.com/abcd匹配（完全匹配）
http://web.com/ABCD不匹配，大小写敏感
http://web.com/abcd?param1&param2匹配
http://web.com/abcd/不匹配，不能匹配正则表达式
http://web.com/abcde不匹配，不能匹配正则表达式
```
- ~* 不区分大小写的正则匹配

### 查找的顺序及优先级
当有多条 location 规则时，nginx 有一套比较复杂的规则，优先级如下：
- 精确匹配 =
- 前缀匹配 ^~（立刻停止后续的正则搜索）
- 按文件中顺序的正则匹配 ~或~*
- 匹配不带任何修饰的前缀匹配。

## rewrite模块
### break
```
break
Context: server, location, if
```
停止执行 ngx_http_rewrite_module 的指令集，但是其他模块指令是不受影响的

官方：
```
last
   stops processing the current set of ngx_http_rewrite_module directives followed by a search for a new location matching the changed URI;

break
   stops processing the current set of ngx_http_rewrite_module directives;
```

last: 停止当前这个请求，并根据rewrite匹配的规则重新发起一个请求。新请求又从第一阶段开始执行…
break：相对last，break并不会重新发起一个请求，只是跳过当前的rewrite阶段，并执行本请求后续的执行阶段…
实例
```
server {
    listen 80 default_server;
    server_name dcshi.com;
    root www;

    location /break/ {
        rewrite ^/break/(.*) /test/$1 break;
        echo "break page";
    } 

    location /last/ {
         rewrite ^/last/(.*) /test/$1 last;
         echo "last page";
    }    

    location /test/ {
       echo "test page";
    }
}
```
### if
```
Context: server, location

依据指定的条件决定是否执行 if 块语句中的内容
```

if 中的几种 判断条件
- 一个变量名，如果变量 $variable 的值为空字符串或者字符串"0"，则为false
- 变量与一个字符串的比较 相等为(=) 不相等为(!=) 注意此处不要把相等当做赋值语句啊
- 变量与一个正则表达式的模式匹配 操作符可以是(~ 区分大小写的正则匹配， ~*不区分大小写的正则匹配， !~ !~*，前面两者的非)
- 检测文件是否存在 使用 -f(存在) 和 !-f(不存在)
- 检测路径是否存在 使用 -d(存在) 和 !-d(不存在) 后面判断可以是字符串也可是变量
- 检测文件、路径、或者链接文件是否存在 使用 -e(存在) 和 !-e(不存在) 后面判断可以是字符串也可是变量
- 检测文件是否为可执行文件 使用 -x(可执行) 和 !-x(不可执行) 后面判断可以是字符串也可是变量
```
set $variable "0"; 
if ($variable) {
    # 不会执行，因为 "0" 为 false
    break;            
}

# 使用变量与正则表达式匹配 没有问题
if ( $http_host ~ "^star\.igrow\.cn$" ) {
    break;            
}

# 字符串与正则表达式匹配 报错
if ( "star" ~ "^star\.igrow\.cn$" ) {
    break;            
}
# 检查文件类的 字符串与变量均可
if ( !-f "/data.log" ) {
    break;            
}

if ( !-f $filename ) {
    break;            
}
```

if中&&的实现，参考：
```
        // 匹配click路径且参数中带有name=walkingsun 重定向到click-ios路径
        set $flag 0;
        if ( $uri = /click) {
          set $flag 1;
        }
        if ( $args ~ name=walkingsun ) {
          set $flag 1$flag;
        }
        if ( $flag = 11 ) {
          rewrite ^/(.*) $uri-ios break;
        }
```

### return
```
Context: server, location, if

return code [text];
return code URL;
return URL;
```
停止处理并将指定的code码返回给客户端。 非标准code码 444 关闭连接而不发送响应报头

有一种特殊情况，就是重定向的url可以指定为此服务器本地的urI，这样的话，nginx会依据请求的协议$scheme， server_name_in_redirect 和 port_in_redirect自动生成完整的 url （此处要说明的是server_name_in_redirect 和port_in_redirect 指令是表示是否将server块中的 server_name 和 listen 的端口 作为redirect用 ）




# 参考
https://segmentfault.com/a/1190000008102599

