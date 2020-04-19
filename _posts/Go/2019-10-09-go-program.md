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


## 函数
[https://www.cnblogs.com/followyou/p/12348259.html](https://www.cnblogs.com/followyou/p/12348259.html)

## 结构体
[https://www.cnblogs.com/followyou/p/12358919.html](https://www.cnblogs.com/followyou/p/12358919.html)

## 接口（interface）
[https://www.cnblogs.com/followyou/p/12601846.html](https://www.cnblogs.com/followyou/p/12601846.html)


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









