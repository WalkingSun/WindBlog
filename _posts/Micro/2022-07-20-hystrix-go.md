---
layout: blog
title: hystrix应用
categories: [微服务, 熔断]
description: 熟悉
keywords: 熔断
cnblogsClass: \[Markdown\],\[随笔分类\]Micro
---

使用第三方库 hystrix-go 实现熔断功能

![](https://s2.loli.net/2022/07/20/Ac5n7DWKvqtH2Rs.png)


```go

hystrix.CommandConfig{
  Timeout:                300, // 超时
  MaxConcurrentRequests:  5000, // 最大并发的请求数
  RequestVolumeThreshold: 5, // 请求阈值 熔断器是否打开首先要满足这个条件；（代码中写死了）内请求数量，达到这个请求数量后再根据错误率判断是否要开启熔断；这里的设置表示至少有5个请求才进行ErrorPercentThreshold错误百分比计算，统计10s
  SleepWindow:            3 * 1000, // 熔断开启多久尝试发起一次请求
  ErrorPercentThreshold:  30, // 误差阈值百分比。默认值是 50，即窗口时间内超过 50% 的请求失败后会打开熔断器将后续请求快速失败这里设置为30。
 }
```

hystrix相关参数：
- Timeout
Timeout 定义执行command的超时时间，一旦超时则返回失败, 默认值是1000ms。目前gateway的超时时间设置为 400 ms，这个值是从gateway透传到各个子微服务的，hystrix的超时时间必须小于这个值，所以每个子微服务的值设置为 380ms。
- MaxConcurrentRequests
最大并发请求数,也就是同时有多少个请求可以同时处理,默认值是10,当请求达到或超过该设置值后，其其余就会被拒绝。默认值是100。推荐引擎目前资源足够，所以这个值可以设置大一点，目前设置为10000，对于熔断功能本身没有影响
- SleepWindow
熔断器打开后经过多长时间允许一次请求尝试执行，默认值是 5000ms。这里设置为3000ms
- RequestVolumeThreshold
熔断器功能窗口时间内的最小请求数，建议设置为 QPS * 窗口秒数 * 60%。推荐引擎scene服务的QPS大约在2000～3000，凌晨3点左右为最低，大约800。线上scene服务正常有15个pod，熔断器功能窗口时间默认为10s。这里取QPS为1000，基于以上数据大致可以计算出该值：1000 * 10 * 60% / 15 = 400 ，这里设置为200，之所以设置小一点，主要是尽可能保证触发熔断机制。
- ErrorPercentThreshold
默认值是 50，即窗口时间内超过 50% 的请求失败后会打开熔断器将后续请求快速失败这里设置为30。

requestVolumeThreshold 是在电路完全计算故障率百分比之前必须满足（在滚动窗口内）通过电路的调用量（数量）的最小阈值。仅当满足此最小音量（在每个时间窗口中）时，电路才会将您的调用失败比例与您配置的 errorThresholdPercentage 进行比较。
**想象一下，没有这样的最小体积通过电路阈值。想象一下在一个时间窗口错误中的第一个调用。 1 次调用中有 1 次是错误，= 100% 失败率，高于您设置的 50% 阈值。所以电路会立即断开。**

# 参考

https://github.com/afex/hystrix-go

https://www.modb.pro/db/107247
