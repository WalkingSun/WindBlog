---
layout: blog
title: 设计模式-里氏替换原则
categories: [设计模式]
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

面向对象继承优点：
- 代码共享，减少创建类的工作量，每个子类都拥有父类的方法和属性；
- 提供代码的重用性；


缺点：
- 继承是侵入性的。只要继承，就必须拥有父类的所有属性和方法；降低代码的灵活性。子类必须拥有父类的属性和方法，让子类自由的世界中多了些约束；
- 增强了耦合性。当父类的常量、变量和方法被修改时，需要考虑子类的修改，而且在缺乏规范的环境下，这种修改可能带来非常糟糕的结果——大段的代码需要重构。

## 里氏替换原则：
Functions that use pointers or references to base classes must be able to use objects of derived classes without knowing it.（所有引用基类的地方必须能透明地使用其子类的对象。）

通俗点讲，只要父类能出现的地方子类就可以出现，而且替换为子类也不会产生任何错误或异常，使用者可能根本就不需要知道是父类还是子类