---
layout: blog
title: python基础【draft】
categories: [python]
description: python基础
keywords: python
cnblogsClass: \[Markdown\],\[随笔分类\]python
oschinaClass: \[Markdown\],python,服务器,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

# 运算
使用两个*表示乘方运算。
```python
>>> 3**29
```

# 拼接
str将非字符串转成字符串。
```python
age = 23
message = "Happy " + str(age) + "rd Birthday!"
print(message)
```

# 数据结构

## list（列表）
如：
```python
bicycle = ['mobike','永久','小黄车'];
```

- 取最后一个元素

bicycle[-1]

- 列表末尾添加新元素

bicycle.append('999')

- 插入元素

bicycle.insert(0,'哈啰单车');  //0 代表列表索引

- del删除元素【知道其索引】

del bicycle[0]  

- pop删除元素

移除列表中的一个元素（默认最后一个元素），并且返回该元素的值

list.pop([index=-1])

obj -- 可选参数，要移除列表元素的索引值，不能超过列表总长度，默认为 index=-1，删除最后一个列表值。

append和pop结合可以做栈，遵循LIFO

- remove根据值删除元素

bicycle.remove('mobike')

注意：remove()只删除第一个指定的值。如果需要删除所有，需要自己循环判断。


