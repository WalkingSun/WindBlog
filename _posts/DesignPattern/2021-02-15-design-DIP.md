---
layout: blog
title: 设计模式-依赖倒置
categories: [设计模式]
description: 
keywords: IM
cnblogsClass: \[Markdown\],\[随笔分类\]设计模式
oschinaClass: \[Markdown\],服务器,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\] 
sinaClass: \[Markdown\]
---

## 依赖倒置（DIP）

依赖倒置原则（Dependence Inversion Principle,DIP）：High level modules should not depend upon low level modules.Both shoulddepend upon abstractions.Abstractions should not depend upondetails.Details should depend upon abstractions.

翻译过来，包含三层含义：高层模块不应该依赖低层模块，两者都应该依赖其抽象；抽象不应该依赖细节；细节应该依赖抽象。

**抽象**就是指接口或抽象类，两者都是不能直接被实例化的；

**细节**就是实现类，实现接口或继承抽象类而产生的类就是细节，其特点就是可以直接被实例化，也就是可以加上一个关键字new产生一个对象。

Java语言抽象就是指接口或抽象类，两者都是不能直接被实例化的；细节就是实现类，实现接口或继承抽象类而产生的类就是细节，其特点就是可以直接被实例化，也就是可以加上一个关键字new产生一个对象。

**接口**只是一个抽象化的概念，是对一类事物的最抽象描述，具体的实现代码由相应的实现类来完成

程序原则（面向接口编程——OOD）：
- 模块间的依赖通过抽象发生，实现类之间不发生直接的依赖关系，其依赖关系是通过接口或抽象类产生的；
- 接口或抽象类不依赖于实现类；实现类依赖接口或抽象类。

书中举例驾驶员实现开宝马的动作，驾驶员作为driver，调宝马car的drive方法；此时驾驶员驾驶奔驰car，此时新加一个奔驰car类，就需要改动调用drive处代码，高层模块跟底层模块过度耦合在一起，
改了细节就必须修改高层模块，不符合开闭原则。将所有car共同的变化抽象成interface，每个car类型实现drive方法，解决了类间的耦合性，抽象约束，增加代码可读性可维护性，易于扩展。

![image-20210215160603927](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/ws2/image-20210215160603927.png)

依赖倒置优势：
- 减少类间的耦合性，提高系统的稳定性；
- 降低并行开发引起的风险，确保约束双方按照既定的契约（抽象）共同发展；
- 两个相互依赖的对象可以分别进行开发，孤立地进行单元测试，进而保证并行开发的效率和质量；测试驱动开发（TDD 先写好单元测试类，然后再写实现类），当扩展新类，非常方便使用测试用例进行但愿如此测试。
- 提高代码的可读性和可维护性；

### 抽象依赖运用方式

- 构造函数注入（传递依赖对象）
- Setter依赖注入
- 接口注入 在接口的方法中声明依赖对象

### 项目运用

本质就是通过抽象（接口或抽象类）使各个类或模块的实现彼此独立，不互相影响，实现模块间的松耦合。

- 每个类尽量都有接口或抽象类，或者抽象类和接口两者都具备；
- 任何类都不应该从具体类派生；
- 尽量不要覆写基类的方法；
- 结合里氏替换原则使用；接口负责定义public属性和方法，并且声明与其他对象的依赖关系，抽象类负责公共构造部分的实现，实现类准确的实现业务逻辑，同时在适当的时候对父类进行细化

依赖倒置原则是6个设计原则中最难以实现的原则，它是实现开闭原则的重要途径，依赖倒置原则没有实现，就别想实现对扩展开放，对修改关闭。

