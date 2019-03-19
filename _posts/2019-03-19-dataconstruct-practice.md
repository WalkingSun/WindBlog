---
layout: blog
title: 数据结构练习【draft】
categories: [数据结构, 算法]
description: some word here
keywords: 数据结构
cnblogsClass: \[Markdown\],\[随笔分类\]技术集锦,
oschinaClass: \[Markdown\],服务器,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---


1. 定义数组类实现动态定义长度，添加，插入，编辑，查询，搜索，排序
```python
#!/usr/bin/python
# -*- coding: UTF-8 -*-

class ArrayClass:
    '数组类'         #类文档字符串

    # 数组声明
    def __init__(self,len=10):
        self.len = len
        self.size=0
        self.arr = [0 for i in range(len)]

    # 数组长度
    def count(self):
        return self.len

    # 数组添加
    def add(self,value):
        self.arr[self.size] = value
        self.size +=1
        return self.arr

    # 数组插入
    def insert(self,index,value):
        for i in reversed(range(self.len)):
            if(i>=index and i!=(self.len-1) ):
                self.arr[i+1] = self.arr[i]
        self.arr[index] = value
        self.size +=1
        return self.arr

    # 数组查询
    def select(self):
        return self.arr

    # 数组检索
    def check(self,value):
        index = ''
        for i in range(self.len):
            if(self.arr[i]==value):
                index=index+str(i)+' '
        if(index==''):
            return False
        return index

    # 数组排序
    def sort(self,way='asc'):
        if way=='asc':
            for i in range(0,self.len):
                min = self.arr[i]
                for j in range(i+1,self.len):
                    if(self.arr[j]<min):
                        min = self.arr[j];
                        self.arr[j] = self.arr[i]
                        self.arr[i] = min
        else:
            for i in range(0,self.len):
                max = self.arr[i]
                for j in range(i+1,self.len):
                    if(self.arr[j]>max):
                        max = self.arr[j];
                        self.arr[j] = self.arr[i]
                        self.arr[i] = max
        return self.arr
```
