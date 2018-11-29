---
layout: blog
title: 进程创建
categories: [服务器]
description:
keywords: 进程
cnblogsClass: \[Markdown\],\[随笔分类\]服务器
oschinaClass: \[Markdown\],服务器,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

<!--
cnblogsClass: 【你的博客园的分类，以逗号分隔，注意\[Markdown\]必须项】
oschinaClass: 【你的开源中国的分类】
csdnClass: 【你的CSDN分类】
...

注：由于'['、']'是jekyll的关键字，故在分类中请加上'\'；

可以在网站下添加操作看到你的博客分类，案列是自己的分类，需要自行修改。
添加这些分类的目的，是可以自动同步到对应的博客网站，新建博客以此模版文件复制创建markdown文件，如果你不需要，请跳过此步。


图片地址存放参考：
本地存放路径/WindBlog/gh-pages/images/blog/b.png
git上：
![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/b.png)

-->

# 进程控制
进程是系统环境的一个基本组成部分，是系统资源的基本单位，UNIX系统中完成的工作几乎通过进程来控制。

## 进程创建
进程有一个唯一标识PID(正整数)与之关联，创建进程就会获得其PID。

系统创建时就存在的几个特殊进程：
- PID为0，swapper调度进程；
- PID为1，init进程，在系统自举过程末尾由内核创建的；
- PID为2，pagedaemon,负责支持虚拟系统的分页。

特殊的进程在0~n之间，普通用户的进程在 n+1 - MAXPID-1之间，用户PID通常比较大。

getpid()获取PID:

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/TIM截图20181129175342.png)

getppid()获取调用进程的父进程。

> 应用程序创建进程的唯一方法是在执行进程中fork新进程。
![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/TIM截图20181129175733.png)

fork函数创建新进程，与当前进程构成父子关系。

若fork调用成功，则同时存在父进程和子进程且二者均从fork返回，但具有不同的返回值：子进程的返回值为0，而父进程返回的是子进程的PID。
fork返回的子进程的PID给父进程的原因：一个进程可以有多个子进程，因而无法通过函数获取到进程的子进程ID。fork返回0给子进程的原因因为每个子进程仅有一个父进程，子进程通过getppid()而获得父进程ID。

若调用失败，fork返回-1，并置errno指出失败原因（如EAGAIN没有足够资源用来创建进程或已经有太多进程在运行）。

当fork成功，父子进程均从fork之后一条语句继续执行，子进程几乎是父进程的复制。
1）共同特征
- 实际用户ID
- 有效用户ID
- 会晤ID
- 控制终端
- 当前工作目录

2）不同点
