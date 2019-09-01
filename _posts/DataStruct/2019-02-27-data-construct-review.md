---
layout: blog
title: 算法review
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

记录。

# 给定一个n x m 的二维数组，行和列都是顺序的，写出算法求目标值是否在其中。

比如这样的数组查找7是否在其中，说说思路及复杂度 。
```
[ 
    [2,3,5,9],
    [3,4,7,10],
    [4,5,8,12],
    [6,8,9,15]
]
```

code:
```php
<?php
 function checkValue(array $data,int $aim){
        $result = false;
        $start = 0;
        $end = count($data[0])-1;
        foreach ($data  as $k=>$v){
            $res = $this->erfenFind($v,$aim,$start,$end);
            if($res['code']==0){
                $result = true;
                break;
            }elseif($res['code']==-1){
                $result = false;
                break;
            }else{
                $start = $res['start'];
                $end = $res['end'];
            }
        }
        return $result;
    }

    function erfenFind( $data,$aim,$start,$end ){
        $len = ($end-$start)+1;
        $len_center =  $start+intval($len/2);

        $result = ['code'=>-2,'start'=>$start,'end'=>$end];

        if($aim < $data[0]){
            return ['code'=>-1,'start'=>'','end'=>''];
        }


        if($aim==$data[$start] || $aim == $data[$end] || $aim==$data[$len_center]){
            $result = ['code'=>0,'start'=>'','end'=>''];
        }


        if($start<$end && $end!=$len_center){

            if( $aim < $data[$start] ){
                return ['code'=>-2,'start'=>$start-1,'end'=>$start];
            }

            if( $aim>$data[$end] ){
                return ['code'=>-2,'start'=>$end,'end'=>$end];
            }

            if( $aim<$data[$len_center] ){
                $result = $this->erfenFind($data,$aim,$start,$len_center);
            }else{
                $result = $this->erfenFind($data,$aim,$len_center,$end);
            }
        }

        return $result;
    }
```

# 给定一个有序数组，进行翻转操作，将前几个元素翻到数组后面，写出查找最小值的算法，说说思路及复杂度。
 如 [4,5,6,7,8,9,10,1,2,3]
 
 
 ```php
 <?php
   function getMin( array $data,int $start,int $end ){
         $center = $start+intval(($end-$start+1)/2);
 
         if( $center==$end ){
 
             return $data[$start]<$data[$end] ?$data[$start]:$data[$end];
         }
 
         if( $data[$center]>$data[$start]){
             return $this->getMin($data,$center,$end);
         }else{
             return $this->getMin($data,$start,$center);
         }
 
 
  }
  
  $data = [4,5,6,7,8,9,10,1,2,3];
  $this->getMin($data,0,count($data)-1);
  
```
 
# 给定字符串列出他的排列组合,实现算法。

如字符串'abc'，由以下组合：

a,b,c,ab,bc,ac,abc

```php
<?php
 function get_combinations($str = '', &$comb = array())
    {
        if (trim($str) == '' || ! $str) return false;
        if (strlen($str) <= 1) {
            $comb[] = $str;
        } else {
            $str_first = $str[0];
            $comb_temp = $this->get_combinations(substr($str, 1), $comb);
            $comb[] = $str_first;
            foreach ($comb_temp as $k => $v) {
                $comb[] = $str_first . $v;
            }
        }
        return $comb;
    }
```


 

