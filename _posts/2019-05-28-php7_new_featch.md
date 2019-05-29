---
layout: blog
title: php7新特性与底层实现【draft】
categories: [PHP, 知识点]
description: some word here
keywords: keyword1, keyword2
cnblogsClass: \[Markdown\],\[随笔分类\]PHP
oschinaClass: \[Markdown\],PHP,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

# 新特性

## 太空船操作符

用于比较两个表达式，如：判断$a与$b的大小，小于、等于、大于$b时，分别返回-1、0、1。
```php
<?php
echo 1 <=> 1;
```

## 标量类型声明和返回值的类型声明
参数类型声明分为默认模式和严格模式，默认模式下，当传入参数不符合声明类型时，会首先强制转换；而严格模式下，则直接报错。

可声明的参数类型：int、float、string、bool

```php
<?php
declare(strict_types=1);     //开启严格模式

//声明了参数类型和返回类型
function sumOfInts(int ...$ints): int   
{
      return array_sum($ints);
}

var_dump(sumOfInts(2,'3.1',4.1));
//运行结果
//Error: Argument 3 passed to app\commands\FeatchController::sumOfInts() must be of the type integer, float given, called in ...
```

返回值的类型默认模式下，会尝试转换，不能转换会报错，严格模式下，比如返回值必须与声明一致。

没有返回值，声明为 void，此时无论是默认还是严格模式，只要函数中有"return;"以外的其他return语句都会报错。

> 参数类型与返回值类型声明可设为可空类型，在参数或返回值声明前加上？，表示可以为null

```php
<?php
declare(strict_types=1);     //开启严格模式

//声明了参数类型和返回类型
function sumOfInts(? int ...$ints): ? int   
{
      return array_sum($ints);
}

var_dump(sumOfInts(2,3,6));
```

## null合并操作符
简化条件表达式
```php
<?php
$page = isset($_GET['page'])?$_GET['page']:0;

//语法糖 ??
$page =  $_GET['page'] ?? 0;

//连续三元运算符
$page = $_GET['page'] ?? $_POST['page'] ?? 0;
```

## 常量数组
php7之前无法通过define来定义一个数组常量。
```php
<?php
define('ANIMALS',[
    'dog',
    'cat',
    'bird'
]);

```

## namespace导入
导入同一namespace下的多个class,支持批量导入：
```php
<?php
use Space\{ClassA, ClassB, ClassC as C};
```

## throwable接口

## Closure::call()

## intdiv()
新的整除函数，在代码中不需要手动转了。
```php
<?php
//var_dump(intval(10/3));
var_dump(intdiv( 10, 3 ));
```

## list的方括号写法
```php
<?php
$arr = [1,2,3];
//list($a, $b, $c) = $arr;
[$a, $b, $c] = $arr;
```

注意：此处的[]不是数组的意思，只是list的简略形式。