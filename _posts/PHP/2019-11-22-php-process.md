---
layout: blog
title: php进程【draft】
categories: [PHP, 知识点]
description: 熟悉
keywords: php
cnblogsClass: \[Markdown\],\[随笔分类\]PHP
oschinaClass: \[Markdown\],PHP,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

# php进程
```php
<?php

$pid = pcntl_fork();
if( $pid==-1 ){
    die('could not fork');
}
if( $pid ){
    pcntl_wait($status);   //等待子进程中断，防止子进程成为僵尸进程。

    var_dump($status);
}else{
    //子进程处理
    $pid = posix_getpid();    //当前进程id
    $ppid = posix_getppid();  //父进程id

    error_log("this is child process,pid {$pid},ppid {$ppid}",3,__DIR__.'/process.log');

    //业务代码执行
    sleep(10);
    die();
}

//pcntl_waitpid() 等待或返回fork的子进程状态
// 返回退出的子进程进程号，发生错误时返回-1,如果提供了 WNOHANG作为option（wait3可用的系统）并且没有可用子进程时返回0。
//pcntl_waitpid()将会存储状态信息到status 参数上，这个通过status参数返回的状态信息可以用以下函数 pcntl_wifexited(), pcntl_wifstopped(), pcntl_wifsignaled(), pcntl_wexitstatus(), pcntl_wtermsig()以及 pcntl_wstopsig()获取其具体的值。
while (pcntl_waitpid(0, $status) != -1) {
    $status = pcntl_wexitstatus($status);     //返回一个中断的子进程的返回代码
}

```




https://www.cnblogs.com/ygw1010/p/14627804.html