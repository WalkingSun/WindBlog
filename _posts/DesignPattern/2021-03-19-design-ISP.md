---
layout: blog
title: 设计模式-接口隔离（ISP）
categories: [设计模式]
description: 
keywords: IM
cnblogsClass: \[Markdown\],\[随笔分类\]设计模式
oschinaClass: \[Markdown\],服务器,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\] 
sinaClass: \[Markdown\]
---

## 接口隔离（ISP）

Clients should not be forced to depend upon interfaces that they don't use，还有一种定义是The dependency of one class to another one should depend on the smallest possible interface。

官方翻译：其一是不应该强行要求客户端依赖于它们不用的接口；其二是类之间的依赖应该建立在最小的接口上面。简单点说，客户端需要什么功能，就提供什么接口，对于客户端不需要的接口不应该强行要求其依赖；类之间的依赖应该建立在最小的接口上面，这里最小的粒度取决于单一职责原则的划分。

**问题由来：**类A通过接口I依赖类B，类C通过接口I依赖类D，如果接口I对于类A和类B来说不是最小接口，则类B和类D必须去实现他们不需要的方法。

**解决方案：**将臃肿的接口I拆分为独立的几个接口，类A和类C分别与他们需要的接口建立依赖关系。也就是采用接口隔离原则。

书中举例美女的划分：外貌、身材、气质，一个接口定义三种方法，但美女的划分可以单单根据气质判断，所以可以将气质这块抽出来作为接口，实现接口间隔离，不会出现客户端依赖于它们不用的接口。

## 隔离原则

- 接口尽量小；
- 高内聚；
- 定制服务；

一个接口只服务一个字模块或业务逻辑；

### 接口隔离原则和单一职责原则

从功能上来看，接口隔离和单一职责两个原则具有一定的相似性。其实如果我们仔细想想还是有区别的。

（1）从原则约束的侧重点来说，接口隔离原则更关注的是接口依赖程度的隔离，更加关注接口的“高内聚”；而单一职责原则更加注重的是接口职责的划分。

（2）从接口的细化程度来说，单一职责原则对接口的划分更加精细，而接口隔离原则注重的是相同功能的接口的隔离。接口隔离里面的最小接口有时可以是多个单一职责的公共接口。

（3）单一职责原则更加偏向对业务的约束，接口隔离原则更加偏向设计架构的约束。这个应该好理解，职责是根据业务功能来划分的，所以单一原则更加偏向业务；而接口隔离更多是为了“高内聚”，偏向架构的设计。


