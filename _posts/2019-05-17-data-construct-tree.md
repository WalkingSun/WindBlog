---
layout: blog
title: 数据结构-树【draft】
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

# 树
树结构是天然的组织结构，如计算机中的文件夹，mysql的存贮结构。

使用树结构存储后，出奇高效

分布：

- 二分搜索树
- 平衡二叉树：AVL；红黑树
- 堆；并查集
- 线段树；Tire（字典树，前缀树）

## 二叉树
![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/WX20190518-161058@2x.png)

- 和链表一样，动态的数据结构
- 二叉树具有唯一根节点
- 二叉树每个节点最多两个孩子
- 每个节点最多一个父亲
- 二叉树具有天然递归结构
 - 每个节点的左子树也是二叉树
 - 每个节点的右子树也是二叉树
- 二叉树不一定是'满'的（一个节点也是二叉树，空也是）


```java
Class Node{
    E e;
    Node left;
    Node right;
}
```
- 二叉树（多叉树）

### 二分搜索树
- 二分搜索树也是二叉树
- 二分搜索树的每个节点的值：
    - 大于其左子树的所有节点的值
    - 小于其右子树的所有节点的值
- 每个子树也是二分搜索树

> 添加新元素

二分搜索树不包含重复元素，如果想包含重复元素的话，只需定义：左子树小于等于节点；或者右子树大于等于节点。（注意数组链表支持重复元素）

二分搜索树添加元素的非递归写法和链表很像。

遍历类型：前序遍历、中序遍历、后序遍历（递归、队列、栈）、层序遍历

层序遍历：

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/Screenshot_20190521-225237.jpg)


[二分搜索树操作代码](https://github.com/WalkingSun/Jump/blob/master/models/TreeBinarySearch.php)
```php
<?php
/**二分搜索树操作
 * Class TreeBinarySearch
 * @package app\models
 */
class TreeBinarySearch
{
    public $val = null;
    public $left = null;
    public $right = null;

    public function __construct($value=null){
        $this->val = $value;
    }


    /**添加元素
     * @param $value
     * @return TreeBinarySearch
     */
    public function add( $value ){
        $node = $this;
        return $this->add2($node,$value);
    }


    /**查询
     * @param string $type 'pre'前序遍历，'in'中序遍历，'last'后序遍历
     */
    public function select( $type='pre' ){
        switch ( $type ){
            case 'pre':
                $this->selectPreorderByStack($this);
                break;
            case 'in':
                $this->selectInorder($this);    //中序结果是顺序结构
                break;
            case 'last':
                $this->selectLastorder($this);   //后序遍历 应用：未二分搜索树释放内存
                break;
        }
    }


    public function add2( $node,$value ){
        if(!is_object($node)){
            $node = new TreeBinarySearch(null);
        }

        if( $node->val == $value ){
            return $node;
        }

        if( $node->val == null ){
            $node->val = $value;
            return $node;
        }

        if( $node->val > $value){
             $node->left = $this->add2($node->left,$value);
        }

        if( $node->val < $value ){
             $node->right = $this->add2($node->right,$value);
        }

        return $node;
    }


    /**
     * 前序遍历
     */
    public function selectPreorder($node,$level=1){
        if( $node == null ){
            return;
        }

        echo $this->deepShow($level);
        echo $node->val . "\n";

        $this->selectPreorder($node->left,$level+1);

        $this->selectPreorder($node->right,$level+1);
    }


    /**
     *  前序遍历（栈）
     */
    public function selectPreorderByStack($node){
        //栈
        $stack = [];
        array_push($stack,$node);
        while (!empty($stack)){

            $cur = array_pop($stack);

            echo $cur->val . "\n";


            if( $cur->right ){
                $stack[] = $cur->right;
            }

            if( $cur->left ){
                $stack[] = $cur->left;
            }
        }
    }

    /**
     * 中序遍历
     */
    public function selectInorder($node,$level=1){
        if( $node == null ){
            return;
        }

        $this->selectInorder($node->left,$level+1);

        echo $this->deepShow($level);
        echo $node->val . "\n";

        $this->selectInorder($node->right,$level+1);
    }

    /**
     * 中序遍历(栈)
     */
    public function selectInorderByStack($node){

        $stack = [$node];
        while( !empty($stack) ){

            $cur = array_pop($stack);

            if( $cur->left ){
                $stack[] = $cur->left;
            }else{
                echo $cur->val . "\n";
            }


            if( $cur->right ){
                $stack[] = $cur->right;
            }else{
                echo $cur->val . "\n";
            }




        }



    }

    /**
     * 后序遍历
     */
    public function selectLastorder($node,$level=1){
        if( $node == null ){
            return;
        }

        $this->selectLastorder($node->right,$level+1);

        echo $this->deepShow($level);
        echo $node->val . "\n";

        $this->selectLastorder($node->left,$level+1);

    }


    /**
     * 树深度
     */
    protected function deepShow($deep){
        while($deep--){
            echo '--';
        }
    }

    /**
     * 删除最小节点
     * @param TreeBinarySearch $node
     */
    public function deleteMin( $node ){
        if( $node->left==null ){
            $rightNode = $node->right;
            $node->right = null;
            return $rightNode;
        }

        $node->left = $this->deleteMin($node->left);
        return $node;
    }

    /**
     * 删除最大节点
     * @param  TreeBinarySearch $node
     */
    public function deleteMax($node){
        if( $node->right == null ){
            $leftNode = $node->left;
            $node->left = null;
            return $leftNode;
        }
        $node->right = $this->deleteMax($node->right);
        return $node;
    }
}
```

栈实现示意图：
![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/Screenshot_20190520-223339.jpg)

二分搜索树的非递归实现比递归实现复杂很多；

中序遍历和后序遍历的非递归实现更复杂；

中序遍历和后序遍历的非递归实现，实际运用不广；

