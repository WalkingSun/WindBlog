---
layout: blog
title: Goroutine并发控制
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

# 创建协程
```go
    jobCount := 10
	// sync.WaitGroup 监控所有协程的状态，从而保证主协程结束时所有的子协程已经退出
	group := sync.WaitGroup{}
	for i:=0;i < jobCount;i++ {
		group.Add(1)
		go func(i int) {
			fmt.Println("task ",i)
			time.Sleep(time.Second) // 刻意睡 1 秒钟，模拟耗时
			group.Done()
		}(i)
		fmt.Printf("index: %d,goroutine Num: %d \n", i, runtime.NumGoroutine())
	}
	group.Wait()
```

运行结果：
```go
index: 0,goroutine Num: 2 
index: 1,goroutine Num: 3 
task  0
index: 2,goroutine Num: 4 
index: 3,goroutine Num: 5 
task  3
task  2
index: 4,goroutine Num: 6 
index: 5,goroutine Num: 7 
index: 6,goroutine Num: 8 
task  4
index: 7,goroutine Num: 9 
task  6
index: 8,goroutine Num: 10 
index: 9,goroutine Num: 11 
task  7
task  8
task  1
task  9
task  5

```
可以看到总共有11个协程，其中一个是主协程，其他十个是子协程，为了让主协程等待所有的子协程执行完毕后再退出，使用 sync.WaitGroup 监控所有协程的状态，从而保证主协程结束时所有的子协程已经退出。

实际生产中，产生的goroutine的数量，是巨大，但是这种简单直接的方式就显得不那么高效了。CPU同一时间只能处理一个Goroutine，大量job的情况将会出现大量的Goroutine等待，以致于造成资源的浪费。

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/WX20200208-211451@2x.png)


# 控制Goroutine数量
## 令牌桶
chan+goroutine+sync.WaitGroup方式
````go
    jobCount := 10
	// sync.WaitGroup 监控所有协程的状态，从而保证主协程结束时所有的子协程已经退出
	group := sync.WaitGroup{}
	
    // 定一个桶 桶的容量为2，桶满了阻塞，类似令牌桶。保证每次同时运行的gorutine数量不会超过桶容量，达到每次并发控制gorutine数量
	buckets := make(chan bool,2)
	for i:=0;i < jobCount;i++ {
		buckets <- true
		group.Add(1)
		go func(i int) {
			fmt.Println("task ",i)
			time.Sleep(time.Second) // 刻意睡 1 秒钟，模拟耗时
			//fmt.Printf("index: %d,goroutine Num: %d \n", i, runtime.NumGoroutine())
			<- buckets
			group.Done()
		}(i)
		fmt.Printf("index: %d,goroutine Num: %d \n", i, runtime.NumGoroutine())
	}
	group.Wait()

````

```go
index: 0,goroutine Num: 2 
index: 1,goroutine Num: 3 
task  1
task  0
task  2
index: 2,goroutine Num: 2 
index: 3,goroutine Num: 3 
task  3
index: 4,goroutine Num: 3 
index: 5,goroutine Num: 3 
task  5
task  4
index: 6,goroutine Num: 2 
index: 7,goroutine Num: 3 
task  6
task  7
index: 8,goroutine Num: 3 
task  8
index: 9,goroutine Num: 3 
task  9

```
可以看到做到了控制2个2个执行的效果。

## 多worker消费
起多个worker等待chan；消息发布到chan，根据chan容量阻塞；worker开始消费chan；group.Wait()等待goroutine结束。

```go
// 控制 Goroutine 数量
	jobCount := 10
	group := sync.WaitGroup{}

	// chan容量为3
	jobsChan := make(chan int,5)

	// 起3个worker
	workerCount := 3
	for w:=0; w <= workerCount; w++ {
		go func(w int){
			for j := range jobsChan {
				fmt.Printf("worker %d get chan msg %d \n",w,j)
				time.Sleep(time.Second)
				group.Done()
			}
		}(w)
	}

	// 发布消息到chan
	for j :=0; j < jobCount; j++ {
		jobsChan <- j
		group.Add(1)
		fmt.Printf("index: %d,goroutine Num: %d\n", j, runtime.NumGoroutine())
	}

	group.Wait()
```

```go
worker 1 get chan msg 0 
index: 0,goroutine Num: 5
index: 1,goroutine Num: 6
worker 0 get chan msg 1 
worker 2 get chan msg 2 
index: 2,goroutine Num: 5
index: 3,goroutine Num: 5
index: 4,goroutine Num: 5
index: 5,goroutine Num: 5
index: 6,goroutine Num: 5
worker 3 get chan msg 3 
worker 0 get chan msg 4 
worker 1 get chan msg 7 
index: 7,goroutine Num: 5
worker 2 get chan msg 5 
index: 8,goroutine Num: 5
index: 9,goroutine Num: 5
worker 3 get chan msg 6 
worker 0 get chan msg 8 
worker 3 get chan msg 9 

```



                      


