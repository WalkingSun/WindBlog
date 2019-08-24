---
layout: blog
title: php的foreach原理【draft】
categories: [PHP, 知识点]
description: php中foreach内部调用原理
keywords: php, foreach
cnblogsClass: \[Markdown\],\[随笔分类\]PHP
oschinaClass: \[Markdown\],PHP,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

7.x 的foreach已经不会修改内部指针了

```php
<?php
# 值遍历
$arr = [0, 1, 2, 3, 4, 5];
$ref = &$arr;
foreach ($arr as $v) {
    if ($v === 0) {
        unset($arr[3]);
    }
    echo $v;
}
// output in 5.x: 01245
// output in 7.x: 012345  // 7.x版本下，通过值遍历时，底层操作的始终是数组的副本

# 通过引用来进行迭代 foreach ($arr as &$v)
$arr = [0, 1, 2, 3, 4, 5];
foreach ($arr as &$v) {
    if ($v === 0) {
        unset($arr[3]);
    }
    echo $v;
}
// output in 5.x: 01245
// output in 7.x: 01245

```



# 引用事例

```php
<?php
$data = ['a','b','c'];

foreach ($data as $k => &$v){
    //
    
}

var_dump($data);


foreach ($data as $k => $v){
    //
    
}

var_dump($data);

```

第一次输出 ['a','b','c']

第二次输出 ['a','b','b']

第一次遍历运用引用 $v的地址指向数组最后一个位置，即c的位置；

第二次遍历将值赋给$v,值a赋给$v,指向c，此时a[2]=a;执行到第二个元素，b赋给$v,赋给$v指向地址a[2],此时数组a[2]=b;执行到第3个元素，此时a[2]=b,b赋给$v,赋给$v指向地址,此时数组a[2]=b


https://segmentfault.com/a/1190000019637833



