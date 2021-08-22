---
layout: blog
title: php7执行原理【draft】
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

# 执行原理
开发语言大体分两种：编译型语言和解释性语言

编译型语言：C、C++、Go等。这里编译是指在应用源程序执行之前，就将程序源代码'翻译'成汇编语言，然后进一步根据软硬件编译成目标文件。
一般称完成编译工作的工具为编译器。

解释型语言，在程序运行时才被'翻译'成机器语言。执行一次'翻译'一次，故而执行效率低。解释器的工作就是解释型语言中，负责'翻译'源代码的程序。

> C语言代码，需经过 预编译、编译、汇编和链接，才能成为可执行的二进制文件。

编译型语言与解释型语言区别，立足于源代码被编译成目标平台CPU指令的时机。
- 对于编译型语言，编译结果已经针对当前CPU体系的指令；
- 解释型语言，需要先编译成中间代码，再经由该解释型语言的特定虚拟机，翻译成特定CPU体系的指令被执行。


php解释语言的执行示意图：

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/save_share_review_picture_1570453944.jpeg)

