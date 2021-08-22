---
layout: post
title: swoole实现web server的一点思考
categories: [swoole]
description:
keywords: swoole,Http Server
---
swoole起个进程绑定一个端口，就可以作为一个web server，静态资源转发到对应的静态目录上，虽然入口是当前这个ip地址对应端口，但是我们可以做路由规则匹配，像nginx一样所有的请求都转发到index.php一样，只要设定规则，进行匹配到执行的php程序上即可。

1. 参数传递，类似：?r=index
2. 美化路径，类似： /index

代码实现：
```php
$http = new swoole_http_server("0.0.0.0",9501);

$http->set([
    'enable_static_handler'=> true,     //启用静态资源处理
    'document_root' => '/data/app/data'   //静态资源地址
]);

$http->on('request',function ($request , $response){
   $query = $request->get;
    $result = '';
    $r = (!empty($request->server['request_uri']) && $request->server['request_uri']!="/favicon.ico" ) ? $request->server['request_uri']: ( !empty($query['r'])?$query['r']:'');
    if( $r ){
        $r = trim($r,"/");
        if( file_exists(__DIR__."/{$r}.php") ){
            $result = include __DIR__."/{$r}.php";
        }
    }

    $response->end("<h1>Hello Swoole.#".$result."</h1>");
});

$http->start();

```

上面只是对于简单的路由的分发程序思考，对于复杂的可以写个复杂分发的程序，swoole作为高性能的异步通信服务器，性能还是不错的，现在也有了些swoole的框架，实现MVC的架构,也有结合现有框架，做好分发路由工作。个人觉得作为API服务还是挺不错的，与专门的web服务器还是有点区别，比如反向代理，异步io，虽然好像swoole也可以去做，但是实现复杂感觉，如果结合用，效果我觉得更好，比如nginx做负载均衡，分发到对应swoole服务上，相互结合自己的优势，性能肯定会更好,纯属个人理解。


参考：

[nginx、swoole高并发原理初探](https://www.cnblogs.com/thrillerz/p/7137682.html)

[swoole与php框架结合实现http服务](https://www.shixinke.com/php/php-framework-with-swoole)