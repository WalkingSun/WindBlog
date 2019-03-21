---
layout: blog
title: 数据结构练习（一）【draft】
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

    # 数组编辑
    def set(self,index,value):
        self.arr[index]=value;
        return self.arr[index]

    # 数组查询
    def select(self,index=False):
        if(index and index>=self.len):
            return False
        if(index):
            return self.arr[index]
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

2. 给定一个排序数组，你需要在原地删除重复出现的元素，使得每个元素只出现一次，返回移除后数组的新长度。
   
   不要使用额外的数组空间，你必须在原地修改输入数组并在使用 O(1) 额外空间的条件下完成。
   
   示例 1:
   
   给定数组 nums = [1,1,2], 
   
   函数应该返回新的长度 2, 并且原数组 nums 的前两个元素被修改为 1, 2。 
   
   你不需要考虑数组中超出新长度后面的元素。
   示例 2:
   
   给定 nums = [0,0,1,1,1,2,2,3,3,4],
   
   函数应该返回新的长度 5, 并且原数组 nums 的前五个元素被修改为 0, 1, 2, 3, 4。
   
   你不需要考虑数组中超出新长度后面的元素。

时间复杂度O(n)
```php
class Solution {

    /**
     * @param Integer[] $nums
     * @return Integer
     */
    function removeDuplicates(&$nums) {
        $n = count($nums);
        $cur = 0;
        for($i=1;$i<$n;$i++){
            if($nums[$i]!=$nums[$cur]){
               $nums[++$cur]=$nums[$i];
            }           
            if($cur!=$i) unset($nums[$i]);
        }
        return $cur+1;
    }
}
```

3. 给定一个只包括 '('，')'，'{'，'}'，'['，']' 的字符串，判断字符串是否有效。
   
   有效字符串需满足：
   
   左括号必须用相同类型的右括号闭合。
   左括号必须以正确的顺序闭合。
   注意空字符串可被认为是有效字符串。
   
   示例 1:
   
   输入: "()"
   输出: true
   示例 2:
   
   输入: "()[]{}"
   输出: true
   示例 3:
   
   输入: "(]"
   输出: false
   示例 4:
   
   输入: "([)]"
   输出: false
   示例 5:
   
   输入: "{[]}"
   输出: true

解题思路，运用栈：
```php
<?php
class Solution {

    /**
     * @param String $s
     * @return Boolean
     */
    function isValid($s) {
        $ss=[];
        $length = strlen($s);
        for($i=0;$i<$length;$i++){
            $t=substr($s,$i,1);
            if($t=='('||$t=='['||$t=='{'){
                array_push($ss,$t);
            }else{
                if(empty($ss)) return false;
                $end = end($ss);
               if( ($end=='(' && $t==')') || ($end=='[' && $t==']') || ($end=='{' && $t=='}') ){
                   array_pop($ss);
               }else{
                   return false;
               }
               
            }
        }
        if($ss) return false;
        return true;
    }
}
```




3. 给定两个没有重复元素的数组 nums1 和 nums2 ，其中nums1 是 nums2 的子集。找到 nums1 中每个元素在 nums2 中的下一个比其大的值。
   
   nums1 中数字 x 的下一个更大元素是指 x 在 nums2 中对应位置的右边的第一个比 x 大的元素。如果不存在，对应位置输出-1。
   
   示例 1:
   
   输入: nums1 = [4,1,2], nums2 = [1,3,4,2].
   输出: [-1,3,-1]
   解释:
       对于num1中的数字4，你无法在第二个数组中找到下一个更大的数字，因此输出 -1。
       对于num1中的数字1，第二个数组中数字1右边的下一个较大数字是 3。
       对于num1中的数字2，第二个数组中没有下一个更大的数字，因此输出 -1。
   示例 2:
   
   输入: nums1 = [2,4], nums2 = [1,2,3,4].
   输出: [3,-1]
   解释:
       对于num1中的数字2，第二个数组中的下一个较大数字是3。
       对于num1中的数字4，第二个数组中没有下一个更大的数字，因此输出 -1。

```php
<?php
class Solution {

    /**
     * @param Integer[] $nums1
     * @param Integer[] $nums2
     * @return Integer[]
     */
    function nextGreaterElement($nums1, $nums2) {
        $n = count($nums2);
        $map = [];
        for($i=0;$i<$n;$i++){
            $k=$i;
            $map[$nums2[$i]]=-1;
            
            while(++$k<$n){
                 if($nums2[$k]>$nums2[$i]){
                    $map[$nums2[$i]]=$nums2[$k];
                    break;
                 }   
            }   
        }
        
        $r=[];
        for($i=0;$i<count($nums1);$i++){
            $r[]=$map[$nums1[$i]];
        }
        //测试用例没通过，搞不懂
        //  while($num=array_pop($nums1)){
                //       $r[]=$map[$num];
                // }
        //array_shift($r);        
                
        return $r;
        
        
    }
}
```
