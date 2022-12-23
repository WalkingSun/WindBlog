---
layout: blog
title: 设计模式-模版模式
categories: [设计模式]
description: 
keywords: 模版
cnblogsClass: \[Markdown\],\[随笔分类\]设计模式
---

# 模版模式
Define the skeleton of an algorithm in an operation,deferring some steps tosubclasses.Template Method lets subclasses redefine certain steps of analgorithm without changing the algorithm's structure.（定义一个操作中的算法的框架，而将一些步骤延迟到子类中。使得子类可以不改变一个算法的结构即可重定义该算法的某些特定步骤。）

通用步骤在抽象类中实现，变化的步骤在具体的子类中实现

模版模式通用类图：
![](https://s2.loli.net/2022/07/20/2G1por8igQz4cwt.png)

AbstractClass叫做抽象模板，它的方法分为两类：
● 基本方法
基本方法也叫做基本操作，是由子类实现的方法，并且在模板方法被调用。
● 模板方法
可以有一个或几个，一般是一个具体方法，也就是一个框架，实现对基本方法的调度，完成固定的逻辑。


优点：
● 封装不变部分，扩展可变部分
● 提取公共部分代码，便于维护
● 行为由父类控制，子类实现

缺点：
- 复杂的项目中，会带来代码阅读的难度，而且也会让新手产生不适感。


使用场景：
- 多个子类有公有的方法，并且逻辑基本相同时。
- 重要、复杂的算法，可以把核心算法设计为模板方法，周边的相关细节功能则由各个子类实现。
- 重构时，模板方法模式是一个经常使用的模式，把相同的代码抽取到父类中，然后通过钩子函数约束其行为。


# 案列
```go
package template

import "fmt"

type car interface {
	start()     // 启动车辆
	stop()      // 停止车辆
	alarm()     // 鸣笛
	engineBom() // 引擎发生轰鸣
	run()       // 车子跑起来
}

// HummerCar 悍马 (抽象类)
type HummerCar struct {
}

// run 模版方法
func (h *HummerCar) run() {
	fmt.Println("hummer run...")
}

type Hummer1Car struct {
	HummerCar
}

var hummer1 car = &Hummer1Car{}

func (h1 *Hummer1Car) start() {
	fmt.Println("hummer1 start...")
}

func (h1 *Hummer1Car) alarm() {
	fmt.Println("hummer1 alarm...")
}

func (h1 *Hummer1Car) engineBom() {
	fmt.Println("hummer1 bom...")
}
func (h1 *Hummer1Car) stop() {
	fmt.Println("hummer1 stop...")
}

type Hummer2Car struct {
	HummerCar
}

var hummer2 car = &Hummer2Car{}

func (h1 *Hummer2Car) start() {
	fmt.Println("hummer2 start...")
}

func (h1 *Hummer2Car) alarm() {
	fmt.Println("hummer2 alarm...")
}

func (h1 *Hummer2Car) engineBom() {
	fmt.Println("hummer2 bom...")
}
func (h1 *Hummer2Car) stop() {
	fmt.Println("hummer2 stop...")
}
```


test:
```go

func TestT(t *testing.T) {
	hummer1.start()
	hummer1.engineBom()
	hummer1.alarm()
	hummer1.run()
	hummer1.stop()

	fmt.Println("=================hummer2")
	hummer2.start()
	hummer2.engineBom()
	hummer2.alarm()
	hummer2.run()
	hummer2.stop()
}

```