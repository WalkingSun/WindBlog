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

