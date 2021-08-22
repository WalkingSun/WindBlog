---
layout: blog
title: 风车排列
categories: [数据结构]
description: some word here
keywords: 算法
cnblogsClass: \[Markdown\],\[随笔分类\]数据结构与算法
oschinaClass: \[Markdown\]
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

# 实现一个function foo($num) 完成如下功能
```
// foo(1) = [[1]];
// foo(2) = [ [1,2]
//            [4,3]  ];
// foo(3) = [ [7,8,9]
//            [6,1,2]
//            [5,4,3] ];
// foo(4) = [ [7,8,9,10]
//            [6,1,2,11]
//            [5,4,3,12]
//            [16,15,14,13] ];
//
// foo(5)....
//
// foo(n)...
//依次类推，组成一个风车型排列

```

# 题解
```php
<?php

$num = 10;
$arr = foo($num);
for( $i = 0; $i < $num ; $i ++  ){
    echo implode(", ", $arr[$i]) . "\n";
}

function foo($num){
    $data = [];
    $offset = 1;   //初始偏移量
    $val = 1;
    $starti = ceil($num/2)!=0?ceil($num/2)-1:0;
    $startj = $starti;
    $data[$starti][$startj] = $val++;   //首项值
    while( $offset<=$num && $val<=$num*$num ){

        //顺序横向
        $endj =  $startj+$offset>$num-1?$num-1:$startj+$offset;
        for($j=&$startj;$j<=$endj;$j++){
            $data[$starti][$startj] = $data[$starti][$startj]??$val++;
        }
        $j--;

        //顺序纵向
        $endi =  $starti+$offset>$num-1?$num-1:$starti+$offset;
        for($i=&$starti;$i<$endi;$i++){
            $data[$starti+1][$startj] = $data[$starti+1][$startj]??$val++;
        }
        $offset++;

        //逆序横向
        $endj =  $startj-$offset<0?0:$startj-$offset;
        for($j=&$startj;$j>$endj;$j--){
            $data[$starti][$startj-1] = $data[$starti][$startj-1]??$val++;
        }

        //逆序纵向
        $endi =  $starti-$offset<0?0:$starti-$offset;
        for($i=&$starti;$i>$endi;$i--){
            $data[$starti-1][$startj] = $data[$starti-1][$startj]??$val++;
        }

        $offset++;
    }

    for($i=0;$i<$num;$i++){
        ksort($data[$i]);
    }
    ksort($data);

    return $data;
}
```

这不是最好的方法，确实是最容易理解的，其他方法以后补充。