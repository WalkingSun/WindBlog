---
layout: blog
title: Go View Question
categories: [Go, 知识点]
description: 熟悉
keywords: Go
---

# 内存分区

程序没有加载到内存前，可执行程序内部已经分配好三段信息，执行```size 二进制执行文件```，**代码区（text）**、**数据区（data）**和**未初始化数据区（bss）**3 个部分。通常将data和bss合起来叫做**静态区**或**全局区**。

了解下内存分区作用：

### 代码区（text）

> 存放 CPU 执行的机器指令。通常代码区是可共享的（即另外的执行程序可以调用它），使其可**共享**的目的是对于频繁被执行的程序，只需要在内存中有一份代码即可。代码区通常是**只读**的，使其只读的原因是防止程序意外地修改了它的指令。另外，代码区还规划了局部变量的相关信息。

###  全局初始化数据区/静态数据区（data）

> 该区包含了在程序中明确被初始化的全局变量、已经初始化的静态变量（包括全局静态变量和局部静态变量）和常量数据（如字符串常量）。

### 未初始化数据区（bss）

> 存入的是全局未初始化变量和未初始化静态变量。未初始化数据区的数据在程序开始执行之前被内核初始化为 0 或者空（nil）。

> 程序在加载到内存前，代码区和全局区(data和bss)的大小就是固定的，程序运行期间不能改变。
>
> 然后，运行可执行程序，系统把程序加载到内存，除了根据可执行程序的信息分出代码区（text）、数据区（data）和未初始化数据区（bss）之外，还额外增加了**栈区**、**堆区**。

### 栈区（stack）

> 栈是一种先进后出的内存结构，由编译器自动分配释放，存放函数的参数值、返回值、局部变量等。
>
> 在程序运行过程中实时加载和释放，因此，局部变量的生存周期为申请到释放该段栈空间。

### 堆区（heap）

> 堆是一个大容器，它的容量要远远大于栈，但没有栈那样先进后出的顺序。用于动态内存分配。堆在内存中位于BSS区和栈区之间。
>
> 根据语言的不同，如C语言、C++语言，一般由程序员分配和释放，若程序员不释放，程序结束时由操作系统回收。
>
> Go语言、Java、python等都有垃圾回收机制（GC），用来自动释放内存。

![image-20210504104908978](/Users/zhaoyu/Library/Application%20Support/typora-user-images/image-20210504104908978.png)



# golang逃逸分析

逃逸分析是指分析指针动态范围的方法，它同编译器优化原理的指针分析和外形分析相关联。当变量（或者对象）在方法中分配后，其指针有可能被返回或者被全局引用，这样就会被其他过程或者线程所引用，这种现象称作指针（或者引用）的逃逸(Escape)。

编程中常见的两种逃逸情景：

​    1，函数中局部对象指针被返回（不确定被谁访问）

​     2，对象指针被多个子程序（如线程 协程）共享使用

```go
#  (-m打印逃逸分析信息，-l禁止内联编译)
go run -gcflags "-m -l" main.go
```

## 为什么要做逃逸分析

​    开始我们提到go语言中对象内存的分配不是由语言运算符或函数决定，而是通过逃逸分析来决定。为什么要这么干呢？其实说到底还是为了优化程序。函数中生成一个新对象：

1，如果分配到栈上，待函数返回资源就被回收了

2，如果分配到堆上，函数返回后交给gc来管理该对象资源

栈资源的分配及回收速度比堆要快，所以逃逸分析最大的好处应该是减少了GC的压力。

## 逃逸分析场景

### 栈空间不足逃逸

当对象大小超过的栈帧大小时（详见go内存分配），变量对象发生逃逸被分配到堆上。

### 指针逃逸

- **在某个函数中new或字面量创建出的变量，将其指针作为函数返回值，则该变量一定发生逃逸。**

```go
func test() *User{
    a := User{}
    return &a
}

/**
# command-line-arguments
./main.go:14:2: moved to heap: a
**/
```

- **被已经逃逸的变量引用的指针，一定发生逃逸**

  ```go
  type User struct {
  	Username string
  	Password string
  	Age      int
  }
  
  func main() {
  	a := "aaa"
  	u := &User{a, "123", 12}
  	Call1(u)
  }
  
  func Call1(u *User) {
  	fmt.Printf("%v",u)
  }
  ```

  查看fmt.Printf实现方法，pp是以第一种返回指针的形式逃逸了。然后fmt.Printf里的参数被p指针引用了，所以它是以第二种被逃逸指针引用而逃逸。

  

  ```go
  p := newPrinter()
  
  // newPrinter allocates a new pp struct or grabs a cached one.
  func newPrinter() *pp {
  p := ppFree.Get().(*pp)
  ...
  p.fmt.init(&p.buf)
  return p
  }
  ```

- **被指针类型的slice、map和chan引用的指针一定发生逃逸**

  ```go
  func main() {
  	a := make([]*int,1)
  	b := 12
  	a[0] = &b
  }
  ```

> stack overflow上有人提问为什么使用指针的chan比使用值的chan慢30%，答案就在这里：使用指针的chan发生逃逸，gc拖慢了速度。问题链接[https://stackoverflow.com/questions/41178729/why-passing-pointers-to-channel-is-slower](https://link.zhihu.com/?target=https%3A//stackoverflow.com/questions/41178729/why-passing-pointers-to-channel-is-slower)

**必然不会逃逸**的情况：

- 指针被未发生逃逸的变量引用；
- 仅仅在函数内对变量做取址操作，而未将指针传出；

有一些情况**可能发生逃逸，也可能不会发生逃逸**：

- 将指针作为入参传给别的函数；这里还是要看指针在被传入的函数中的处理过程，如果发生了上边的三种情况，则会逃逸；否则不会逃逸；

### 闭包引用逃逸

```go
func Fibonacci() func() int {
	a, b := 0, 1
	return func() int {
		a, b = b, a+b
		return a
	}
}
```

Fibonacci()函数返回一个函数变量赋值给f，f就成了一个闭包。闭包f保存了a b的地址引用，所以每次调用f()后ab的值发生变化。ab发生逃逸。

### 动态类型逃逸

当对象不确定大小或者被作为不确定大小的参数时发生逃逸。



逃逸分析是编译器在静态编译的时候，分析对象的生命周期及引用情况来决定对象内存分配到堆上还是栈上，由于栈内存分配较堆快且栈内存回收较快（无需gc），编译器以此来优化程序性能。

# 参考

https://juejin.cn/post/6844904005198413831#heading-0 Go内存原理详解

https://zhuanlan.zhihu.com/p/91559562 Golang 逃逸分析

https://studygolang.com/articles/21788 GO语言变量逃逸分析
