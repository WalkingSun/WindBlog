---
layout: blog
title: Go 并发
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

# 并发
并发指在同一时间内可以执行多个任务。并发编程含义比较广泛，包含多线程编程、多进程编程及分布式程序等。本章讲解的并发含义属于多线程编程。

goroutine是由Go语言的运行时调度完成，而线程是由操作系统调度完成。

使用者分配足够多的任务，系统能自动帮助使用者把任务分配到CPU上，让这些任务尽量并发运作。这种机制在Go语言中被称为goroutine。

Go程序从main包的main()函数开始，在程序启动时，Go程序就会为main()函数创建一个默认的goroutine。

## 调整并发的运行性能（DOMAXPROCS）
传统逻辑中，开发者需要维护线程池中线程与CPU核心数量的对应关系。同样的，Go地中也可以通过runtime.GOMAXPROCS()函数做到，格式为：
```go
runtime.GOMAXPROC(逻辑cpu数量)
```

几种数值：
 - <1：不修改任何数值。
 - =1：单核心执行。
 - '>1'：多核并发执行

 runtime.Num CPU()查询CPU数量，并使用runtime.GOMAXPROCS()函数进行设置，例如：
```go
runtime.GOMAXPROC(runtime.NumCPU())
```

## 并发和并行
并发（concurrency）：把任务在不同的时间点交给处理器进行处理。在同一时间点，任务并不会同时运行。

并行（parallelism）：把每一个任务分配给每一个处理器独立完成。在同一时间点，任务一定是同时运行。

**GO在GOMAXPROCS数量与任务数量相等时，可以做到并行执行，但一般情况下都是并发执行。**

goroutine属于抢占式任务处理，已经和现有的多线程和多进程任务处理非常类似。应用程序对CPU的控制最终还需要由操作系统来管理，操作系统如果发现一个应用程序长时间大量地占用CPU，那么用户有权终止这个任务。

## 通道（channel)---在多个goruntine间通信的管道
Go语言提倡使用通信的方法代替共享内存，这里通信的方法就是使用通道（channel）

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/2020-04-18.35.17.png)

### 特性
任何时候，同时只能有一个goroutine访问通道进行发送和获取数据。goroutine间通过通道就可以通信。

通道像一个传送带或者队列，总是遵循先入先出（First In First Out）的规则，保证收发数据的顺序。
### 使用通道接收数据
通道接收同样使用“<-”操作符，通道接收有如下特性：
- 通道的收发操作在不同的两个goroutine间进行。由于通道的数据在没有接收方处理时，数据发送方会持续阻塞，因此通道的接收必定在另外一个goroutine中进行。
- 接收将持续阻塞直到发送方发送数据。如果接收方接收时，通道中没有发送方发送数据，接收方也会发生阻塞，直到发送方发送数据为止。
- 每次接收一个元素。
- 使用非阻塞方式从通道接收数据时，语句不会发生阻塞

非阻塞的通道接收方法可能造成高的CPU占用，因此使用非常少。如果需要实现接收超时检测，可以配合select和计时器channel进行

### 循环接收
通道的数据接收可以借用for range语句进行多个元素的接收操作
```go
for data := range ch {

}
```

### 单向通道
Go的通道可以在声明时约束其操作方向，如只发送或是只接收。这种被约束方向的通道被称做单向通道。


只能发送的通道类型为chan<-，只能接收的通道类型为<-chan，格式如下：
```go
var 通道实例 chan<- 元素类型            // 只能发送通道
var 通道实例 <-chan元素类型             // 只能接收通道
```
但是，一个不能填充数据（发送）只能读取的通道是毫无意义的。


### time包中的单向通道
```go
timer := time.NewTimer(time.Second)
```

timer的Timer类型定义如下：
```go
type Timer struct {
        C <-chan Time
        r runtime Timer
}
```
C通道的类型就是一种只能接收的单向通道。如果此处不进行通道方向约束，一旦外部向通道发送数据，将会造成其他使用到计时器的地方逻辑产生混乱

### 带缓冲的通道
在无缓冲通道的基础上，为通道增加一个有限大小的存储空间形成带缓冲通道

无缓冲通道保证收发过程同步。无缓冲收发过程类似于快递员给你电话让你下楼取快递，整个递交快递的过程是同步发生的，你和快递员不见不散。但这样做快递员就必须等待所有人下楼完成操作后才能完成所有投递工作。如果快递员将快递放入快递柜中，并通知用户来取，快递员和用户就成了异步收发过程，效率可以有明显的提升。带缓冲的通道就是这样的一个“快递柜”。

- 创建带缓冲通道
```go
通道实例 := make(chan通道类型,缓冲大小)
```
通道类型：和无缓冲通道用法一致，影响通道发送和接收的数据类型。

- 通道类型：和无缓冲通道用法一致，影响通道发送和接收的数据类型。
- 带缓冲通道为空时，尝试接收数据时发生阻塞。

### 通道的多路复用
多路复用通常表示在一个信道上传输多路信号或数据流的过程和技术

网线、光纤也都是基于多路复用模式来设计的，网线、光纤不仅可支持同时收发数据，还支持多个人同时收发数据。

提供了select关键字，可以同时响应多个通道的操作。select的每个case都会对应一个通道的收发过程.当收发完成时，就会触发case中响应的语句。多个操作在每次select中挑选一个进行响应.
```go
select{
        case 操作1:
                响应操作1
        case 操作2:
                响应操作2
...
default:
               
}
```

## 模拟远程过程调用（RPC）
服务器开发中会使用RPC（Remote Procedure Call，远程过程调用）简化进程间通信的过程。RPC能有效地封装通信过程，让远程的数据收发通信过程看起来就像本地的函数调用一样。

## 控制并发数

- 令牌桶的思路：使用chan的缓冲数来控制每次处理任务的最大并发数

```go
func main() {
  ch := make(chan int,100)
  for i := 0; i < 1000; i++ {
		ch <- i
    go func(){
      // deal
      time.Sleep(time.Second)
      <- ch
    }()
	}
}
```



##  并发的安全退出

有时候需要通知Gorutine停止运行，特别是当它在错误的方向上。Go语言并没有提供一个直接终止Goroutine的方法，因为这样会导致Goroutine之间的共享变量处在未定义的状态上

- 借助select及sync.WaitGroup控制

  当每个Goroutine收到退出指令退出时一般会进行一定的清理工作，但是退出的清理工作并不能保证被完成，因为main线程并没有等待各个工作Goroutine退出工作完成的机制。结合sync.WaitGroup来改进。

```go
func main() {
  cancel := make(chan bool)
  var wg sync.WaitGroup
  for i :=0; i < 10; i++ {
    wg.Add(1)
    go worker(&wg, cancel)
  }
  time.Sleep(time.Second)
  close(cancel)
  wg.Wait()
}

func worker(wg *sync.WaitGroup, cancel chan bool) {
  defer wg.Done()
  for {
    select {
      deafult:
      cancel <- cancel:
      return
    }
  }
}
```

- context包

标准库增加了一个context包，用来简化对于处理单个请求的多个Goroutine之间与请求域的数据、超时和退出等操作

```go
func main() {
  ctx, cancel := context.WithTimeout(context.Background(), 10*time.Second)
  var wg sync.WaitGroup
  for i :=0; i < 10; i++ {
    wg.Add(1)
    go worker(ctx,&wg)
  }
  time.Sleep(time.Second)
  cancel()
  wg.Wait()
}

func worker(ctx context,Context, wg *sync.WaitGroup) error {
  defer wg.Done()
  for {
    select {
      deafult:
      cancel <- ctx.Done():
      return ctx.Err()
    }
  }
}
```

当并发体超时或main主动停止工作者Goroutine时，每个工作者都可以安全退出。

当main()函数完成工作前，通过调用cancel()来通知后台Goroutine退出，这样就避免了Goroutine的泄漏。








