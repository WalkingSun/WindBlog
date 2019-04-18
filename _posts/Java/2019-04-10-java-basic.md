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

<!-- # 概念 -->
java安装多版本，如何切换：


# 数据结构
基本数据类型：整数类型、浮点类型、字符类型、逻辑类型

构造数据类型：数组、类、对象、接口

与运算符 &&和&

或运算符 ||和|

异或运算符 ^ 两个表达式一个为真为假，组合表达式就是真

条件表达式 逻辑表达式？表达式1：表示式2

if、while结构类似php

switch多分支开关语句
```java
switch(表达式){
    case 常量表达式1: 语句组1；
       [ break; ]
    case 常量表达式1: 语句组1；
       [ break; ]
    default:语句块n
}
```

for 循环语句
```java
for(初始化表达式;条件表达式;迭代语句){
    循环体语句;
}

for(;;){
    ...
}
```

foreach 增强型for循环语句
```java
for(数据类型 数据变量:数组){
    使用数据变量的循环体语句组;
}
```
实例
```java
int[] arrays = {1,2,3,4,5};
for(int element:arrays){
    System.out.printIn(element);
}    
```

标签break 可以终止一个或几个代码块，语法：
break 标签名称
```java
outer:  //定义标签
for(int i=0;i<3;i++){
    for(int j=0;j<100;j++){
        if(j==10) break outer;    //终止outer标签内代码
    }
}

```


## 数组
声明：
```
# 一维数组
数组类型[] 数组名称；
数组类型 数组名称[]；

# 二维数组
数组类型[][] 数组名称;
数组类型 数组名称[][];
```

数组对象
```java
int[] weeks = new int[7];  #创建数组对象时必须指明这个数组的大小。

int[][] year = new int[52][7];
```

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

# SpringBoot
@Autowired自动导入。
@RequestMapping(value = "/systems/userinfo", method = {RequestMethod.GET,RequestMethod.POST}, produces = { "application/json"} ) - 来映射 Request 请求与处理器,用来处理地址映射请求的注解

@Aspect  // 使用@Aspect注解声明一个切面
```

# 常用函数
```java
System.out.println("打印数据");

//java判断字符串相等
 string1.equals(string2)

//判断字符串是都为空的方法
if(s == null || s.length() == 0)

//过滤空格
username = " sun ";
username = username.trim()

//判断String字符串数组中是否存在某个值
//优点：使用二分查找法，效率快捷。
//缺点：查询的数组必须是有序的，如果不是有序的话，使用此方法是没有用的。
String[] array = {"1","2","3","4"};
int index = Arryas.binarySearch(array,"2");
```

- 操作字符串
String对象的长度是固定的，不能改变它的内容，也不能附加内容到String对象中。使用'+'号连接字符串达到附加新字符或字符串的目的，但会产生一个新的String实例，即需要额外分配空间。希望节省开销，又想改变字符串内容，可使用StringBuilder。

StringBuilder类 对象产生默认16个字符的长度，可变长度，附加内容会自动增加长度。

length() 返回长度

indexof() 返回字符串第一次出现的位置

append() 在尾部添加字符串

insert() 在指定为止添加字符串

capcity() 返回该对象目前已经分配的、可容纳的字符总量。

```java
StringBuilder sb = new StringBuilder();
sb.append("Greeters");
```

<!-- # 基础包 -->
