---
layout: blog
title: Kubernetes 架构【draft】
categories: [k8s]
description: k8s
keywords: k8s
cnblogsClass: \[Markdown\],\[随笔分类\]服务器,\[随笔分类\]k8s
oschinaClass: \[Markdown\],服务器,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

# Master
Master是Kubernetes Cluster的大脑，运行着的Daemon服务包括kube-apiserver、kube-scheduler、kube-controller-manager、etcd和Pod网络（例如flannel）

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/20200319204135.png)

## API Server(kube-apiserver)

API Server提供HTTP/HTTPS RESTful API，即Kubernetes API.

API Server是KubernetesCluster的前端接口，各种客户端工具（CLI或UI）以及Kubernetes其他组件可以通过它管理Cluster的各种资源。

## Scheduler（kube-scheduler）
Scheduler负责决定将Pod放在哪个Node上运行。Scheduler在调度时会充分考虑Cluster的拓扑结构，当前各个节点的负载，以及应用对高可用、性能、数据亲和性的需求。

## Controller Manager（kube-controller-manager）

Controller Manager负责管理Cluster各种资源，保证资源处于预期的状态。ControllerManager由多种controller组成，包括replication controller、endpoints controller、namespace controller、serviceaccounts controller等。

不同的controller管理不同的资源。例如，replication controller管理Deployment、StatefulSet、DaemonSet的生命周期，namespace controller管理Namespace资源。

## etcd
etcd负责保存Kubernetes Cluster的配置信息和各种资源的状态信息。当数据发生变化时，etcd会快速地通知Kubernetes相关组件。

## Pod网络
Pod要能够相互通信，Kubernetes Cluster必须部署Pod网络，flannel是其中一个可选方案。

# Node
Node是Pod运行的地方，Kubernetes支持Docker、rkt等容器Runtime。Node上运行的Kubernetes组件有kubelet、kube-proxy和Pod网络（例如flannel）
![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/20200319204925.png)

## kubelet
kubelet是Node的agent，当Scheduler确定在某个Node上运行Pod后，会将Pod的具体配置信息（image、volume等）发送给该节点的kubelet，kubelet根据这些信息创建和运行容器，并向Master报告运行状态。