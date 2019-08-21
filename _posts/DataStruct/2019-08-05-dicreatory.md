---
layout: blog
title: php实现映射
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

```php
<?php
class DictBtree implements Dict
{
    public $key;
    public $value;

    public $left;
    public $right;
    private $size;

    public function __construct($key=null,$value=null)
    {
        $this->key = $key;
        $this->value = $value;
        $this->left = null;
        $this->right = null;
        $this->size = 0;
    }

    public function set( $key , $value ){
        if( $this->size ==0 ){
            $node = new static( $key,$value );
            $this->key = $node->key;
            $this->value = $node->value;
            $this->size++;
        }else{
            $node = $this;
            while($node){
                if( $node->key == $key ){
                    $node->value = $value;
                    break;
                }
                if($node->key>$key){
                    if($node->left==null){
                        $node->left = new static( $key,$value );
                        $this->size++;
                        break;
                    }
                    $node = $node->left;
                }else{
                    if($node->right==null){
                        $node->right = new static( $key,$value );
                        $this->size++;
                        break;
                    }
                    $node = $node->right;
                }
            }
        }

        return $this;
    }

    public function get( $key ){
        if( $this->size ==0 )
            throw new \Exception('empty');
        $node = $this;
        while($node) {
            if ($node->key == $key) {
                return $node->value;
            }
            if ($node->key > $key) {
                $node = $node->left;
            } else {
                $node = $node->right;
            }
        }
        throw new \Exception('this key not exist');
    }

    public function isExist( $key ){
        if( $this->size ==0 )
            return false;
        $node = $this;
        while($node) {
            if ($node->key == $key) {
                return true;
            }
            if ($node->key > $key) {
                $node = $node->left;
            } else {
                $node = $node->right;
            }
        }
        return false;
    }

    public function delete($key){

        //找到元素，寻找元素左边最小元素
        $node = $this->select($key);
        if( $node->right!=null ){
            $node1 = $node->selectMin($node->right);

            //替换当前node
            $node->key = $node1->key;
            $node->value = $node1->value;

            //删除$node->right最小元素，获取最终元素赋给$node->right
            $nodeMin = $this->deleteMin($node->right);
            $node->right = $nodeMin;
        }else{
            $node1 = $node->selectMax($node->left);

            $node->key = $node1->key;
            $node->value = $node1->value;

            $nodeMax = $this->deleteMax($node->left);
            $node->left = $nodeMax;
        }

       return $this;

    }

    protected function deleteMin( $node ){
//        if( $this->size ==0 )
//            throw new \Exception('empty');

//        $prev = new static();
//        $prev->left = $node;
//        while($prev->left->left!=null){
//
//            $prev = $prev->left;
//        }
//        $prev->left = $prev->left->right;

        if( $node->left==null ){
            $rightNode = $node->right;
            $node->right = null;
            $this->size--;
            return $rightNode;
        }

       $node->left = $this->deleteMin($node->left);

        return $node;
    }

    protected function deleteMax($node){

        if( $node->right==null ){
            $leftNode = $node->left;
            $node->left = null;
            $this->size--;
            return $leftNode;
        }

        $node->right = $this->deleteMax($node->right);
        return $node;

    }

    public function getSize(){
        return $this->size;
    }


    public function select($key){
        $node = $this;

        while($node){
            if($node->key==$key){
                return $node;
            }
            if ($node->key > $key) {
                $node = $node->left;
            } else {
                $node = $node->right;
            }
        }

        throw new \Exception('this key not exist');
    }

    public function selectMin( $node ){
        while($node->left){

            $node = $node->left;
        }
        return $node;
    }


    public function selectMax( $node ){
        while($node->right){

            $node = $node->right;
        }
        return $node;
    }
}
```

## 复杂读分析

链表 O(n)

二分搜索树 O（log n）