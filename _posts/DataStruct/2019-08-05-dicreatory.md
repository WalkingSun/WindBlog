---
layout: blog
title: 映射【draft】
categories: [PHP, 链表]
description: php实现映射
keywords: 链表, php
cnblogsClass: \[Markdown\],\[随笔分类\]PHP,\[随笔分类\]数据结构与算法
oschinaClass: \[Markdown\],PHP,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

# 映射
映射，或者射影，在数学及相关的领域经常等同于函数。基于此，部分映射就相当于部分函数，而完全映射相当于完全函数。

映射（Map）是用于存取键值对的数据结构（key,value），一个键只能对应一个值且键不能重复。

# 实现
映射的实现方式可以使用链表或二叉树实现。

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/WX20190815-164528@2x.png)

## 链表实现：
```php
<?php
/**
 * 接口 字典
 * Interface Dict
 * @package app\models
 */
Interface Dict
{

    public function set( $key , $value );

    public function get( $key );

    public function isExist( $key );

    public function delete($key);

    public function getSize();


}

class DictLinkList implements Dict
{
    protected $size=0;
    public $key;
    public $value;
    public $next;

    public function __construct($key=null,$value=null,$next=null)
    {
        $this->key = $key;
        $this->value = $value;
        $this->next = $next;
    }

    public function set($key,$value){
        $node = $this;
        while( $node && $node->next ){
            if( $node->next->key==$key ){
                $node->next->value = $value;
                return $node->next;
            }
            $node = $node->next;
        }

        $node->next =  new self($key,$value,$node->next);
        $this->size++;
        return  $node->next;
    }


    public function get($key){
        $node = $this;
        while($node){
            if( $node->key ==$key  ){
                return $node->value;
            }
            $node = $node->next;
        }

        throw new \Exception('cannot found key');
    }


    public function isExist($key)
    {
        $node = $this;
        while($node){
            if( $node->key ==$key  ){
                return true;
            }
            $node = $node->next;
        }
        return false;
    }

    public function delete($key)
    {
        if( $this->size==0)
            throw new \Exception('key is not exist');

        $node = $this;
        while($node->next){
            if( $node->next->key == $key  ){
                $node->next = $node->next->next;
                $this->size--;
                break;
            }
            $node = $node->next;
        }

        return $this;
    }

    public function getSize()
    {
        return $this->size;
    }
}
```

测试：
```php
<?php
        $dict = new DictLinkList();
        $dict->set('sun',111); //O(n)
        $dict->set('sun',222);
        $dict->set('w',111);
        $dict->set('k',111);
        var_dump($dict->get('w'));   //O(n)
        var_dump($dict->isExist('v'));   //O(n)
        var_dump($dict->delete('sun'));    //O(n)
        var_dump($dict->getSize());
        
/******************************************/
//111
//false
//true
//2
```

## 二叉树实现
