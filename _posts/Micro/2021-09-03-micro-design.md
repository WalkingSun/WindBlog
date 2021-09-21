# 微服务定义
Martin Fowler 与 James Lewis 共同提出了微服务的概念,定义微服务是由以单一应用程序构成的小服务，自己拥有自己的进程与轻量化处理，服务依业务功能设计，以全自动的方式部署，与其他服务使用HTTP API通信。同时服务会使用最小的规模的集中管理 (例如 Docker) 能力，服务可以用不同的编程语言与数据库等组件实现。

微服务是一种以业务功能为主的服务设计概念，每一个服务都具有自主运行的业务功能，对外开放不受语言限制的 API (最常用的是 HTTP)，应用程序则是由一个或多个微服务组成。

参考：https://zh.wikipedia.org/wiki/%E5%BE%AE%E6%9C%8D%E5%8B%99



微服务架构设计关注点

    Rate Limiter 限流器

    Trasport 数据传输(序列化和反序列化)

    Logging 日志

    Metrics 指标

    Circuit breaker 断路器

    Request tracing 请求追踪

    Service Discovery 服务发现

微服务组件：https://gokit.io/

Question

- [ ] 自动化支撑
- [ ] 调用链长，问题定位问题（多个服务处理、事务处理问题）
- [ ] 服务治理
- [ ] GRPC调试 gocurl: https://www.cnblogs.com/52fhy/p/12376940.html



![20210903143209](https://i.loli.net/2021/09/03/puLxg8t4RQVbDvz.png)




参考：https://www.jianshu.com/p/cffe039fa060