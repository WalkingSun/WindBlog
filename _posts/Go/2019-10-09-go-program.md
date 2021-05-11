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
b,a = a,b       // 实现交换
```

# 常量

## iota

**golang语言的常量计数器,只能在常量的表达式中使用。**

iota在const关键字出现时将被重置为0(const内部的第一行之前)，const中每新增一行常量声明将使iota计数一次(iota可理解为const语句块中的行索引)。

- **iota只能在常量的表达式中使用**

- **每次 const 出现时，都会让 iota 初始化为0.【自增长】**

  ```go
  const a = iota 			// a=0
  const (
    b = iota          //b=0
    c                 //c=1
  )
  ```

- **自定义类型**,如time包

  ```go
  type Weekday int
  
  const (
      Sunday Weekday = iota
      Monday
      Tuesday
      Wednesday
      Thursday
      Friday
      Saturday
  )	
  ```

- **可跳过的值**

  ```go
  type AudioOutput int
  
  const (
      OutMute AudioOutput = iota // 0
      OutMono                       // 1
      OutStereo                     // 2
      _
      _
      OutSurround                // 5
  )
  ```

  

# 匿名变量

匿名变量 '_'表示，使用匿名变量时，只需要在变量声明的地方使用下划线替换即可。
```go
a,_ = Get_data()
```
匿名变量不占用空间，不会分配内存。匿名变量与匿名变量之间不会因为多次声明而无法使用。

# 数据类型
整形（int8,int16,int32,int64）、浮点型、布尔型、字符串、数组、切片、结构体、函数（go语言的一种数据类型，可对函数类型的变量进行赋值和获取）、map、通道（channel）
## 字符

- unit8类型，或者叫byte类型，ASCII码的一个字符；
- rune类型（int32），代表一个UTF-8字符。使用fmt.sprintf中的“%T”动词可以输出变量的实际类型。

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
var team = [...]string{"hammer","soldier","mum"}   // ...表示让编译器确定数组大小
```

### 遍历数组
```go
for k,v := range team{
    fmt.Println(k,v)
}
```


## 切片
[https://www.cnblogs.com/followyou/p/12349883.html](https://www.cnblogs.com/followyou/p/12349883.html)

## map
[https://www.cnblogs.com/followyou/p/12355313.html](https://www.cnblogs.com/followyou/p/12355313.html)


## 函数
[https://www.cnblogs.com/followyou/p/12348259.html](https://www.cnblogs.com/followyou/p/12348259.html)

## 结构体
[https://www.cnblogs.com/followyou/p/12358919.html](https://www.cnblogs.com/followyou/p/12358919.html)

## 接口（interface）
[https://www.cnblogs.com/followyou/p/12601846.html](https://www.cnblogs.com/followyou/p/12601846.html)

# 指针
go拆分两个核心概念

- 类型指针 允许对这个指针类型的数据进行修改。传递数据使用指针，而无需拷贝数据。类型指针不能进行偏移和运算
- 切片 由指向起始元素的原始指针、元素数量和容量组成

go的指针类型变量拥有指针的高效访问，但又不会发生指针偏移，从而避免非法修改关键性数据问题。同时，垃圾回收也比较容易对不会发生偏移的指针进行检索和回收。

切片比原始指针具备更强大的特性，更为安全。切片发生越界时，运行时会报出宕机，并打出堆栈，而原始指针只会崩溃。

## 指针地址和指针类型

```go
ptr := &v //v的类型为T  &v取地址 &取地址操作符

//v代表被取地址的变量，被取地址的v使用ptr变量进行接收，ptr的类型为*T，称作T的指针类型。
// * 代表指针
```

> 变量、指针和地址关系：每个变量都拥有地址，指针的值就是地址

## 从指针获取指针指向的值
& 获取这个变量的指针 

* 指针取值

&取出地址，*根据地址取出地址指向的值（解引用）


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
b := int16(a)
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
    p1 = (char*)malloc(10);
    p2 = (char*)malloc(20);     //分配得来的10和20字节的区域就在堆区
    strcpy(p1,"hello");        //hello放在常量区，编译器可能会将它与p3所指向的hello优化成一个地方
}
```

总体来讲，栈上的变量是局部的，随着局部空间的销毁而销毁，由系统负责。

堆上的变量可以提供全局访问，需要自行处理其声明周期。

# 注意

- struct指针调用非引用类型的方法会自动解引用，如果是个nil指针会panic；

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
c := make(chan int)
go func(){
		//往通道内推送数据，然后结束并关闭通道
		c <- 1
		c <- 2
		c <- 3
		close(c)
}()

for value :=range c {
		...
}
```
# 编译
```bash
export GOPATH=/home/golang/code
go build -o main /goinstall                 # 按包编译

go build -o mian main.go lib.go             # 文件列表编译

```

## go run
命令会编译源码，并且直接执行源码的main()函数，不会在当前目录留下可执行文件。

go run不会在运行目录下生成任何文件，可执行文件被放在临时文件中被执行，工作目录被设置为当前目录。
在go run的后部可以添加参数，这部分参数会作为代码可以接受的命令行输入提供给程序。
go run不能使用“go run + 包”的方式进行编译，如需快速编译运行包，需要使用如下步骤来代替：
- 使用go build生成可执行文件。
- 运行可执行文件。

## go install
功能和go build类似，附加参数绝大多数都可以与go build通用。go install只是将编译的中间文件放在GOPATH的pkg目录下，以及固定地将编译结果放在GOPATH的bin目录下。

go install的编译过程有如下规律：
- go install是建立在GOPATH上的，无法在独立的目录里使用go install。
- GOPATH下的bin目录放置的是使用go install生成的可执行文件，可执行文件的名称来自于编译时的包名。
- go install输出目录始终为GOPATH下的bin目录，无法使用-o附加参数进行自定义。
- GOPATH下的pkg目录放置的是编译期间的中间文件。

## go test
go test指定文件时默认执行文件内的所有测试用例。可以使用-run参数选择需要的测试用例单独执行

-v，可以让测试时显示详细的流程

-run跟随的测试用例的名称支持正则表达式，使用-run Test A$即可只执行Test A测试用例（假设TestA、TestAk、TestB、TestC会执行TestA、TestAk）。

```bash
go test -v -run testA main_test.go
```
## make、new
分配内存

new(T)会为T类型的新值分配已置0的内存空间，并返回地址（指针）。适用值类型（数组、结构体）。

make(T,args)返回初始化之后的T类型的值，这个值是经过初始化后的T的引用。只适用slice、map、channel。

