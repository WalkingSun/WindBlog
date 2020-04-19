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

# 匿名变量
匿名变量 '_'表示，使用匿名变量时，只需要在变量声明的地方使用下划线替换即可。
```go
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

