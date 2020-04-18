---
layout: blog
title: Go 包
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

# 包（package）
Go语言的包与文件夹一一对应，所有与包相关的操作，必须依赖于工作目录（GOPATH）。

Go的入口main()函数所在的包叫main包。


## 工作目录（GOPATH）

GOPATH是Go语言中使用的一个环境变量，它使用绝对路径提供项目的工作目录。

### 工程结构
GOPATH指定的工作目录下，代码总是会保存在$GOPATH/src目录下。在工程经过gobuild、go install或go get等指令后，会将产生的二进制可执行文件放在$GOPATH/bin目录下，生成的中间缓存文件会被保存在$GOPATH/pkg下。

### 设置、使用GOPATH
设置当前目录为GOPATH
```
export GOPATH=`pwd`
```
使用反引号“'”将pwd指令括起来表示命令行替换

使用export指令可以将当前目录的值设置到环境变量GOPATH中。

### 在多项目中使用GOPATH
使用命令行或者使用集成开发环境编译Go源码时，GOPATH跟随项目设定。

建议开发者不要设置全局的GOPATH，而是随项目设置GOPATH


## 匿名导入包——只导入包但不使用包内类型和数值

```go
import (
        _ "path/to/package"
)
```

匿名导入的包与其他方式导入包一样会让导入包编译到可执行文件中，同时，导入包也会触发init()函数调用。


### 包在程序启动前的初始化入口：init
在某些需求的设计上需要在程序启动时统一调用程序引用到的所有包的初始化函数，如果需要通过开发者手动调用这些初始化函数，那么这个过程可能会发生错误或者遗漏

init()函数的特性
- 每个源码可以使用1个init()函数。
- init()函数会在程序执行前（main()函数执行前）被自动调用。
- 调用顺序为main()中引用的包，以深度优先顺序初始化。
- 同一个包中的多个init()函数的调用顺序不可预期。
- init()函数不能被其他函数调用。

### 包导入后的init()函数初始化顺序
Go语言包会从main包开始检查其引用的所有包，每个包也可能包含其他的包。Go编译器由此构建出一个树状的包引用关系，再根据引用顺序决定编译顺序，依次编译这些包的代码。

在运行时，被最后导入的包会最先初始化并调用init()函数。

### 工厂模式自动注册————管理多个包的结构体

定义商品接口，base包中定义注册、创建工厂方法
```go
package base

// 负责处理注册和使用工厂的基础代码，该包不会引用任何外部的包

// 定义商品接口
type Commodity interface {
	Show()		// 定义展示商品的方法
}

var (
	// 保存注册好的工厂信息
	factoryByName = make(map[string]func() Commodity)  // func() Class 调用此函数，创建一个类实例，实现的工厂内部结构体会实现Class接口
)

// 注册一个类生成工厂
func Register(name string, factory func() Commodity) {
	factoryByName[name] = factory
}

// 根据名称创建对应的类
func Create(name string) Commodity {
	if f, ok := factoryByName[name]; ok {
		return f()
	} else {
		panic("name not found")
	}
}
```

创建牛奶类，定义init注册到工厂
```go
package factory

import (
	"fmt"
	"test/design_mode/factory/base"
)

// 定义牛奶类
type Milk struct {

}

// 实现Commodity接口
func (c *Milk) Show(){
	fmt.Println("this is a Milk")
}

func init() {
	// 在启动时注册类工厂
	base.Register("Milk",func() base.Commodity {
		return new(Milk)
	})
}
```

创建面包类，定义init注册到工厂
```go
package  factory

import (
	"fmt"
	"test/design_mode/factory/base"
)

// 定义面包类
type Bread struct {

}

// 实现Commodity接口
func (c *Bread) Show(){
	fmt.Println("this is a Bread")
}

func init() {
	// 在启动时注册类工厂
	base.Register("Bread",func() base.Commodity {
		return new(Bread)
	})
}
```

使用工厂实例
```go
package main

import (
	"test/design_mode/factory/base"
	_ "test/design_mode/factory"       // 匿名引用包，自动注册
)

func main() {
	c1 := base.Create("Milk")
	c1.Show()
	c2 := base.Create("Bread")
	c2.Show()
}
```
执行结果
```go
$  go run design_mode/main.go 
this is a Milk
this is a Bread
```
