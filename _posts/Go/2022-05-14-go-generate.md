---
layout: blog
title: Go generate
categories: [Go]
description: 熟悉
keywords: Go
---

go generate命令是go 1.4版本里面新添加的一个命令，当运行go generate时，它将扫描与当前包相关的源代码文件，找出所有包含"//go:generate"的特殊注释，提取并执行该特殊注释后面的命令，命令为可执行程序，形同shell下面执行。

有几点需要注意：

- 该特殊注释必须在.go源码文件中。
- 每个源码文件可以包含多个generate特殊注释时。
- 显示运行go generate命令时，才会执行特殊注释后面的命令。
- 命令串行执行的，如果出错，就终止后面的执行。
- 特殊注释必须以"//go:generate"开头，双斜线后面没有空格。

Refer:

https://www.jianshu.com/p/a866147021da