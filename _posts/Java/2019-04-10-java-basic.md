---
layout: blog
title: java基础【draft】
categories: [java, 基础]
description: 记录java一些基础概念
keywords: keyword1, keyword2
cnblogsClass: \[Markdown\],\[随笔分类\]Java
oschinaClass: \[Markdown\],Java,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

# 概念

# 数据结构


# 注解
```java
@Override - 检查该方法是否是重载方法。如果发现其父类，或者是引用的接口中并没有该方法时，会报编译错误。
@Deprecated - 标记过时方法。如果使用该方法，会报编译警告。
@SuppressWarnings - 指示编译器去忽略注解中声明的警告。
作用在其他注解的注解(或者说 元注解)是:

@Retention - 标识这个注解怎么保存，是只在代码中，还是编入class文件中，或者是在运行时可以通过反射访问。
@Documented - 标记这些注解是否包含在用户文档中。
@Target - 标记这个注解应该是哪种 Java 成员。
@Inherited - 标记这个注解是继承于哪个注解类(默认 注解并没有继承于任何子类)

# SpringMVC
@RequestMapping 来映射 Request 请求与处理器
```

# 常用函数
```java
System.out.println("打印数据");

//java判断字符串相等
 string1.equals(string2)

//判断字符串是都为空的方法
if(s == null || s.length() == 0)
```


# 基础包
