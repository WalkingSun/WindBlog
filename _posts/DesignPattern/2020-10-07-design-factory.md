---
layout: blog
title: 设计模式-工厂模式
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

# 工厂模式
Define an interface for creating an object,but let subclasses decide whichclass to instantiate.Factory Method lets a class defer instantiation tosubclasses.
（定义一个用于创建对象的接口，让子类决定实例化哪一个类。工厂方法使一个类的实例化延迟到其子类。）

![image-20200905222329509](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/ws2/image-20200905222329509.png)
抽象产品类Product负责定义产品的共性，实现对事物最抽象的定义；Creator为抽象创建类，也就是抽象工厂，具体如何创建产品类是由具体的实现工厂ConcreteCreator完成的。

## 简单工厂模式
一个模块仅需要一个工厂类，没有必要把它产生出来，使用静态的方法就可以操作；

参考《设计模式之禅》女娲造人例子：
![image-20200905223730728](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/ws2/image-20200905223730728.png)

创建一个对象的时候，调用同一个方法，传入不同的参数就可以返回给我们不同的对象；

参考代码：
[简单工厂模式](https://github.com/WalkingSun/DesignPattern/tree/master/factory/simple_factory.go)


简单工厂模式的优缺点:

优点: 工厂类是整个工厂模式的核心，我们只需要传入给定的信息，就可以创建所需实例，在多人协作的时候，无需知道对象之间的内部依赖，可以直接创建，有利于整个软件体系结构的优化

缺点: 工厂类中包含了所有实例的创建逻辑，一旦这个工厂类出现问题，所有实例都会受到影响，并且，工厂类中生产的产品都基于一个共同的接口，一旦要添加不同种类的产品，这就会增加工厂类的复杂度，将不同种类的产品混合在一起，
违背了单一职责，系统的灵活性和可维护性都会降低，并且当新增产品的时候，必须要修改工厂类，违背了开闭原则『系统对扩展开放，对修改关闭』的原则

开发中有遇到工厂获取实例方法中种类非常多，一直叠加，经常修改这个方法，甚至可能需要增加形参的数量而调整了很多地方。

## 多工厂方法模式
复杂的项目中，所有的产品类放到一个工厂方法中进行初始化会使代码结构不清晰，而且会导致这个方法越来越大。

工厂方法模式设计多个工厂类（如何分类可以根据实际情况切分），每个分类提供一个工厂类，由调用者选择使用哪一个工厂方法。

参考《设计模式之禅》女娲造人例子：
![多个工厂类的类图](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/ws2/image-20201007111319693.png)

参考代码：
[多工厂方法模式](https://github.com/WalkingSun/DesignPattern/tree/master/factory/more_factory.go)

多工厂方法模式优缺：

优点：类的职责清晰，结构简单

缺点：可扩展性，可维护性复杂。扩展一个新的产品类，需要新建一个相应的工厂类，维护还需考虑工厂类和产品类的对应关系。

**复杂的应用采用多工厂的方法，然后再增加一个协调类，避免调用者与各个子工厂交流，协调类的作用是封装子工厂类，对高层模块提供统一的访问接口。**