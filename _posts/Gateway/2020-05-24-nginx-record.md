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
- ^~ 普通字符匹配，不是正则匹配。如果该选项匹配，只匹配该选项，不匹配别的选项，一般用来匹配目录
- @ 定义一个命名的location,使用在内部定向时，例如error_page,try_files

### 查找的顺序及优先级
当有多条 location 规则时，nginx 有一套比较复杂的规则，优先级如下：

1). =前缀的指令严格匹配这个查询。如果找到，停止搜索。

2). 所有剩下的常规字符串，最长的匹配。如果这个匹配使用^~前缀，搜索停止。

3). 正则表达式，在配置文件中定义的顺序。

4). 如果第3条规则产生匹配的话，结果被使用。否则，如同从第2条规则被使用。

顺序or优先级： (location =)   >  (location ^~ 路径 最长匹配的意思) > (location ~,~* 正则顺序) > (location 部分起始路径) > (/)

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

# 变量
定义变量
```
set $foo hello;
```
## 内置变量
- $request_method  请求方式
- $args query params
- $request_uri $request_uri 则用来获取请求最原始的 URI （未经解码，并且包含请求参数）
- $uri 获取当前请求的 URI（经过解码，并且不含请求参数）
- $arg_xxx 特别常用的内建变量其实并不是单独一个变量，而是有无限多变种的一群变量，即名字以 arg_ 开头的所有变量，我们估且称之为 $arg_XXX 变量群。一个例子是 $arg_name，这个变量的值是当前请求中名为 name 的参数的值，而且还是未解码的原始形式的值。
```
location /test-arg {
    echo "name: $arg_name";
    echo "class: $arg_class";
}
```
$arg_name 不仅可以匹配 name 参数，也可以匹配 NAME 参数，抑或是 Name，Nginx 会在匹配参数名之前，自动把原始请求中的参数名调整为全部小写的形式
- $cookie_XXX 取 cookie 值变量群
- $http_XXX

## 全局变量
```
arg_PARAMETER #这个变量包含GET请求中，如果有变量PARAMETER时的值。
args #这个变量等于请求行中(GET请求)的参数，如：foo=123&bar=blahblah;
binary_remote_addr #二进制的客户地址。
body_bytes_sent #响应时送出的body字节数数量。即使连接中断，这个数据也是精确的。
content_length #请求头中的Content-length字段。
content_type #请求头中的Content-Type字段。
cookie_COOKIE #cookie COOKIE变量的值
document_root #当前请求在root指令中指定的值。
document_uri #与uri相同。
host #请求主机头字段，否则为服务器名称。
hostname #Set to themachine’s hostname as returned by gethostname
http_HEADER
is_args #如果有args参数，这个变量等于”?”，否则等于”"，空值。
http_user_agent #客户端agent信息
http_cookie #客户端cookie信息
limit_rate #这个变量可以限制连接速率。
query_string #与args相同。
request_body_file #客户端请求主体信息的临时文件名。
request_method #客户端请求的动作，通常为GET或POST。
remote_addr #客户端的IP地址。
remote_port #客户端的端口。
remote_user #已经经过Auth Basic Module验证的用户名。
request_completion #如果请求结束，设置为OK. 当请求未结束或如果该请求不是请求链串的最后一个时，为空(Empty)。
request_method #GET或POST
request_filename #当前请求的文件路径，由root或alias指令与URI请求生成。
request_uri #包含请求参数的原始URI，不包含主机名，如：”/foo/bar.php?arg=baz”。不能修改。
scheme #HTTP方法（如http，https）。
server_protocol #请求使用的协议，通常是HTTP/1.0或HTTP/1.1。
server_addr #服务器地址，在完成一次系统调用后可以确定这个值。
server_name #服务器名称。
server_port #请求到达服务器的端口号
```


# 参考
https://segmentfault.com/a/1190000008102599

