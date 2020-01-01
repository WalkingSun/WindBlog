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
return 表达式；  函数在返回时，是先执行表达式，然后在返回.

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

## 可变参数————参数数量不固定的函数形式
Go支持可变参数特性，函数声明和调用时没有固定数量的参数，同时也提供了一套方法进行可变参数的多级传递。

```go
func 函数名(固定参数列表, v ...T) (返回参数列表) {
    函数体
}
```

特性：
- 可变参数放在函数列表的末尾
- v为可变参数变量，类型为[]T,也就是拥有多个T元素的类型切片，v和T之间由'...'组成
- T为可变参数的类型，当T为interface{}时，传入的可以是任意类型。

fmt.Println在使用时，传入值类型不受限制；
```go
func Println(a ...interface{}) (n int,err error) {
    return Fprintln(os.Stdout,a...)
}    
```

```go
fmt.Println(5,"hello", &struct{ a int }{1}, true)
```

## defer 延迟执行语句
defer语句会将其后面跟随的语句进行延迟处理。在defer归属的函数即将返回时，将延迟处理的额语句按defer的逆序进行执行。
就是说defer的语句最后被执行，最后被defer的语句，最先被执行。

```go
package main

import (
    "fmt"
)

func main() {
    fmt.Println("defer degin")
    
    // 将defer放入延迟调用栈
    defer fmt.Println(1)
    
    defer fmt.Println(2)
    
    defer fmt.Println(3)
    
    fmt.Println("defer end")
}


/*
defer degin
defer end
3
2
1
*/
```

代码的延迟顺序与最终的执行顺序是反向的。

延迟调用是在defer所在函数结束时进行，函数结束可以是正常返回时，也可以是发生宕机时。

### 应用场景
使用延迟执行语句在函数退出时释放资源

比如打开和关闭文件、加锁和解锁等。在这些操作中，最容易忽略的就是在每个函数退出处正确的释放和关闭资源。

## 处理运行时发生的错误

GO的错误处理思想和设计特征：
- 一个可能造成错误的函数，需要返回值中返回一个错误接口(error)。如果调用是成功的，错误接口将返回nil，否则返回错误。
- 在函数调用后需要检查错误，如果发生错误，进行必要的错误处理。

Go开发者将错误处理视为正常开发必须实现的环节，正确处理每一个可能发生错误的函数。

### net包中的例子
net.Dial()是GO系统包net其中的一个函数，一般用于创建一个Socket连接。

```go
// return定义了错误返回error
func Dial(network, address string) (Conn, error) {
    var d Dialer
    return d.Dial(network, address）
}
```
### 错误接口定义
```go
type error interface {
    Error() string
}    
```
所有符合Error() strign格式的方法，都能实现错误接口。

Error()方法返回错误的具体描述，使用者可以通过这个字符串知道发生了什么错误。

### 自定义一个错误
```go
var error = errors.New("this is an error")
```
错误字符串由于相对固定，一般在包作用域声明，应尽量减少在使用时直接使用error.New返回。

> errors包
```go
func New(text string) error {
    return &error String{text}
}
    
// 错误字符串
type error String struct {
    s String 
}
    
// 返回发生任何错误
func (e *error String) Error() string {
    return e.s
}    
```

- 错误定义
```go
package main

import (
	"errors"
	"fmt"
)

func Sqrt(f float64) (float64 , error){
	if f<0 {
		return 0, errors.New("math: square root of negative number")    //errors.New 可返回一个错误信息
	}

	//实现
	return f,nil
}

//定义一个DivideError结构
type DivideError struct {
	dividee int
	divider int
}

// 实现Error接口
func (de *DivideError) Error() string{
	strFormat :=`
	cannot proceed, the divider is zero.
	dividee: %d
	divider: 0
`
	return fmt.Sprintf(strFormat,de.dividee)
}

// 定义int类型除法运算 函数
func Divide(varDividee int,varDivider int) (result int, errorMsg string) {
	if varDivider == 0 {
		dData := DivideError{
			dividee: varDividee,
			divider: varDivider,
		}
		errorMsg = dData.Error()
		return
	}else{
		return varDividee / varDivider,""
	}
}


func main(){
	/*
	error类型是一个接口类型，定义如下
	type error interface {
		Error() string
	}
	*/

	/*
	_ ,err := Sqrt(-1)

	if err!=nil{
		fmt.Println(err)
	}
	 */

	if result, errorMsg := Divide(100,10); errorMsg == "" {
		fmt.Println(result)
	}

	if _, errorMsg := Divide(100,0); errorMsg != "" {
		fmt.Print(errorMsg)
	}

}

```

- 在解析中使用自定义错误
使用errors.New定义的错误字符串的错误类型是无法提供丰富的错误信息的。

如果需要携带错误信息返回，就需要借助自定义结构体实现错误接口。

```go
package main

import (
    "fmt"
)
    
// 声明一个解析错误
type Parse_Error struct {
	Filename string
	Line int            // 行号

}

// 实现error接口，返回错误描述
func (e *Parse_Error) Error() string {
	return fmt.Sprintf("%s:%d", e.Filename, e.Line)
}

// 创建一些解析错误
func new_Parse_Error(filename string, line int) error {
	return &Parse_Error{filename, line}
}

func main() {

    var e error
    // 创建一个错误实例，包含文件名和行号
    e = new_Parse_Error("main.go",1)
    
   	fmt.Println(e.Error())
   
   	// 根据错误接口的具体类型，获取详细的错误信息
   	switch detail := e.(type) {
   	    case *Parse_Error:
    		fmt.Printf("Filename: %s Line: %d\n",detail.Filename,detail.Line)
    	default:
    		fmt.Printf("other error")
    }

}
    
/*
main.go:1
Filename: main.go Line: 1
*/    
```

## Panic 宕机 ————程序终止运行
Go的类型系统会在编译时捕获很多错误，但有些错误只能在运行时检查，如数组访问越界、空指针引用等。这些运行时错误会引起painc异常。

### 手动触发宕机
Go可以在程序中手动触发宕机，让程序崩溃，这样开发者可以及时的发现粗无，同时减少可能的损失。

GO程序在宕机时，会将堆栈和goroutine信息输出到控制台，所以宕机也可以方便的知晓发生错误的位置。

触发宕机：
```go
package main
func main() {
    panic("crash")
}

/*
panic: crash

goroutine 1 [running]:
main.main()
	/website/go/src/test/panic.go:3 +0x39
exit status 2
*/
```

panic()的声明：
```go
func panic(v interface{})    // 参数可以是任意类型
```

### 运行依赖的必备资源缺失时主动触发宕机
regexp是Go的正则表达式包，正则表达式需要编译后才能使用，而且编译必须是成功后的，表示正则表达式可用。

编译正则表达式有两种：
- func Compile(expr string) (*Regexp, error)
- func Must Compile(str string) *Regexp

当编译正则表达式发生错误时，使用panic触发宕机，该函数适用于直接适用正则表达式而无需处理正则表达式错误的情况。

```go
func Must Compile(str string) *Regexp {
    regexp, error := Compile(str)   // 调用Compile()是编译正则表达式的入口韩素，该函数返回编译好的正则表达式对象和错误。
    if error != nil {
        panic('regexp: Compile(' + quote(str)+ '):' +error.Error())
    }
    return regexp   
}
```
手动宕机进行报错的方式不是一种偷懒的方式，反而能迅速报错，终止程序继续运行，防止更大的错误产生。

### 在宕机时触发延迟执行语句
当panic()触发的宕机发生时，panic()后面的代码将不会被执行，但在panic()函数前面已经运行的defer语句依然会在宕机发生时发生作用。

```go
package main

import "fmt"

func mian() {
    defer fmt.Println("宕机后要做的事情1")
    defer fmt.Println("宕机后要做的事情2")
    panic("宕机")
}   
/*
宕机后要做的事情2
宕机后要做的事情1
panic: 宕机

goroutine 1 [running]:
main.main()
	/website/go/src/test/panic.go:10 +0x140
exit status 2
*/ 
```

## Recover
通常来说，不应该对panic异常做任何处理，但有时，也许我们可以从异常中恢复，至少我们可以在程序崩溃前，做一些操作

Go没有异常系统，其使用panic触发宕机类似于其他语言的抛出异常，那么recover的宕机恢复机制就对应try/catch机制。

### 让程序在崩溃时继续执行

```go
package main

import (
	"fmt"
	"runtime"
)

// 崩溃时需要传递的上下文信息
type panic_Context struct {
	function string     // 所在函数
}

// 保护方式运行一个函数
func Protect_Run(entry func()) {
	// 延迟处理的函数
	defer func() {

		// 发生宕机，获取panic传递的上下文并打印
		err := recover()

		switch err.(type) {
		case runtime.Error:         // 运行时错误
			fmt.Println("runtime error:",err)
		default:
			fmt.Println("error:", err)
		}
	}()

	entry()
}

func main() {
	fmt.Println("运行前")

	// 允许一段手动触发的错误
	Protect_Run(func() {

		fmt.Println("手动宕机前")

		// 使用panic传递上下文
		panic(&panic_Context{
			"手动触发panic",
		})

		fmt.Println("手动宕机后")
	})

	// 故意造成指针访问错误
	Protect_Run(func() {
		fmt.Println("赋值宕机前")

		var a *int
		*a = 1

		fmt.Println("赋值宕机后")
	})

	fmt.Println("运行后")
}

/*
运行前
手动宕机前
error: &{手动触发panic}
赋值宕机前
runtime error: runtime error: invalid memory address or nil pointer dereference
运行后
*/       
```

### panic和recover的关系
panic和defer组合有如下特性：
- 有panic没recover，程序宕机
- 有panic也有recover捕获，程序不会宕机。执行完对应的defer后，从宕机点退出当前函数后继续执行。

> panic/recover能模拟其他语言的异常机制，但并不建议代表编写普通函数经常性使用这个特性。

在panic触发的defer函数内，可以继续调用panic，进一步将错误外抛直到程序整体崩溃。

如果想再捕获错误时设置当前函数的返回值，可以对返回值使用命名返回值方式直接进行设置。


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






















