---
layout: blog
title: Go 并发
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
---

# 并发
并发指在同一时间内可以执行多个任务。并发编程含义比较广泛，包含多线程编程、多进程编程及分布式程序等。本章讲解的并发含义属于多线程编程。

goroutine是由Go语言的运行时调度完成，而线程是由操作系统调度完成。

使用者分配足够多的任务，系统能自动帮助使用者把任务分配到CPU上，让这些任务尽量并发运作。这种机制在Go语言中被称为goroutine。

Go程序从main包的main()函数开始，在程序启动时，Go程序就会为main()函数创建一个默认的goroutine。

## 调整并发的运行性能（DOMAXPROCS）
传统逻辑中，开发者需要维护线程池中线程与CPU核心数量的对应关系。同样的，Go地中也可以通过runtime.GOMAXPROCS()函数做到，格式为：
```go
runtime.GOMAXPROC(逻辑cpu数量)
```

几种数值：
 - <1：不修改任何数值。
 - =1：单核心执行。
 - '>1'：多核并发执行
 
 runtime.Num CPU()查询CPU数量，并使用runtime.GOMAXPROCS()函数进行设置，例如：
```go
runtime.GOMAXPROC(runtime.NumCPU())
```

## 并发和并行
并发（concurrency）：把任务在不同的时间点交给处理器进行处理。在同一时间点，任务并不会同时运行。

并行（parallelism）：把每一个任务分配给每一个处理器独立完成。在同一时间点，任务一定是同时运行。

**GO在GOMAXPROCS数量与任务数量相等时，可以做到并行执行，但一般情况下都是并发执行。**

goroutine属于抢占式任务处理，已经和现有的多线程和多进程任务处理非常类似。应用程序对CPU的控制最终还需要由操作系统来管理，操作系统如果发现一个应用程序长时间大量地占用CPU，那么用户有权终止这个任务。

