layout: blog
title: Go并发模式【draft】
categories: [Go, 知识点]
description: 熟悉
keywords: Go
cnblogsClass: \[Markdown\],\[随笔分类\]Go
oschinaClass: \[Markdown\]
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]

# 背景

CSP（Communicating Sequential Process，通信顺序进程）模型，作为Go并发编程核心的CSP理论的核心概念只有一个：**同步通信**。

并发更关注的是程序的设计层面，并发的程序完全是可以顺序执行的，只有在真正的多核CPU上才可能真正地同时运行。

在并发编程中，对共享资源的正确访问需要精确地控制，在目前的绝大多数语言中，都是通过加锁等线程同步方案来解决这一困难问题，而Go语言却另辟蹊径，它将共享的值通过通道传递（实际上多个独立执行的线程很少主动共享资源）。Go语言将其并发编程哲学化为一句口号：**“不要通过共享内存来通信，而应通过通信来共享内存。”（Do not communicateby sharing memory; instead, share memory by communicating.）**

虽然像引用计数这类简单的并发问题通过原子操作或互斥锁就能很好地实现，但是通过通道来控制访问能够让你写出更简洁正确的程序。