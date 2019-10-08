---
layout: blog
title: Go 基础知识纪要【draft】
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
整形（int8,int16,int32,int64）、浮点型、布尔型、字符串、切片、结构体、函数（go语言的一种数据类型，可对函数类型的变量进行赋值和获取）、map、通道（channel）


# 流程判断

- 条件判断 if
- 条件循环 for
- 健值循环  for range
- 分支选择 switch
- 跳转 goto
- 跳出循环 break 和 继续循环 continue



