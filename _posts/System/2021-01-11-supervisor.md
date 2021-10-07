---
layout: blog
title: supervisor整理
categories: [服务器]
description:
keywords: 高级IO
---




## 常用命令

```shell
supervisorctl status        //查看所有进程的状态
supervisorctl stop es       //停止es
supervisorctl start es      //启动es
supervisorctl restart       //重启es
supervisorctl update        //配置文件修改后使用该命令加载新的配置
supervisorctl reload        //重新启动配置中的所有程序
```



