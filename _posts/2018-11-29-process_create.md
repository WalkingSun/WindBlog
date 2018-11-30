---
layout: blog
title: 进程控制
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
- 根目录
- 文件方式创建屏蔽
- 环境变量
- 所有相连的共享存储段
- 资源限制
- 任何打开的文件描述字的执行时关闭标志FD_CLOEXEC

2）不同点
- 子进程有自己的唯一进程ID
- 子进程拥有其父进程打开的文件描述字副本，此副本属于子进程本身，随后父进程改变其文件描述字属性不会影响到子进程，反过来也是一样。
- 子进程不继承父进程设置的文件锁
- 子进程不继承父进程设置的定时器
- 父进程的任何悬挂信号在进程中都被清除，但子进程从父进程继承他的信号屏蔽和信号动作。
- 子进程已耗费的紧凑时间tms_utime、time_stime、tms_cutime和tms_cstime均置为0
