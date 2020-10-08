---
layout: blog
title: 设计模式-单列模式
categories: [服务器,docker]
description: 记录docker遇到的坑
keywords: IM
cnblogsClass: \[Markdown\],\[随笔分类\]设计模式
oschinaClass: \[Markdown\],服务器,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

# 单列模式
Ensure a class has only one instance, and provide a global point of access to it.（确保某一个类只有一个实例，而且自行实例化并向整个系统提供这个实例。）


## 线程不安全

[懒汉模式](https://github.com/WalkingSun/DesignPattern/tree/master/singleton/singleton02.go)

懒汉模式存在线程安全问题在低并发的情况下尚不会出现问题，若系统压力增大，并发量增加时则可能在内存中出现多个实例，破坏了最初的预期。

## 线程安全

[饿汉模式](https://github.com/WalkingSun/DesignPattern/tree/master/singleton/singleton.go)

首先go中没有构造函数的概念，可以利用包的特性，在包被import的时候，会自动执行init的特性，进行实例化操作。当程序中用不到该对象时，浪费了一部分空间

和懒汉模式相比，更安全，但是会减慢程序启动速度

[锁机制](https://github.com/WalkingSun/DesignPattern/tree/master/singleton/singleton03.go)

线程安全问题，一般我们使用互斥锁来解决有可能出现的数据不一致问题。

sync.Once是golang标准包中给我们提供了相关的方法，请求实例加锁，原子操作只会在首次加锁，后面会直接取单列。

参考文：https://juejin.im/post/5bdbd074e51d450549408fa8
