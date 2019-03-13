---
layout: blog
title: vagrant 安装虚拟机
categories: [vagrant]
description: vagrant搭建属于自己的环境
keywords: vagrant, virtualbox
cnblogsClass: \[Markdown\],\[随笔分类\]服务器,\[随笔分类\]遇到问题
oschinaClass: \[Markdown\],服务器,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

[TOC]

# 搭建属于你的环境
安装环境有时也是头疼的事，换个电脑就得重装个，还会出现各种兼容问题，vagrant带来很大方便，还支持导出镜像，简直就是移动的系统。降低时间成本，兼容性强，好处多多。安装记录：

## 安装virtualbox 

 具体安装包请直接从官网下载：https://www.virtualbox.org/wiki/Downloads
##  安装 vagrant
 下载：https://www.vagrantup.com/downloads.html
安装完成查看版本
```
$ vagrant -v
```

vagrant基本命令
```
vagrant init   #初始化vagrantfile
vagrant add box  #添加box，自动生成vagrantfile
vagrant up       #启动虚拟机
vagrant halt     #关闭虚拟机
vagrant destory #销毁虚拟机
vagrant ssh       #进入虚拟机
vagrant reload    #重新加载vagrantfile文件
vagrant suspend   #暂时挂起
vagrant status     #查看虚拟机状态
```

## vagrant 添加系统镜像box
box下载地址： http://www.vagrantbox.es/
```
$cd /website
$ mkdir -p vagrant/boxes
$ cd vagrant/boxes
$ vagrant add box centos7 centos7-64.box
```
## 新建虚拟机
```
$ cd /website/vagrant
$ vagrant init centos7
$ vagrant up
$ vagrant ssh
```
## 相关配置
修改vagrantfile配置
```
  config.vm.box = "centos7"
  config.vm.hostname = "sun"    #主机名
  config.vm.network "private_network", ip: "192.168.22.20"   #私有网络
  config.vm.synced_folder "/website", "/home/www", :nfs => true  #共享文件夹 开启nfs
  #config.vm.network "forwarded_port", guest: 22, host: 2220  #端口映射

```
重新加载配置
```
$ vagrant reload
```
## ==遇到问题==

1）

```
The following SSH command responded with a non-zero exit status.
Vagrant assumes that this means the command failed!

mount -o vers=3,udp 192.168.22.1:/website /home/www

Stdout from the command:



Stderr from the command:

mount.nfs: access denied by server while mounting 192.168.22.1:/website
```
虽然vagrant up启动报错，但是vagrant ssh还是能登陆虚拟机的，进入虚拟机后，执行如下命令
```
sudo rm -f /etc/udev/rules.d/70-persistent-net.rules 
```
 问题出在在持久网络设备udev规则（persistent network device udev rules）是被原VM设置好的，再用box生成新VM时，这些rules需要被更新。而这和Vagrantfile里对新VM设置private network的指令发生冲突。

再次启动就没问题了

![image](http://note.youdao.com/yws/res/33511///note.youdao.com/src/12E3708985D341DD8B0500FD9F2502CC)

vagrant ssh 进入虚拟机

![image](http://note.youdao.com/yws/res/33517///note.youdao.com/src/520F1403CE344346B669D4FC6CB52198)


2）共享文件夹挂载失败,mac nfs服务启动不了
```
tee: /etc/exports: Operation not permitted
tee: /etc/exports: Operation not permitted
tee: /etc/exports: Operation not permitted
The nfsd service does not appear to be running.
```
解决参考：https://github.com/hashicorp/vagrant/issues/10234


 

centos7虚拟机安装完成！

> 贴下有道云地址 http://note.youdao.com/noteshare?id=15da919d1a5f5635d71056cdf11f37af