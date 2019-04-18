---
layout: blog
title: python基础
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

- while

不断的运行，直到条件不满足为止

break 退出循环

continue 跳过本次操作

在遍历列表的同时取修改数据，使用while更方便。

如：删除包含特定值的所有列表元素
```python
perts = ['dog','cat',dog','goldfish','cat','rabbit','cat']
print(perts)
while 'cat' in perts:
    perts.remove('cat')
print(perts)
```

如：用户输入来填充字典
```python
reponse = {}
polling_active=True
while polling_active:
    name = input("\nwhat's your name")
    res = input("which mountain would you like to climb someday")
    reponse[name] = res
    repeat = input("Would you like let another person repond?(y/n)")
    if repeat=='n'
      polling_active = False

print("\n -- poll reponse")
for name,res in reponse:
    print("name: "+name+" res:"+res)
```

# 输入输出
input()让程序暂停运行，等待用户输入一些文本。获取用户输入后，python将其存储在一个变量。
```python
message = input("tell me your name")
print("welconme,"+message)
```

# 运算符
 % 取模 / 取余

# 函数

## 定义函数
关键字def定义
```python
def getuser():
    //函数体
```

- 使用任意数量的关键字实参

```python
# 形参**user_info 代表键值对构成的字典
def build_profile( first, last, **user_info ):

```
## main函数
定义的main()函数只有当该Python脚本直接作为执行程序时才会执行
```python
if __name__ == '__main__':
    main()   #执行体
```

## 导入文件函数
- import pizza 打开pizza.py，并将其中所有的函数复制到当前程序中。

使用某个函数：pizza.function_name()

- 导入特定函数

from moudle_name import function_name

多个函数

from moudle_name import function_0,fuction_1,function_2

调用函数：moudle_name.function_name


- 使用as给函数指定别名

from pizza import make_pizza as mp

调用函数：mp(1,2)

- 使用as给模块指定别名

import pizza as p

调用函数：p.make_pizza(1,2)

- 导入模块中的所有函数

from pizza import *

调用函数：

make_pizza(1,2)

## 文件操作 

- 创建一个包含文件各行内容的列表
使用关键字with时，open()返回的文件对象只在with代码块内可用。如果要在with代码块外访问文件的内容，可在with代码块内将文件存储在一个列表中，并在with代码块外使用该列表。
```python
filename = 'pi_digits.txt'
with open(filename) as file_object:   #file_object 文件对象
    lines = file_object.readlines()   # readlines()读取文件每一行存储到列表中

for line in lines:
    print(line.rstrip())              #rstrip()删除首尾空格
```

要以每次一行的方式检查文件，可对文件对象进行for循环处理：
```python
filename = 'pi_digits.txt'
with open(filename) as file_object:
    for line in file_object:
        print(line)
```

打开读取文件，内容显示在屏幕上
```python
filename = 'pi_digits.txt'
with open(filename) as file_object:
    contents = file_object.read()         #read() 读取文件内容
    print(contents)
```

**关键字with不再访问文件后会关闭文件，无需显示调用close()，这样避免在程序出错，没有关闭文件。**

- 写入空文件

```python
filename = 'programmering.txt'
with open(filename,'w') as file_object:
    file_object.write("I love programmering")
```
open第二个实参是打开的模式，'w'是写入模式，'r'是读取模式，'a'是附加模式，'r+'是读取写入模式，默认以只读模式打开。

**python只能将字符串写入文本文件。要将数值存储到文本文件中，必须使用str()转换为字符串格式。**

## json

- json_dump 数据存储到文件中
```python
import json
numbers = [2,3,5,7,13]
filename='numbers.json'
with open(filename,'w') as f_obj:
    json_dump(numbers,f_obj);
```

- json_load 数据存储到内存中
```python
import json
filename='numbers.json'
with open(filename,'w') as f_obj:
    numbers = dump.load(f_obj)
print(numbers)
```

程序间进行数据交互可以使用。

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

## int、float
int()将字符串转换为int
float()将字符串转换为float

比如当从文件中国读取文件获得一个数字，就需要转换使用。


# 类

```python
calss Dog():
    """备注""""
    
    name
    
    //构造函数
    def __init__( self, name ):
        self.name = name
    
    def eat():
        #函数体
```

修改属性的方式有三种：使用类的实例来修改；类中的方法来修改；使用方法进行递增（指定特定的值）

## 继承

```python
class Person(object):   # 定义一个父类

    def talk(self):    # 父类中的方法
        print("person is talking....")   


class Chinese(Person):    # 定义一个子类， 继承Person类

    def walk(self):      # 在子类中定义其自身的方法
        print('is walking...')
```

## 导入
```python
from car import Car #从car.py导入Car类

from car import Car, ElectricCar   #导入多个类

import car   #导入整个模块

from moudle_name import *  #导入模块所有的类
```

# 异常
未对异常进行处理，程序将停止运行，并显示一个traceback（包含有关异常的报告），反之程序可以继续运行。

```python
try:
   print(5/0)
except ZeroDivisionError:
    print("You can't divide by zero")
    //pass    #pass跳过异常，充当占位符，提醒程序什么都不做
```



# 单元测试
单元测试用于核实函数的某个方面没有问题；测试用例是一组单元测试。

# 构建工具setup.py
安装依赖包，类似php composer
https://www.cnblogs.com/maociping/p/6633948.html

# 注意

- 避免缩进错误。python根据缩进来判读代码行与前一个代码行的关系。
- 类的编码风格，类名使用驼峰命名法，即类名单词首字母大写，实例名和模块名小写格式，并在单词间使用下划线。
- python 包就是文件夹，但该文件夹下面必须有个__init__.py 文件







