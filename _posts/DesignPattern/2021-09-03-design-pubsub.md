---
layout: blog
title: 设计模式-发布订阅
categories: [设计模式]
description: 
keywords: IM
cnblogsClass: \[Markdown\],\[随笔分类\]设计模式
---

发布订阅

docker项目中提供了一个pubsub的极简实现，下面是基于pubsub包实现的本地发布订阅代码：
```go
import (
    "github.com/moby/moby/pkg/pubsub"
)

func main() {
    p := pubsub.NewPublisher(100*time.Millisecond, 10)

    golang := p.SubscribeTopic(func(v interface{}) bool {
        if key, ok := v.(string); ok {
            if strings.HasPrefix(key, "golang:") {
                return true
            }
        }
        return false
    })
    docker := p.SubscribeTopic(func(v interface{}) bool {
        if key, ok := v.(string); ok {
            if strings.HasPrefix(key, "docker:") {
                return true
            }
        }
        return false
    })

    go p.Publish("hi")
    go p.Publish("golang: https://golang.org")
    go p.Publish("docker: https://www.docker.com/")
    time.Sleep(1)

    go func() {
        fmt.Println("golang topic:", <-golang)
    }()
    go func() {
        fmt.Println("docker topic:", <-docker)
    }()

    <-make(chan bool)
}
```
其中pubsub.NewPublisher构造一个发布对象，p.SubscribeTopic()可以通过函数筛选感兴趣的主题进行订阅。

设计：基于gRPC和pubsub包，提供一个跨网络的发布和订阅系统。


https://github.com/gooopher/go-insight/blob/feature/view/skill/pratice/queue/publish_subscribe.go