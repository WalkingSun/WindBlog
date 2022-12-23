---
layout: blog
title: Go 多版本（Mac）
categories: [工具, 快捷键]
description: 他山之石
keywords: Mac
---	

Mac 下使用 homebrew 可以轻松实现 Go 多版本切换。

使用以下方法安装最新版本：

$ brew install go
写这篇文章时，Go 的最新版本为 1.17：

$ go version
go version go1.17.1 darwin/amd64
使用以下方法安装指定版本：

$ brew install go@1.15
首先 unlink：

$ brew unlink go
Unlinking /usr/local/Cellar/go/1.17.1... 0 symlinks removed.
link 指定版本：

$ brew link go@1.15
Linking /usr/local/Cellar/go@1.15/1.15.15... 2 symlinks created.
...
测试下是否成功：

$ go version
go version go1.15.15 darwin/amd64

如要恢复最新版本，重复以上 unlink 和 link 操作即可。