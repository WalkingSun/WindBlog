---
layout: blog
title: IO多路复用
categories: [system,IO]
description:
keywords: 多路复用
---

**IO multiplexing** IO多路复用： 通过一种机制，**一个进程**可以监视多个描述符，一旦某个描述符就绪（一般是读就绪或者写就绪），能够通知程序进行相应的读写操作。