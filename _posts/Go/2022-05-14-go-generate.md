---
layout: blog
title: Go generate
categories: [Go]
description: 熟悉
keywords: Go
---

# gen
go generate命令是go 1.4版本里面新添加的一个命令，当运行go generate时，它将扫描与当前包相关的源代码文件，找出所有包含"//go:generate"的特殊注释，提取并执行该特殊注释后面的命令，命令为可执行程序，形同shell下面执行。

有几点需要注意：

- 该特殊注释必须在.go源码文件中。
- 每个源码文件可以包含多个generate特殊注释时。
- 显示运行go generate命令时，才会执行特殊注释后面的命令。
- 命令串行执行的，如果出错，就终止后面的执行。
- 特殊注释必须以"//go:generate"开头，双斜线后面没有空格。

Refer:

https://www.jianshu.com/p/a866147021da


# 应用
## Stringer

定义若干定义为整型常量，为这些常量定义String()签名方法。
```go
//go:generate stringer -type ```
Pill
```  

package painkiller

type Pill int

const (
    Placebo Pill = iota
    Aspirin
    Ibuprofen
    Paracetamol
    Acetaminophen = Paracetamol
)
```
**运行"go generate"命令前，我们需要安装stringer工具**
```shell
go get golang.org/x/tools/cmd/stringer
```

执行 ```go generate```当前目录下面生成一个pill_string.go文件。

让机器来做这项工作


# Refer
https://go.dev/blog/generate

https://pkg.go.dev/cmd/go