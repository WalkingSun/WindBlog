---
layout: blog
title: 全排列
categories: [数据结构]
description: 获取字符串的全排列
keywords: 算法
cnblogsClass: \[Markdown\],\[随笔分类\]数据结构与算法
oschinaClass: \[Markdown\]
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

# 输入一个字符串，打印出该字符串的所有排列。

例如输入字符串abc，则输出由字符a、b、c所能排列出来的所有字符串 abc,acb,bac,bca,cab,cba。

# 题解
了解下排列的数学知识：

排列的定义：从n个不同元素中，任取m(m≤n,m与n均为自然数,下同）个元素按照一定的顺序排成一列，叫做从n个不同元素中取出m个元素的一个排列；从n个不同元素中取出m(m≤n）个元素的所有排列的个数，叫做从n个不同元素中取出m个元素的排列数，用符号 A(n,m）表示。

计算公式：![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/201908200001.png)


运用递归。

思路：轮询，递归对后面元素轮询，不断交换首项位置，让每一项可以顺序输出，递归结束恢复交换，使上层轮询结构正常。标记位置到达数组尾部，输出元素。

图示：

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/201908200002.png)


```php
<?php
    //全排列
    //$result定义字符串，担心内存超标，但字符达到8位以上，所占内存急剧膨胀
    function fullArrange( $arr,$starti=0,&$result='' )
    {
        if( count($arr)<=0 )
            throw new \Exception('空项');

        $count = count($arr);

        if($starti == $count-1){
            $result .= implode($arr)."\n";
        }

        for ($i=$starti;$i<$count;$i++) {
            if($starti!=$i){
                $tmp = $arr[$i];
                $arr[$i] = $arr[$starti];
                $arr[$starti]= $tmp;
            }

            $this->fullArrange($arr,$starti+1,$result);

            if($starti!=$i){
                $tmp = $arr[$i];
                $arr[$i] = $arr[$starti];
                $arr[$starti]= $tmp;
            }
        }
        return $result;
    }

        ini_set('max_execution_time',0);
        $str = 'abc';
        $strArr = str_split($str);
        $r = $this->fullArrange($strArr);
        var_dump($r);die;
```



