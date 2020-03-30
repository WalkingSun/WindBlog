---
layout: blog
title: Go interface
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

## 接口（interface）
Go中使用组合实现对象特性的描述。对象的内部使用结构体内嵌组合对象具有的特性，对外通过接口暴露能使用的特性。

Go的接口设计是非侵入式的，接口实现者不需要关系接口会被怎样使用，调用者也不需要关心接口的实现细节。接口是一种类型，也是一种抽象结构，不会暴露所含数据的格式、类型及结构。

非侵入式设计是Go语言设计师经过多年的大项目经验总结出来的设计之道。只有让接口和实现者真正解耦，编译速度才能真正提高，项目之间的耦合度也会降低不少

### 接口声明

```go
type 接口类型名 interface{
    方法名1（参数列表1） 返回值列表1
    方法名2（参数列表2） 返回值列表2
    ...
}
```

### 实现接口
```go
package main

import (
	"database/sql"
	"fmt"
)

// 定义一个数据写入器
type DataWriter interface {
	WriteData(data interface{}) error
}

// 定义文件结构，用于实现Data Write
type file struct {
	Dsn string
	conn *sql.DB
}

// 实现DataWriter方法
func (d *file) WriteData(data interface{}) error{
	// 模拟数据写入
	fmt.Println("Write Data:",data)
	return nil
}

func main(){
	//实例化file
	f := new(file)

	// 声明一个DataWriter的接口
	var writer DataWriter

	// 接口赋值file，也就是*file类型
	writer = f

	// 使用DataWriter接口进行数据写入
	writer.WriteData("data")
}
```

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/QQ20200101-212508@2x.png)

> 函数名不一致导致报错

试图修改file结构的WriteData()方法名
```go
cannot use f (type *file) as type DataWriter in assignment:
	*file does not implement DataWriter (missing WriteData method)
```

> 实现接口的方法签名不一致导致的报错
```func (d *file) WriteData(data int) error```
```go
cannot use f (type *file) as type DataWriter in assignment:
	*file does not implement DataWriter (wrong type for WriteData method)
		have WriteData(int) error
		want WriteData(interface {}) error
```

### 类型和接口关系
类型与接口之间有一对多和多对一关系。

#### 一个类型可以实现多个接口
一个类型可以同时实现多个接口，而接口间彼此独立，不知道对方的实现。

网络上的两个程序通过一个双向的通信连接实现数据的交换，连接的一端称为一个Socket。Socket能够同时读取和写入数据，这个特性与文件类似。因此，开发中把文件和Socket都具备的读写特性抽象为独立的读写器概念。

Socket和文件一样，在使用完毕后，也需要对资源进行释放

```go
type Socket struct {

}

func (s *Socket) Write(p []byte) (n int, err error) {
        return 0,nil
}

func (s *Socket) Close() error {
        return nil 
}
```
Socket结构的Write()方法实现了io.Writer接口：
```go
type Write interface {
        Write(p []byte) (n int, err error)
}
```
同时，Socket结构也实现了io.Closer接口
```go
type Closer interface {
        Close() error
}
```

使用Socket实现的Writer接口的代码，无须了解Writer接口的实现者是否具备Closer接口的特性。同样，使用Closer接口的代码也并不知道Socket已经实现了Writer接口


![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/WX20200330-213252@2x.png)

#### 多个类型实现相同的接口


