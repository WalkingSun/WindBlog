---
layout: blog
title: dockerfile常用指令
categories: [docker, composer]
description: docker实际运用中的记录
keywords: docker, composer
cnblogsClass: \[Markdown\],\[随笔分类\]服务器,\[随笔分类\]容器
oschinaClass: \[Markdown\],服务器,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

# 指定容器启动时运行的命令
## CMD
为容器提供默认的执行命令

CMD 指令有三种使用方式，其中的一种是为 ENTRYPOINT 提供默认的参数：
CMD ["param1","param2"]
另外两种使用方式分别是 exec 模式和 shell 模式：
- CMD ["executable","param1","param2"]    // 这是 exec 模式的写法，注意需要使用双引号。
- CMD command param1 param2                  // 这是 shell 模式的写法。

## ENTRYPOINT
为容器指定默认执行的任务

ENTRYPOINT 指令有两种使用方式，exec 模式和 shell 模式：
- ENTRYPOINT ["executable", "param1", "param2"]   // 这是 exec 模式的写法，注意需要使用双引号。
- ENTRYPOINT command param1 param2                   // 这是 shell 模式的写法。


# COPY
本地的文件拷贝到容器镜像中
```
COPY <src> <dest>
```

除了指定完整的文件名外，COPY 命令还支持 Go 风格的通配符，比如：
```
COPY check* /testdir/           # 拷贝所有 check 开头的文件
COPY check?.log /testdir/       # ? 是单个字符的占位符，比如匹配文件 check1.log
```

对于目录而言，COPY 和 ADD 命令具有相同的特点：只复制目录中的内容而不包含目录自身。

# ADD
ADD 命令的格式和 COPY 命令相同，也是：
```ADD <src> <dest>```

除了不能用在 multistage 的场景下，ADD 命令可以完成 COPY 命令的所有功能，并且还可以完成两类超酷的功能：

- 解压压缩文件并把它们添加到镜像中
- 从 url 拷贝文件到镜像中

```shell
# 目录添加
ADD ./config /usr/bin/config

# 文件指定目录
ADD ./bin/*.sh /usr/bin/
```

# 构建指定dockerfile、推送到远程仓库
```bash
docker build -f ./Dockerfile-dev . -t harbor-reg.km.com/micro/user-cronjob:latest
# docker build [OPTIONS] PATH | URL | -
# -t  Name and optionally a tag in the ‘name:tag’ format
docker push harbor-reg.km.com/bigdata/user-cronjob:latest
# docker push [OPTIONS] NAME[:TAG]
```
