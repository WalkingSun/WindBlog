---
layout: blog
title: Prometheus  Metrics
categories: [gRPC]
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

## Prometheus设计
当Prometheus刮取你的实例的HTTP端点时，客户端库会将所有跟踪的指标的当前状态发送到服务器。

### 指标
Prometheus指标分为Counter（计数器）、Gauge（仪表盘）、Histogram（直方图）和Summary（摘要）这4类，
1. Counter是计数器类型，它的特点是只增不减，例如机器启动时间、HTTP访问量等。Counter 具有很好的不相关性，不会因为机器重启而置0
2. Gauge
  Gauge是仪表盘，表征指标的实时变化情况，可增可减，例如CPU和内存的使用量、网络 I/O 大小等，大部分监控数据都是 Gauge 类型的。
3. Summary
   如果需要了解某个时间段内请求的响应时间，则通常使用平均响应时间，但这样做无法体现数据的长尾效应。
4. Histogram
   Histogram反映了某个区间内的样本个数，通过{le="上边界"}指定这个范围内的样本数。 
   Prometheus中表示每个本地存储序列保存的chunk数量的指标prometheus_local_storage_series_chunks_persisted就属于Histogram指标类型


### 数据采集
Prometheus主要采用 Pull方式采集监控数据。

采用Push方式时，Agent主动上报数据，采用Pull方式时，监控中心（Master）拉取 Agent的数据。
为了兼容 Push方式，Prometheus 提供了 Pushgateway组件

Push方式和Pull方式进行详细对比和说明
1. 实时性
Push方式的实时性相对较好，可以将采集数据立即上报到监控中心。
Pull 方式通常进行周期性采集，采集时间为30s 或者更长时间。
如果对监控系统的实时性要求非常高，则建议采用Push方式。
2. 状态保存
Push 方式通常在采集完成后立即上报，本地不会保存采集数据，Agent 本身是没有状态的，而Master需要维护各种Agent状态。
Pull 方式正好相反，Agent 本身需要有一定的数据存储能力，Master 只负责简单的数据拉取，而且Master本身可以做到无状态。
3. 控制能力
采用Push方式时，控制方为Agent,Agent上报的数据决定了上报的周期和内容。
采用Pull方式时，Master更加主动，控制采集的内容和频率。
4. 配置的复杂性
采用Push方式时，通常每个 Agent都需要配置Master的地址。采用Pull方式时，通常通过批量配置或者自动发现来获取所有采集点。

### 服务发现
Prometheus 获取被采集的对象，有两种方式：静态文件配置和动态发现。
1. 静态文件配置
静态文件配置是一种传统的服务发现方式，一般适用于有固定的监控环境、IP地址和统一的服务接口的场景，需要在配置中指定采集的目标。
2. 动态发现
动态发现方式比较适合在云环境下使用。云的理念就是按需供给，资源是动态分配的，并且生命周期比物理机器短。
◎ 动态伸缩场景
◎ 迅速配置场景
Prometheus动态发现方式获取监控对象。目前支持以下系统获取监控对象：
◎ 容器管理系统，例如Kubernetes、Marathon；
◎ 各种云管平台，例如EC2、Azure、OpenStack；
◎ 各种服务发现组件，例如DNS、ZooKeeper和Consul等。
![](https://s2.loli.net/2022/07/25/aYRldz7WqvADFpS.png)


### 数据查询
Prometheus实现了一套自己的数据库语言（PromQL）解析器

Prometheus支持Grafana等开源显示面板，通过自定义PromQL可以制作丰富的监控视图。Prometheus本身也提供了一个简单的 Web查询控制台，如图2-14所示，Web控制台包含三个主要模块：Graph指标查询，Alerts告警查询、Status状态查询

## 语法
```sql
# 指定默认值
sum(your_query) or vector(1)
```
## go demo
```
package main

import (
	"github.com/prometheus/client_golang/prometheus"
	"github.com/prometheus/client_golang/prometheus/promauto"
	"net/http"
	"time"

	"github.com/prometheus/client_golang/prometheus/promhttp"
)

func recordMetrics() {
	go func() {
		for {
			opsProcessed.Inc()
			time.Sleep(2 * time.Second)
		}
	}()
}

var (
	opsProcessed = promauto.NewCounter(prometheus.CounterOpts{
		Name: "myapp_processed_ops_total",
		Help: "The total number of processed events",
	})
)

func main() {
	recordMetrics()

	http.Handle("/management/metrics", promhttp.Handler())
	http.ListenAndServe(":2112", nil)
}

// Counter applications：
// 1、static success nums；
// 2、static fail nums；
// 3、static event nums；

// metrics format：
```

查看写入指标
http://localhost:2112/management/metrics 


## 采集对象
### Kubernetes资源相关 
1. CPUThrottlingHigh
关于 CPU 的 limit 合理性指标。查出最近5分钟，超过25%的 CPU 执行周期受到限制的容器。表达式：
```shell
sum(increase(container_cpu_cfs_throttled_periods_total{container!="", }[5m])) by (container, pod, namespace)
          /
sum(increase(container_cpu_cfs_periods_total{}[5m])) by (container, pod, namespace)
          > ( 25 / 100 )
```          
相关指标：
- container_cpu_cfs_periods_total：容器生命周期中度过的 cpu 周期总数
- container_cpu_cfs_throttled_periods_total：容器生命周期中度过的受限的 cpu 周期总数


参考：https://cloud.tencent.com/developer/article/1667912


## 参考
正则查询：
https://prometheus.fuckcloudnative.io/di-san-zhang-prometheus/di-4-jie-cha-xun/basics

go-application https://prometheus.io/docs/guides/go-application/




<table class="confluenceTable wrapped"><colgroup><col style="width: 127.0px"><col style="width: 63.0px"><col style="width: 45.0px"><col style="width: 45.0px"><col style="width: 133.0px"><col style="width: 99.0px"></colgroup><thead><tr><th class="confluenceTh"><p>压测对象</p></th><th class="confluenceTh"><p>并发数</p></th><th class="confluenceTh"><p>tps</p></th><th class="confluenceTh"><p>rt</p></th><th colspan="1" class="confluenceTh"><p>峰值cpu（core）</p></th><th colspan="1" class="confluenceTh"><p>内存（MB）</p></th></tr></thead><tbody><tr><td class="confluenceTd">test2（bitmap）</td><td class="confluenceTd">20</td><td class="confluenceTd">274</td><td class="confluenceTd">73</td><td colspan="1" class="confluenceTd">0.972</td><td colspan="1" class="confluenceTd">42.33</td></tr><tr><td class="confluenceTd">test2（旧）</td><td class="confluenceTd">20</td><td class="confluenceTd">190</td><td class="confluenceTd">105</td><td colspan="1" class="confluenceTd">0.925</td><td colspan="1" class="confluenceTd">72.18</td></tr><tr><td class="confluenceTd">test2（bitmap）</td><td class="confluenceTd">30</td><td class="confluenceTd">377</td><td class="confluenceTd">79</td><td colspan="1" class="confluenceTd">1.276</td><td colspan="1" class="confluenceTd">37.97</td></tr><tr><td colspan="1" class="confluenceTd">test2（旧）</td><td colspan="1" class="confluenceTd">30</td><td colspan="1" class="confluenceTd">320</td><td colspan="1" class="confluenceTd">94</td><td colspan="1" class="confluenceTd">1.119</td><td colspan="1" class="confluenceTd">77.16</td></tr><tr><td colspan="1" class="confluenceTd">test2（bitmap）</td><td colspan="1" class="confluenceTd">40</td><td colspan="1" class="confluenceTd">432</td><td colspan="1" class="confluenceTd">92</td><td colspan="1" class="confluenceTd">1.468</td><td colspan="1" class="confluenceTd">44.82</td></tr><tr><td colspan="1" class="confluenceTd">test2（旧）</td><td colspan="1" class="confluenceTd">40</td><td colspan="1" class="confluenceTd">326</td><td colspan="1" class="confluenceTd">122</td><td colspan="1" class="confluenceTd">1.717</td><td colspan="1" class="confluenceTd">65.74</td></tr></tbody></table>