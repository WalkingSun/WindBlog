---
layout: blog
title: Goroutine并发控制【draft】
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

# 控制Gorutine的数量








                      


