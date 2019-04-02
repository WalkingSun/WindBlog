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
bicycle = ['mobike','永久','小黄车','blue'];
```
### curd
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

- 切片

创建切片，指定要使用的第一个元素和最后一个元素的索引。

```python
print(bicycle[0:3])

print(bicycle[:3])  # 未指定第一个元素，默认0

print(bicycle[0:])  # 未指定做后一个元素，默认终止索引

print(bicycle[:])
```

遍历切片
```python
for value in bucycle[0:2]:
    print(value.title)
```

复制列表
```python
list = bicycle[:]
```

### sort

- sort()方法对列表排序【按ASCII码排序】，永久性的修改列表的排列顺序。

sort(bicycle)

- sorted()对列表进行临时排序

new_bicycle = sorted(bicycle) //new_bicycle和bicycle结果不一样

### reverse
反转列表元素的排列顺序,永久性修改列表顺序。

bicycle.reverse()

### len 长度

len(bicycle) 获取列表长度。

### in 检查特定值是否在列表中

```
'blue' in bicycle   # True
```

反之  not in

## 元祖

Python将不能修改的值称为不可变的，而不可变的列表称为元祖。

元祖看起来跟列表差不多，但使用圆括号标识。可以像列表一样去查询获取元素。

```python
list = (1,2,3,4,5)
print(list[0])
```

元素不可修改，但可以修改元祖变量。
```python
list = (1,2,3)
list = (3,4,5)
```

## 字典
字典是一系列键值对。使用键可以访问值。

```python
alien = {'color':'green','points':5}
print(alien.color)
```

字典是一种动态结构，可随时添加键值对。
```python
alien['x_position']=0
alien['y_position']=1
```

创建空字典：alien = {}

删除键值对：
```
del alien['points']
```

遍历字典 for k,v in list.items():
```python
for key,val in alien.items():
    print('key：'+key+'\n')
    print('value：'+val)    
```

keys()获取字典所有键
```python
for key in alien.keys():
    print(key.title)
```

按顺序遍历字典中所有键
```python
for key in sorted(alien.keys()):
    print(key.title)
```

values() 获取字典所有值

## 字典列表
字典作为列表的元素
```
list = [ alien0, alien1, alien2 ]
```

除此之外，字典可嵌套字典。


# 逻辑表达式

- if

```python
if condition:
    do something
elif condition:
    do something
else
    do something
```

condition结果bool型 True False

检查是否相等区分大小写，如果不区分大小写。可以：
```python
car = 'Audi'
car.lower() == 'audi'
```

and 检查多个条件，全部需命中

or  检查多个条件，一个命中


# 输入输出
input()让程序暂停运行，等待用户输入一些文本。获取用户输入后，python将其存储在一个变量。
```python
message = input("tell me your name")
print("welconme,"+message)
```


# 常见函数

## range()

- 使用range()轻松生成一系列数字。

```python
# 依次打印1到5的数字
for value in range(1,5)
    print(value)
```

- 利用range()创建数字列表

number = list(range(1,5))

## min 、max 、sum

```python
min(number)
max(number)
sum(number)

```



# 注意

- 避免缩进错误。python根据缩进来判读代码行与前一个代码行的关系。







