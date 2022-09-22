---
layout: blog
title: 设计模式-函数式选项模式
categories: [设计模式]
description: 
keywords: 模版
cnblogsClass: \[Markdown\],\[随笔分类\]设计模式
---

# 选项模式
选项模式是一种函数式编程模式，用于为可用于修改其行为的函数提供可选参数。


实现server支持选项的添加扩展
```go
NewServer("8430")
NewServer("8430", WithTimeout(10*time.Second))
NewServer("8430", WithTimeout(10*time.Second), WithMaxConnections(10))
```
这种设计具有高度的可扩展性和可维护性
```go
package main

import "time"

type Option func(*Server)

type Server struct {
	port           string
	timeout        time.Duration
	maxConnections int
}

func NewServer(port string, options ...Option) *Server {
	server := &Server{
		port: port,
	}

	for _, option := range options {
		option(server)
	}

	return server
}

func WithTimeout(timeout time.Duration) Option {
	return func(s *Server) { // 通过闭包来实现属性设置
		s.timeout = timeout
	}
}

func WithMaxConnections(maxConn int) Option {
	return func(s *Server) {
		s.maxConnections = maxConn
	}
}

func main() {
	NewServer("8430")
	NewServer("8430", WithTimeout(10*time.Second))
	NewServer("8430", WithTimeout(10*time.Second), WithMaxConnections(10))
}
```


https://learnku.com/articles/71886



