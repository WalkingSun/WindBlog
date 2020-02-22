---
layout: blog
title: Go知识记录
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
# 简介
目前正在学Go，做下记录，温故而知新，初学coding的时候可以快速翻查用法，了解原理。

# 多重赋值
多重赋值时，变量的左值和右值按从左到右的顺序赋值
```go
var a int = 100
b := 200
b,a = a,b       # 实现交换
```

# 匿名变量
匿名变量 '_'表示，使用匿名变量时，只需要在变量声明的地方使用下划线替换即可。
```golang
a,_ = Get_data()
```
匿名变量不占用空间，不会分配内存。匿名变量与匿名变量之间不会因为多次声明而无法使用。

# 数据类型
整形（int8,int16,int32,int64）、浮点型、布尔型、字符串、数组、切片、结构体、函数（go语言的一种数据类型，可对函数类型的变量进行赋值和获取）、map、通道（channel）
## 数组
```go
var variable_name [SIZE] variable_type
```
数组是一串固定长度的连续内存区域。

### 数组可以在声明时使用初始化列表进行元素设置：
```go
var team = [3]string{"hammer","soldier","mum"}
```

### 根据元素个数确定数组大小
```go
var team = [...]string{"hammer","soldier","mum"}   # ...表示让编译器确定数组大小
```

### 遍历数组
```go
for k,v := range team{
    fmt.Println(k,v)
}
```


## 切片


## map
map使用散列表（hash）实现

### 添加关联到map并访问关联和数据
map[Key_Type]Value_Type

```go
scene := make(map[string]int)
scene["route"] = 66
fmt.Println(scene["route"])
v :=scene["route2"]    //尝试查找一个不存在的键，返回的将是value_type的默认值
fmt.Println(v)

/**
66
0
*/
```

填充内容方式
```go
m := map[string]string{
    "W": "forward",
    "A": "left",
    "D": "right"
}
```
并没有使用make，而是使用大括号进行内容定义，就像json格式一样，健值对，并使用逗号分割。

###  判断map中key是否存在
```go
if _, ok := map[key]; ok {
//存在
}
```

### delete()从map中删除健值对
```go
delete(map, 键)
//map 要删除的实例
```

### 清空map中的所有元素
清空map的唯一办法就是重新make一个新的map。
不用担心垃圾回收的效率，Go中的并行垃圾回收效率比写一个清空函数高效的多。

### 能够在并发环境中使用的map——sync.Map
Go中的map在并发环境下，只读是线程安全的，同时读写线程不安全。


# 流程判断

- 条件判断 if
- 条件循环 for
- 健值循环  for range
- 分支选择 switch
switch 默认情况下 case 最后自带 break 语句，匹配成功后就不会执行其他 case，如果我们需要执行后面的 case，可以使用 fallthrough
```go
switch var1 {
    case val1:
        fallthrough
    case val2:
        ...
    default:
        ...
}
```
- 跳转 goto
- 跳出循环 break 和 继续循环 continue

## 健值循环（for range）
可以使用for range遍历数组、切片、字符串、map、及chnnel。

通过for range遍历返回值规律：
- 数组、切片和字符串返回索引和值；
- map返回健和值
- chnnel只返回通道内的值

### 遍历切片、数组
```go
for key, value := range []int{1, 2, 3, 4} {
		fmt.Printf("key%d, value %d\n",key ,value)
}
```

### 遍历获得字符
```go
	str := "hello"
	for key, value := range str {
		fmt.Printf("key%d, value 0x%x \n",key ,value)  //%x	十六进制，小写字母，每字节两个字符
	}
```

### 遍历map
```go
	m := map[string]int{
		"a" : 1,
		"b" : 2,
	}
	for key, value := range m {
		fmt.Println(key,value)
	}

```

### 遍历channel --从通道接收数据

```go
c:= make(chan int)
	go func(){
		//往通道内推送数据，然后结束并关闭通道
		c <- 1
		c <- 2
		c <- 3
		close(c)
	}()
	for v := range c{   //其实就是不断的从通道获取数据￿
		fmt.Println(v)
	}
```

# 指针
go拆分两个核心概念

- 类型指针 允许对这个指针类型的数据进行修改。传递数据使用指针，而无需拷贝数据。类型指针不能进行偏移和运算
- 切片 由指向起始元素的原始指针、元素数量和容量组成

go的指针类型变量拥有指针的高效访问，但又不会发生指针偏移，从而避免非法修改关键性数据问题。同时，垃圾回收也比较容易对不会发生偏移的指针进行检索和回收。

切片比原始指针具备更强大的特性，更为安全。切片发生越界时，运行时会报出宕机，并打出堆栈，而原始指针只会崩溃。

## 指针地址和指针类型

```go
ptr:=&v //v的类型为T  &v取地址 &取地址操作符

//v代表被取地址的变量，被取地址的v使用ptr变量进行接收，ptr的类型为*T，称作T的指针类型。
// * 代表指针
```

> 变量、指针和地址关系：每个变量都拥有地址，指针的值就是地址

## 从指针获取指针指向的值
& 获取这个变量的指针 

* 指针取值

&取出地址，*根据地址取出地址指向的值


变量、指针地址、指针变量、取地址、取值关系：
- 对变量进行取地址（&）操作，可以获得这个变量的指针变量
- 指针变量的值是指针地址
- 对指针变量进行取值（*）操作，可以获得指针变量指向的原变量的值

> *操作符根本意义就是操作指针指向的变量。当操作在右值时，就是取指向变量的值；当操作在左值时，就是将值设置给指向的变量

## 类型转换
```go
T(表达式)
```
T代表要转换的类型。、
```go
var a int32 = 1047483647
b:=int16(a)
```

## 堆栈知识
- 栈区（stack） --存储参数值、局部变量，维护函数调用关系等。
- 堆区（heap）  --动态内存区域，随时申请和释放，程序自身要对内存泄漏负责
- 全局区（静态区）  --存储全局和静态变量
- 字面量区   --常量字符串存储区
- 程序代码区   --存储二进制代码

```go
int a=o;    //全局变量
char *p1;   //全局未初始化区
main() {
    static int b=0;   //全局初始化区
    int c;  //栈
    char d[] = "abc:;  //栈
    char *p2;          //栈
    char *p3 = "hello";   //hello在常量区，p3在栈上
    p1 = （char*)malloc(10);
    p2 = （char*)malloc(20);     //分配得来的10和20字节的区域就在堆区
    strcpy(p1,"hello");        //hello放在常量区，编译器可能会将它与p3所指向的hello优化成一个地方
}
```

总体来讲，栈上的变量是局部的，随着局部空间的销毁而销毁，由系统负责。

堆上的变量可以提供全局访问，需要自行处理其声明周期。

# 关键字
## defer
defer用于资源的释放，会在函数返回之前进行调用

```go
var a,b := 1,2
c := func(a,b int) (c int){
		c  = a+b
		defer func() {
			c = c*2
		}()
		return
	}
//6
```


## 函数


## 结构体
Go使用结构体和结构体成员来描述真实世界的实体和实例对应的各种属性。

Go中的类型可以被实例化，使用new或&构造的类型实例的类型是类型的指针。

结构体成员由一系列的成员变量构成，这些成员变量也被称为"字段"。
- 字段拥有自己的类型和值；
- 字段名必须唯一；
- 字段的类型也可以是结构体，甚至是字段所在结构体的类型

Go的结构体与"类"都是符合结构体，但Go中结构体的内嵌配合接口比面向对象具有更高的扩展性和灵活性。

Go不仅结构体能拥有方法，且每种自定义类型也可以拥有自己的方法。

### 定义结构体
type 类型名struct {
   字段1 字段1类型
   字段2 字段2类型
   ...
}

### 实例化结构体————为结构体分配内存并初始化
结构体的定义只是一种内存布局的描述，只有当结构体实例化时，才会真正的分配内存。因此必须在定义结构体并实例化后才能使用结构体的字段。

实例化就是根据结构体定义的格式创建一份与格式一致的内存区域，结构体实例与实例间的内存是完全独立的。

#### 基本的实例化形式
```go
var ins T
# T 为结构体类型
#ins为结构体的实例
```

#### 创建指针类型的结构体
Go可以使用new关键字对类型（包括结构体、整形、浮点型、字符串等）进行实例化，结构体在实例化后会形成指针类型的结构体。

```go
ins := new(T)
# ins: T类型被实例化后保存到ins变量中，ins的类型为*T，属于指针。
```

Go可以像访问普通结构体一样使用"."访问结构体指针的成员。

```go
type Player struct {
    Name string
    Health_Point int 
    Magic_Point int
}
tank := new(Player)
tank.Name = "Canon"
tank.Health_Point = 300
```

#### 取结构体的地址实例化
```go
ins := &T{}
# ins为结构体的实例，类型为*T，是指针类型
```

### 初始化结构体的成员变量

#### 使用健值对初始化结构体
```go
ins := 结构体类型名{
    字段1：字段1的值
    字段2：字段2的值
    ...
}
```

#### 使用多个值的列表初始化结构体
```go
ins := 结构体类型名{
    字段1的值,
    字段2的值,
}
```

#### 初始化匿名结构体

### 构造函数————结构体和类型的一系列初始化操作的函数封装
Go的类型或结构体没有构造函数的功能。结构体的初始化过程可以使用函数封装实现。

#### 多种方式创建和初始化结构体————模拟构造函数重载



#### 带有父子关系结构体的构造和初始化————模拟父级构造调用


## 接口（interface）
接口实现者不需要关系接口会被怎样使用，调用者也不需要关心接口的实现细节。接口是一种类型，也是一种抽象结构，不会暴露所含数据的格式、类型及结构。

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

### 一个类型可以实现多个接口






















