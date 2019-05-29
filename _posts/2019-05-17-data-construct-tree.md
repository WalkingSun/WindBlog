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


栈实现示意图：
![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/Screenshot_20190520-223339.jpg)

二分搜索树的非递归实现比递归实现复杂很多；

中序遍历和后序遍历的非递归实现更复杂；

中序遍历和后序遍历的非递归实现，实际运用不广；

