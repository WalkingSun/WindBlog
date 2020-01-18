---
layout: blog
title: Go 格式转换
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

# string、int、int64相互转换
```go
#string到int
int,err:=strconv.Atoi(string)

#string到int64
int64, err := strconv.ParseInt(string, 10, 64)

#int到string
string:=strconv.Itoa(int)

#int64到string
string:=strconv.FormatInt(int64,10)
```

# string、[]byte转换
string转[]byte
```go
var str string = "test"

var data []byte = []byte(str)
```

[]byte转string
```go
var data [10]byte 

byte[0] = 'T'

byte[1] = 'E'

var str string = string(data[:])
```

