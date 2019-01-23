---
layout: blog
title: docker及服务器遇到的坑
categories: [服务器,docker]
description: 记录docker遇到的坑
keywords: IM
cnblogsClass: \[Markdown\],\[随笔分类\]遇到问题,\[随笔分类\]服务器
oschinaClass: \[Markdown\],服务器,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

# DNS不可用
进入 /etc/resolv.conf  添加
```
nameserver 8.8.8.8
```

vagrant 搭的虚拟环境或者docker里面遇到过，每次重启都会失效，可以写个shell脚本修改，每次开机启动就好了。

docker使用还有种方案，容器内的/etc/resolv.conf挂载到宿主机下 /etc/resolv.conf。

# 修改docker查找源
```
docker search centos
Error response from daemon: Get https://index.docker.io/v1/search?q=centos: read tcp 52.200.132.201:443: i/o timeout
```

进入/etc/docker

查看有没有 daemon.json。这是docker默认的配置文件。

如果没有新建，如果有，则修改。
```
[root docker]# vi daemon.json
 {
   "registry-mirrors": ["https://registry.docker-cn.com"]
 }
```
 保存退出。


重启docker服务

service docker restart

成功！
