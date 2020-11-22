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

# 里氏替换原则(LSP)
面向对象继承优点：
- 代码共享，减少创建类的工作量，每个子类都拥有父类的方法和属性；
- 提供代码的重用性；

缺点：
- 继承是侵入性的。只要继承，就必须拥有父类的所有属性和方法；降低代码的灵活性。子类必须拥有父类的属性和方法，让子类自由的世界中多了些约束；
- 增强了耦合性。当父类的常量、变量和方法被修改时，需要考虑子类的修改，而且在缺乏规范的环境下，这种修改可能带来非常糟糕的结果——大段的代码需要重构。

里氏替换原则：
Functions that use pointers or references to base classes mustbe able to use objects of derived classes without knowing it.（所有引用基类的地方必须能透明地使用其子类的对象。）

通俗点讲，只要父类能出现的地方子类就可以出现，而且替换为子类也不会产生任何错误或异常，使用者可能根本就不需要知道是父类还是子类

## 里氏替换原则为良好的继承定义了一个规范：
- 子类必须完全实现父类的方法
如书中所说：玩具枪不能实现杀敌这个行为。
![image-20201122182637376](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/img/image-20201122182637376.png)
ToyGun脱离继承，建立一个独立的父类，为了实现代码复用，可以与AbastractGun建立关联委托关系

注：如果子类不能完整地实现父类的方法，或者父类的某些方法在子类中已经发生“畸变”，则建议断开父子继承关系，采用依赖、聚集、组合等关系代替继承

- 子类可以有自己的个性

子类可以有自己的方法和属性。里氏替换原则可以正着用，但不能反着用，换言之子类出现的地方，父类未必能胜任。
![image-20201122192437506](/Users/zhaoyu/Library/Application Support/typora-user-images/image-20201122192437506.png)
AUG继承了Rifle类，狙击手（Snipper）则直接使用AUG狙击步枪

Sniper 阻击手很依赖枪支（AUG），实现杀敌需要先瞄准再射击，换成父类去执行将是错误的。

- 覆盖或实现父类的方法时输入参数可以被放大

方法中的输入参数称为前置条件，里氏替换原则也要求制定一个契约，就是父类或接口，这种设计方法也叫做Design by Contract（契约设计），同时制定了前置条件和后置条件，前置条件就是你要让我执行，就必须满足我的条件；
后置条件就是我执行完了需要反馈，标准是什么。

书中描述子类没有实现父类的方法，但是因为重载，子类的前置条件范围缩小，在子类执行父类的方法会走到子类的方法，“歪曲”了父类的意图，引起一堆意想不到的业务逻辑混乱。
![image-20201122194606366](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/img/image-20201122194606366.png)
![image-20201122194648477](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/img/image-20201122194648477.png)
![image-20201122194743259](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/img/image-20201122194743259.png)

- 覆写或实现父类的方法时输出结果可以被缩小

父类的一个方法的返回值是一个类型T，子类的相同方法（重载或覆写）的返回值为S，那么里氏替换原则就要求S必须小于等于T，也就是说，要么S和T是同一个类型，要么S是T的子类，为什么呢？分两种情况，如果是覆写，父类和子类
的同名方法的输入参数是相同的，两个方法的范围值S小于等于T，这是覆写的要求，这才是重中之重，子类覆写父类的方法，天经地义。
如果是重载，则要求方法的输入参数类型或数量不相同，在里氏替换原则要求下，就是子类的输入参数宽于或等于父类的输入参数，也就是说你写的这个方法是不会被调用的，参考上面讲的前置条件。

> 采用里氏替换原则的目的就是增强程序的健壮性，版本升级时也可以保持非常好的兼容性。即使增加子类，原有的子类还可以继续运行。在实际项目中，每个子类对应不同的业务含义，使用父类作为参数，传递不同的子类完成不同的业务逻辑，非常完美！
