---
layout: blog
title: Go初学之路
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
## 声明切片
var name []T

- T 代表切片类型对应的元素类型

切片默认指向一段连续内存区域，可以是数组，也可以是数组本身

从连续区域生成切片是常规的操作,格式：
```go
slice [开始位置:结束位置]
```

```go
var a = [3]int{1,2,3}
b := a[1,2]
```

从数据或切片生成的新的切片具有以下特性：
- 取出的元素数量为：结束位置-起始位置；
- 取出元素不包括结束位置对应的索引，切片最后一个元素你用slice[len(slice)]获取；
- 当缺省开始位置时，表示从连续区域开头到结束位置；
- 当缺生结束位置时，表示从开始位置到整个连续区域末尾；
- 两者同时缺省时，与切片本身等效；
- 两者同时为0，等效于空切片，一般用于切片复位；
- 超界会报错

## 重置切片，清空拥有的元素
```go
a :=[]int{1,2,3}
fmt.Println(a[0:0)
//[]
```

## make()函数制造切片
```go
make([]T,len,cap)
```
- len : 长度
- cap : 容量

* 切片不一定必须经过make() 函数才能使用。生成切片、声明后使用append（）函数均可以正常使用切片。

## append动态添加元素
每个切片会指向一片内存空间，这片空间容纳容量的元素，超过容量，切片就会"扩容"。"扩容"操作往往发生在append调用时。
```go
var car []string
car = append(car,"Old Driver")

//添加多个元素
car = append(car,"ice","Monk")

//添加切片
team := []string{"Pig","Flyingcake","Chicken"}
car = append(car,team...)

fmt.PrintLn(car)
```

切片的增长规律，参考：https://www.jianshu.com/p/54be5b08a21c

简单的理解如下：

 a. 当需要的容量超过原切片容量的两倍时，会使用需要的容量作为新容量。

 b. 当原切片长度小于1024时，新切片的容量会直接翻倍。而当原切片的容量大于等于1024时，会反复地增加25%，直到新容量超过所需要的容量。

> 切片底层是数组逻辑的实现，切片在扩充容量时，会产生一个新数组

为了避免因为切片是否发生扩容的问题导致bug，最好的处理办法还是在必要时使用 copy 来复制数据，保证得到一个新的切片，以避免后续操作带来预料之外的副作用

## 复制切片元素到另一个切片
copy()函数，可以迅速的讲一个切片的数据复制到另一个切片空间中。
```go
copy( dest Slice, src Slice []T ) int
```

copy 的返回值表示实际发生复制的元素个数。
```go
package main

import "fmt"

func main()  {

	//引用切片数据
	ref_Data := src_Data

	//预分配足够多的元素切片
	copy_data := make([]int,element_Count)
	//将数据赋值到新的切片空间中
	copy(copy_data,src_Data)

	//修改原始数据的第一个元素
	src_Data[0] = 999

	//打印引用切片的第一个元素
	fmt.Println(ref_Data[0])

	//打印复制切牌呢的第一个和最后一个元素
	fmt.Println(copy_data[0],copy_data[element_Count-1])

	// 复制原始数据从4到6（不包含）
    copy(copy_data,src_Data[4:6])

	for i :=0; i < 5; i++ {
		fmt.Printf("%d ",copy_data[i])
	}
}


/*
  999
  0 999
  4 5 2 3 4
  */
```
复制空间 独立空间。

## 从切片中删除元素
GO并没有对删除切片元素提供的专门语法，需要使用切片本身的特性来删除元素。

```go
package main

import "fmt"

func main()  {

    seq := []string{"a", "b", "c", "d", "e"}
    //指定删除位置
    index := 2

	//查看删除位置之前的元素和之后的元素
	fmt.Println(seq[:index], seq[index+1:])

	//将删除点前后的元素连接起来
	seq = append(seq[:index], seq[index+1:]...)

	fmt.Println(seq)
}	
```

Go中删除元素的本质：是以删除元素为分界点，将前后两个部分的内存重新连接起来。

## map
map使用散列表（hash）实现


# 流程判断

- 条件判断 if
- 条件循环 for
- 健值循环  for range
- 分支选择 switch
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


# 函数
## 声明函数
```go
func 函数名(参数列表)（返回参数）{
    函数体    
}
``` 

### 参数类型简写
```go
func add(a ,b int) int{
    return a + b
} 
```

### 函数返回值
Go支持多返回值
```go
conn, err := connect To Network()
```

### 带有变量名的返回值
```go
func named Ret Values() (a, b int){
    a = 1
    b = 2
    return
}

//1,2
```

return 可以不填写返回值列表，也可以填写。

```go
func named Ret Values() (a, b int){
    a = 1
    b = 2
    return a,3
}
//1,3
```
>return 表达式；  函数在返回时，是先执行表达式，然后在返回.

所以上述代码 3赋给了b，最终返回1，3

## 函数变量----把函数作为值保存到变量中
```go
package main

import (
    "fmt"
)

func fire() {
    fmt.Println("fire")
}

func main() {
    var f func()
    f = fire
    f()
}
```

## 字符串的链式处理-----操作与数据分离的设计技巧


## 匿名函数

### 定义
```go
func(参数列表) (返回参数列表) {
    函数体
}
```

#### 定义时调用
```go
func(data int) {
    fmt.Println("hello", data)
}(100)
```

#### 将匿名函数赋给变量
```go
// 将匿名函数体保存到f()中
f := func(data int) {
    fmt.Println("hello", data)
}

f(100)
```

### 匿名函数作为回调函数
实现对切片的遍历操作，遍历中访问每一个元素的操作使用匿名函数来实现。
```go
package main

import (
	"fmt"
)

//遍历切片的每一个元素，通过给定函数进行元素访问
func visit(list []int, f func(int)) {

	for _, v :=range list {
		f(v)
	}
}

func main() {

	//使用匿名函数打印切片内容
	visit([]int{1, 2, 3, 3}, func(v int){
		fmt.Println(v)
	})
}

```

### 使用匿名函数实现操作封装 
```go
//定义标签 String定义了一个有指定名字，默认值，和用法说明的string标签
var skill_Param = flag.String("skill", "", "skill tperform")

//遍历切片的每一个元素，通过给定函数进行元素访问
func visit(list []int, f func(int)) {

	for _, v :=range list {
		f(v)
	}
}

func main() {

	flag.Parse()  //解析命令行参数并传入到定义好的标签

	var skill = map[string]func(){
		"fire": func(){
			fmt.Println("chicken fire")
		},
		"run": func() {
			fmt.Println("soldier run")
		},
		"fly": func() {
			fmt.Println("angel fly")
		},
	}


	if f, ok := skill[*skill_Param]; ok {
		f()
	} else {
		fmt.Println("skill not found")
	}
}
```

## 函数类型实现接口----把函数作为接口来调用

### 结构体实现接口
```go
package main

import (
	"fmt"
)

type Invoker interface {
	//定义一个需要实现的Call方法
	Call(interface{})
}
// 接口需要实现Call方法，调用时会传入一个interface{}类型的变量（表示任意类型的值）


// 结构体实现接口

//结构体类型
type Struct struct {

}

//实现Invoker的Call  *Struct指针类型
func (s *Struct) Call(p interface{}) {
	fmt.Println("from struct", p)
}

func main() {
	// 声明接口变量
	var invoker Invoker

	p := "hello"

	//实例化结构体
	s := new(Struct)   // 等价于  &Struct{}

	//将实例化的结构体赋给Incoker接口
	invoker = s

	//使用接口调用实例化结构体的方法Struct.Call
	invoker.Call(p)
}

// from struct hello
```

### 函数体实现接口
```go
    // 函数定义类型
    type Func_Caller func(interface{})

    // 实现Invoker的Call
    func (f Func_Caller) Call(p interface{}) {
    
        //调用f()函数本体
        f(p)
    }

    //声明接口变量
	var invoker Invoker

	// 将匿名函数转为Func_Caller类型，再赋值给接口
	invoker = Func_Caller(func(v interface{}) {
		fmt.Println("from function", v)
	})

	// 使用接口调用FUnc_Caller.Call，内部会调用函数本体
	invoker.Call("hello")

// from function hellp
```

### HTTP包例子
HTTP包中包含有Handler接口定义：
```go
type Handler interface {
    Serve HTTP(Response Writer, *Request)
}
```
Handler用于定义每个HTTP的请求和相应的处理过程。

也可以用处理函数实现接口
```go
type Handler_Func func(Response Writer, *Request)
 
func (f Handler_Func) Serve HTTP(w Response_Write, r *Request) {
    f(W, r)
}
```

## 闭包（Closure）————引用了外部变量的匿名函数
闭包是引用了自由变量的函数，被引用的自由变量和函数一同存在，即使已经离开了自由变量的环境也不会被释放或者删除，在闭包中可以继续使用这个自由变量。

函数+引用环境=闭包

同一个函数与不同引用环境组合，可以形成不同的实例。

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/QQ20191208-211301@2x.png)

一个函数类型就像结构体一样，可以被实例化。函数本身不存住任何信息，只有与引用环境结合后形成的闭包才具有"记忆性"。
函数是编译器静态的概念，而闭包是运行期动态的概念。

### 在闭包内部修改引用的变量
闭包对它作用域上部变量的引用可以进行修改，修改引用的变量就会变量进行实际修改。
```go
str := "hello world"

foo := func() {

    // 匿名函数中访问str
    str =  "hello dude"
}

// 调用匿名函数
foo()
```

### 闭包的记忆效应
被捕获到闭包中的变量让闭包本身拥有了记忆效应，闭包中的逻辑可以修改闭包捕获的变量，变量会跟随闭包生命期一直存在，闭包本身就如同变量一样拥有的记忆效应。
```go
package main

import (
	"fmt"
)

// 提供一个值，每次调用函数会指定对值进行累加
func Accumulate(value int) func() int {

	//返回一个闭包
	return func() int {

		// 累加
		value++

		// 返回一个累加值
		return value
	}
}

func main() {
	// 创建一个累加器，初始值为1
	accumulator := Accumulate(1)

	// 累加1并打印
	fmt.Println(accumulator())

	fmt.Println(accumulator())

	// 打印累加器的函数地址
	fmt.Printf("%p\n", accumulator)

	// 创建一个累加器，初始值为1
	accumulator2 := Accumulate(10)

	// 累加1并打印
	fmt.Println(accumulator2())

	// 打印累加器的函数地址
	fmt.Printf("%p\n", accumulator2)

	// 再次打印第一个累加器的值
	fmt.Println(accumulator())

	/*
	2
	3
	0x109b1f0
	11
	0x109b1f0
	4
	*/
}    
```

### 闭包实现生成器
闭包的记忆效应进程被用于实现类似于设计模式中工厂模式中的生成器。

```go
package main

import (
	"fmt"
)

//创建一个玩家生成器，输入名称，输出生成器
func palyer_Gen(name string) func() (string, int) {
	// 血量一直为150
	hp := 150      //闭包具有一定封装性，hp是palyer Gen的局部变量。外部无法直接访问及修改这个变量

	// 返回创建的闭包
	return func() (string, int) {

		// 将变量引用到闭包中
		return name, hp
	}
}

func main() {
	//创建一个玩家生成器
	generator := palyer_Gen("hign nooon")

	// 返回玩家的名字和血量
	name, hp := generator()

	// 打印值
	fmt.Println(name, hp)
}
```

## 可变参数



## Panic异常
Go的类型系统会在编译时捕获很多错误，但有些错误只能在运行时检查，如数组访问越界、空指针引用等。这些运行时错误会引起painc异常。

## Recover
通常来说，不应该对panic异常做任何处理，但有时，也许我们可以从异常中恢复，至少我们可以在程序崩溃前，做一些操作

































