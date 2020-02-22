---
layout: blog
title: Go函数
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


