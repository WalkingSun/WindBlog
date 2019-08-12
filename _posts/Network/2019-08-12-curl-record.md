---
layout: blog
title: curl操作记录【draft】
categories: [网络]
description: 
keywords: 
cnblogsClass: \[Markdown\],\[随笔分类\]网络编程,\[随笔分类\]服务器
oschinaClass: \[Markdown\],服务器,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

在Linux中curl是一个利用URL规则在命令行下工作的文件传输工具，可以说是一款很强大的http命令行工具。它支持文件的上传和下载，是综合传输工具，但按传统，习惯称url为下载工具。

# 设置项
语法 curl [option] [url] 

常见参数
```shell
-A/--user-agent <string>              设置用户代理发送给服务器
-b/--cookie <name=string/file>    cookie字符串或文件读取位置
-c/--cookie-jar <file>                    操作结束后把cookie写入到这个文件中
-C/--continue-at <offset>            断点续转
-D/--dump-header <file>              把header信息写入到该文件中
-e/--referer                                  来源网址
-f/--fail                                          连接失败时不显示http错误
-o/--output                                  把输出写到该文件中
-O/--remote-name                      把输出写到该文件中，保留远程文件的文件名
-r/--range <range>                      检索来自HTTP/1.1或FTP服务器字节范围
-s/--silent                                    静音模式。不输出任何东西
-T/--upload-file <file>                  上传文件
-u/--user <user[:password]>      设置服务器的用户和密码
-w/--write-out [format]                什么输出完成后
-x/--proxy <host[:port]>              在给定的端口上使用HTTP代理
-#/--progress-bar                        进度条显示当前的传送状态

-H/--header <line>              自定义头信息传递给服务器
```



#遇到问题
- 终端使用curl请求url时返回乱码

curl -H ':method: POST' -H "Accept-Encoding: gzip" www.1616.net

Accept-Encoding: gzip 对数据进行gzip压缩，故数据返回乱码。

解压下就可以了
```shell
curl -H ':method: POST' -H "Accept-Encoding: gzip" www.1616.net | gunzip | more
```

