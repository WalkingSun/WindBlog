---
layout: blog
title: 集合
categories: [数据结构, 算法]
description: 数据结构与算法整理
keywords: 数据结构,算法
cnblogsClass: \[Markdown\],\[随笔分类\]技术集锦
oschinaClass: \[Markdown\],日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

# 集合
集合，是由一堆无序的、相关联的，且不重复的内存结构【数学中称为元素】组成的组合；


## 实现

实现方式主要分为两种：二分搜索树、链表；


二分搜索树实现代码参考：

[二分搜索树操作类](https://github.com/WalkingSun/Jump/blob/master/models/TreeBinarySearch.php)

[集合实现类](https://github.com/WalkingSun/Jump/blob/master/models/Set.php)

```php
<?php
class Set 
{
    protected $binarytree;

    public function __construct()
    {
        $this->binarytree = new TreeBinarySearch();
    }


    public function insert($value){
        $this->binarytree->add($value);

    }

    public function select( $value=null ){
        return $this->binarytree->select($value);
    }

    public function update( $index,$value ){
        $this->delete($index);
        return $this->insert($value);
    }

    public function delete($value){
        return $this->binarytree->delete($value);
    }

    public function isExists( $value ){
        return $this->select($value)?true:false;
    }

    public function toString(){
        return $this->select(null,'in');
    }

    public function getSize(){
        return $this->binarytree->size;
    }

}
```

## 链表实现集合与二分搜索树 性能分析

|  操作  | 链表    | 二分搜索树|
|  ----  |  ----  |  ----  |
|  插入  | O(n)   | O(log(n))  |
|  删除  | O(n)   | O(log（n）)     |
|  查询  | O（n）  |  O（log（n））|

假设二分搜索树总共h层，是一个满二叉树，一共n个节点

2^0 + 2^1 + 2^2 + 2^3 + ... +2^(h-1) = 2^h -1 = n

h = log2 (n+1) 

O(h) = O(log2 n) = O(log n)

关于运算，忘记的差不多了，此处做下备注：
```
设n＝2^0+2¹+2²+2³+……+2^(h-1)　　①
　则2n＝2^1+2²+2³+2＾4+……+2^h　②
②-①,得
n=2^h－1
```

来看下log n 与 n 具体差别
 
|  n | linkilistSet    | BSTSet | 差距 |
|  ----  |  ----  |  ----  |  ---- | 
|  16  |  4  |  16  | 4倍 |
|  1024  |  10  |  1024  | 100倍 |
|  65536  |  16  |  65536  | 4096倍 |
|  100w  |  20  |  100w  | 50w倍 |

可以看到当数量越大二分搜索树的性能很优越，但链表如果采用跳表的形式也可以实现log n的复杂度，redis集合的实现就是通过跳表实现的。