---
layout: post
title: Mysql B+树 算法【draft】
categories: [DB,MySQL]
description: 理解btree
keywords: btree
cnblogsClass: \[Markdown\],\[随笔分类\]数据库
oschinaClass: \[Markdown\],数据库,日常记录
---

对mysql Innodb存储引擎下b+树索引及算法进行简单剖析，做下记录。

# B+树
B+树从平衡二叉树演化而来，但B+树不是一个二叉树，严格来说是多路平衡多叉树。

**B+树索引能找到的只是被查找数据行所在的页。然后数据库通过把页读入到内存，再在内存中进行查找，最后得到查找的数据。**

> 二叉查找树
左子树的键值总是小于根的键值，右子树的键值总是大于根的键值。

通过中序遍历可以得到键值的排序输出。

对于一个非满的二叉查找树，左子树的高度可能远小于右子树的高度或者二叉树退还成链表，查询的效率就会收到影响，所以出现了平衡二叉树（或称为AVL）。

> 平衡二叉树：
- 符合二叉查找树的定义
- 满足任何节点的左右子树的高度最大差为1。

> B+树

B+树是为磁盘或其他直接存取辅助设备而设计的一种平衡查找树，在B+树中，所有记录节点都是按键值的大小顺序存放在同一层的叶节点中，各节点指针进行连接。

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/WechatIMG29.jpeg)

## B+树的插入操作
B+树的插入必须保证插入后的叶节点中的记录依然排序，同时考虑插入B+树的三种情况。

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/WechatIMG301111.jpeg)
//todo 滕抄下

> 实例分析下B+树

- 插入28键值，此时发现Leaf page 和Index page都没有满，直接插入即可

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/WechatIMG31.jpeg)

- 插入70键值，发现Leaf page已经满了，Index page没有满，此时插入到Leaf page中，值为50、55、60、65、70，根据中间值60拆分叶节点

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/WechatIMG32.jpeg)

- 最后插入95，此时Leaf page和Index page都满了，这时需要做二次拆分。

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/WechatIMG33.jpeg)

不管怎么变化，B+树总是会保持平衡。但为了保持平衡需要做大量的拆分页操作，而B+树主要用于磁盘，因此页的拆分意味着磁盘的操作，在可能的情况下尽量减少页的拆分。故B+树提供了旋转（rotation）功能。


页的旋转  避免了页的拆分
![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/WechatIMG34.jpeg)
