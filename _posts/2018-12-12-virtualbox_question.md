---
layout: blog
title: vagrant & virtualbox 常见问题
categories: [服务器,遇到问题]
description:
keywords: 信号处理
cnblogsClass: \[Markdown\],\[随笔分类\]服务器,\[随笔分类\]遇到问题
oschinaClass: \[Markdown\],服务器,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---
1. Stderr: VBoxManage.exe: error: The machine 'website_default_1534234391711_86480' is already locked for a session (or being unlocked)
  VBoxManage.exe: error: Details: code VBOX_E_INVALID_OBJECT_STATE (0x80bb0007), component MachineWrap, interface IMachine, callee IUnknown
  VBoxManage.exe: error: Context: "LockMachine(a->session, LockType_Write)" at line 525 of file VBoxManageModifyVM.cpp

```
$ vagrant up
Bringing machine 'default' up with 'virtualbox' provider...
==> default: Clearing any previously set forwarded ports...
There was an error while executing `VBoxManage`, a CLI used by Vagrant
for controlling VirtualBox. The command and stderr is shown below.

Command: ["modifyvm", "ed16dad2-3da3-4113-92ff-73d58c733ee5", "--natpf1", "delete", "ssh", "--natpf1", "delete", "tcp8080", "--natpf1", "delete", "tcp8084", "--natpf1", "delete", "tcp8181"]

Stderr: VBoxManage.exe: error: The machine 'website_default_1534234391711_86480' is already locked for a session (or being unlocked)
VBoxManage.exe: error: Details: code VBOX_E_INVALID_OBJECT_STATE (0x80bb0007), component MachineWrap, interface IMachine, callee IUnknown
VBoxManage.exe: error: Context: "LockMachine(a->session, LockType_Write)" at line 525 of file VBoxManageModifyVM.cpp
```
解决办法：杀掉vagrant、virtualbox进程，再重启。

2.  Runtime error opening 'C:\Users\admin\VirtualBox VMs\Windows Server\Windows Server.vbox for reading: -102 (File not found.)

顺着这个路径找下去把“'C:\Users\admin\VirtualBox VMs\Windows Server\”这个文件夹下有个Windows Server.vbox-tmp，而虚拟机提示的是缺少Windows Server.vbox这个文件，重命名把-tmp删掉就行了，重命名后这个文件会显示一个方块的图标。再重启。