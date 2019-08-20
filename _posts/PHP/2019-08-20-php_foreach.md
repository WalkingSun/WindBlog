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

https://segmentfault.com/a/1190000019637833



