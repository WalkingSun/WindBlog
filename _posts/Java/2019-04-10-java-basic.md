---
layout: blog
title: java基础
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

# 常用方法
```java
System.out.println("打印数据");

#printf()打印任意数量的对象
System.out.printf("%s:%d,%s,%s,%s%n",name,idnum,address,phone,eamil);

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
- 方法的返回值
方法返回到调用它的代码处：
    - 完成方法中所有语句；
    - 遇到return 语句；
    - 抛出一个异常
# 类

## 实现接口

```java
[类修饰符] class类名称 [extends父类名称] [implements接口名称]{
    //属性、方法、构造函数声明
}
```
修饰符 public private protected

## 声明类的成员属性
```java
[方法修饰符] 返回类型 方法名称(方法的参数列表){
    //方法体语句
}

```
无返回值，返回类型标记void

## 方法重载
一个类中可以存在相同名称不通参数列表（参数数量、类型不同）的方法
```java
public class DrawDate{
    public void draw(String s){
        //描绘字符串的方法
        ...
    }
    
    public void(Int i){
        //描绘整数的方法
        。。。
    }
    
    public void(int i,double j){
        //描绘整数和浮点数的方法
        。。。
    }
}
```

## 实参、形参
调用对象的方法时，实际向方法传递的参数是实参；而在定义方法时，声明的方法参数就是形参。

成员方法中对形参的改变不会影响到实参。

## 传递任意数量的形参
可变参数是手工创建一个**数组**的简洁方法。

使用可变参数，在最后一个参数的类型后面跟上省略号'...',空格，参数名。如：
```java
public Polygon polygonFrom(Point... Centers){

}
```

## 协变返回类型
面向对象的编程中，子类在重写父类的方法时可以改变这个方法的返回值的类型，但前提是子类的返回值是父类返回值的子类。
还可以使用接口名称作为返回类型，这种情况下，返回的对象必须实现指定的接口。

## this关键字
在一个实例方法或一个构造器中，this是对当前对象的引用。

## static

- 类变量（静态属性）
有时候需要对所有对象都通用的变量。

在类中声明含有static修饰符的字段称为'静态属性'或'类变量'。它们与类相关联，而不是对象。每个类变量存贮在内存中固定的为位置。

访问类变量如 Car.Price

- 类方法（静态方法）
方法使用static修饰符。静态方法的普遍的作用是访问静态属性。

访问如 Car.getPrice()

- 常量
static与final联合使用，经常用于常量。final修饰符说明这个字段不可更改。

如：
```java
static final double PI = 3.14159265358
```

## 垃圾收集器
Java运行环境有一个垃圾收集器，它周期性地释放不再被引用的对象的内存。

<!-- # 基础包 -->
