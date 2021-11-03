# 概要
结合实际生产应用出现的一些问题：
- 新加功能不知放在哪个项目模块合适，项目间模块的界限很难明确；
- 代码越来越臃肿，代码耦合维护越加困难，职责不清晰，改一个地方可能涉及跨项目模块的修改；
- 功能叠加，代码库越来越庞大，发布流程变得更久；
- 开发整理旧逻辑比较费力，如果疏漏逻辑会带来一定的安全隐患；

对庞大的单体应用或者业务领域进行拆分，分而治之来降低系统的复杂性和可维护性，目前是比较常见的做法，比如对移动联盟中marketing业务的拆分。

下面分析下微服务。

# 微服务

了解微服务之前，我们先看下几个概念：
- 单一职责：：“把因相同原因而变化的东西聚合到一起，而把因不同原因而变化的东西分离开来。” （Robert C. Martin对单一职责原则（SingleResponsibility Principle,http://programmer.97things.oreilly.com/wiki/index.php/ The SingleResponsibility Principle）的论述）
- RPC：在分布式计算，远程过程调用（Remote Procedure Call，简称 RPC）是一个计算机通信协议。该协议允许运行于一台计算机的程序调用另一个地址空间（通常为一个开放网络的一台计算机）的子程序，而程序员就像调用本地程序一样，无需额外地为这个交互作用编程（无需关注细节）。RPC是一种服务器-客户端（Client/Server）模式，经典实现是一个通过发送请求-接受回应进行信息交互的系统。

微服务遵循的就是单一职责原则，把业务相关的聚合在一起，不相关的拆分开，高内聚松耦合，同时通过业务的界限来划定服务的界限。相对于简单的拆分是微服务拆分的粒度更细，通过一系列松耦合、自治的微服务来构建微服务应用，每个微服务只专注做好一件事（功能）。

微服务的自治：每个微服务高内聚，只负责一个功能；服务之间通过网络调用进行通信，避免紧耦合；服务可以彼此间独立进行修改和部署，而不影响其他服务。

自治性使得我们开发人员需要独立的对服务进行开发、部署、扩容，对服务的业务、运维等指标的反馈带来一定的运维挑战。

## 微服务拆分

微服务拆分目的：对业务领域进行拆分，划定微服务的范围，分而治之降低系统的复杂性和可维护性，解耦业务，使项目间的职责更加明确，方便维护扩展。
 
微服务拆分规范：  
1. 梳理当前各项目的业务模块（当前项目按照垂直拆分粒度比较大的服务），梳理耦合部分业务逻辑，保证各个服务职责明确。
2. 基于当前移动联盟业务梳理进行业务、可扩展、可靠性拆分：
  - 业务拆分：系统中的业务模块按照职责范围识别出来，每个单独的业务模块拆分为一个独立的服务；
  - 可扩展拆分：将系统中的业务模块按照稳定性排序，将已经成熟和改动不大的服务拆分为稳定服务，将经常变化和迭代的服务拆分为变动服务；
  - 可靠性拆分：将系统中的业务模块按照优先级排序，将可靠性要求高的核心服务和可靠性要求低的非核心服务拆分开来，然后重点保证核心服务的高可用。我理解比如k8s点击的ingress、pod隔离；
3. 两者结合，首先按当前拆分项目整合职责，后考虑把比较独立的相关业务抽离出来；


# 服务契约
每个微服务对外暴露一个契约，契约定义服务期望接受和返回的信息，客户端和服务端遵从的规范。

契约规范化，同时客户端、服务端通过RPC协议进行通信，可以是不同平台不同语言间进行通信，主要的RPC协议有：
- http
- http2
- gRPC（http2）
- socket

目前比较成熟的就是谷歌出品的gRPC，gRPC 使用[protocol buffers](https://developers.google.com/protocol-buffers/docs/overview)作为它的接口定义语言(IDL)和底层的消息交换格式。

gRPC客户端与服务端通信流程：
![f227c404-4042-46e4-aaec-fb01b07de4d0](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/vs/企业微信截图_f227c404-4042-46e4-aaec-fb01b07de4d0.png)


# 实施
目前的微服务框架主流： go micro、 go kit等。
  
微服务不是银弹，不能说一下子切成微服务指望解决所有问题，首先开发时间成本高，其次开发阶段会导致业务停滞，然后上线切换，新系统问题会多。早期还是运用微服务拆分的理念来约束项目服务边界，使用gRPC来进行RPC调用，来降低项目间的耦合性，后面在考虑某块业务拆分。

整理当前项目模块间的耦合关系：
![20210914160612](https://i.loli.net/2021/09/14/3LQMoiI8Vh2HRJD.png)
## 项目工程化-目录结构规范：
讨论项目工程化规范能够在团队中约束规范化，也利于后期重构工作。
```shell
- micro // 服务
  - cmd
   └── service // 对内的微服务，仅接受来自内部其他服务或者网关的请求，比如暴露了 gRPC 接口只对内服务。
       └── group.go // 如提供对内的渠道组服务
   └── api   // 对外暴露服务，接受来自用户的请求，比如暴露了 HTTP/gRPC 接口  
   └── job         // 流式任务处理的服务。
   └── cron   // 定时任务
   └── main.go
- api  // API 定义的目录，使用 grpc 存放 proto 文件及生成代码文件
   └── product_name // 产品名称，如推广分析-渠道管理
        └── app_name // 应用名称，如渠道组
#            └── v1   // 版本号
                └── group.proto
                └── group_pb.go
                └── group_grpc_pb.go
                └── client.go             // 客户端指定连接方式
                └── README.md       // 使用说明，如跨语言PHP如何接入
 - pkg 
  └── service         // 逻辑层
  └── repository    // 数据处理层
```

需要解决文件及生成代码文件包引用问题，版本升级带来的版本管理问题：
- 代码指定版本目录：优点可以显式展示变更，缺点目录结构会变得臃肿，对外开放会暴露核心代码；
- sub module：实现复杂，只能更新不能往后；
- api层抽成单独库：对外开放安全，比较独立灵活，通过打标签来管理版本。

倾向第三种，比较灵活。

### protobuf规范
protobuf定义及生成序列化、gRPC、客户端代码的结构需要规范化。

```protocol
syntax = "proto3";

package group;

option go_package = "./api/channel-manage/group";

service Group {
  rpc GetAccountList (GroupRequest) returns (GroupReply)  {}
}

message GroupRequest {
  string Source  = 1;
  string AccountIDs =2;
}

message GroupInfo {
  int64 ID = 1;
  string Source  = 2;
  string AccountID =3;
}

message GroupReply {
  repeated GroupInfo  GroupInfo = 1;
}
```

> 外部调用
  使用http:restful风格，还需要做接口对外暴露处理，对输入输出的proto定义规范;项目中需要用的时候再提前调研下。 

### 调试
服务之间通过protouf协议通信，二进制编码，性能优越，但可读性不友好，寻找可视化的调试工具。

- 命令行操作：grpcurl，evans
- pc端操作：bloomrpc

参考其他团队整理文章 https://tech.qimao.com/grpc/ ，[bloomrpc](https://github.com/uw-labs/bloomrpc
)挺方便。


待整理：

- [ ] 微服务部署
  - 服务健康检查，持续集成，自动部署，服务过多运维压力
1. 部署服务，新加服务或修改服务，重启如何不影响调用进程？
   启动A服务，监听端口：8081；
   新起B服务，监听端口：8082；

   客户端获取服务列表 [A,B]

   升级：下线A服务，等服务没有客户端链接，重新部署A服务;B服务相同操作；


- [ ] 服务监控、链路追踪、多点故障定位、故障恢复
  - 服务监控可以主动发现系统中的薄弱环节加以优化、重构：当出现故障时，比如服务出现资源、网络瓶颈等情况，如何能够及时感知（调用了哪个服务、输入输出信息），迅速定位问题，找到有效的解决方案。；
  - 通过业务指标、应用日志、运维指标和基础设施指标来了解服务行为；
- [ ] php客户端调用调研，环境、规范整理
- [ ] 提供对外接口，http结合gin
- [ ] 服务发现




# Reference

RPC https://zh.wikipedia.org/wiki/%E9%81%A0%E7%A8%8B%E9%81%8E%E7%A8%8B%E8%AA%BF%E7%94%A8

Go工程化-项目目录结构 https://lailin.xyz/post/go-training-week4-project-layout.html

gRPC调试 https://tech.qimao.com/grpc/

bloomrpc: https://github.com/uw-labs/bloomrpc

sub moduke https://git-reference.readthedocs.io/zh_CN/latest/Git-Tools/Submodules/

gRPC PHP https://grpc.io/docs/languages/php/quickstart/

基于 protobuf 自动生成 gin 代码 https://lailin.xyz/post/go-training-week4-protoc-gen-go-gin.html
