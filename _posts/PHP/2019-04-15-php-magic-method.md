---
layout: blog
title: PHP魔术方法【draft】
categories: [cate1, cate2]
description: 魔术方法
keywords: PHP
cnblogsClass: \[Markdown\],\[随笔分类\]PHP
oschinaClass: \[Markdown\],PHP,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

<!--
title内容带draft标识草稿

cnblogsClass: 【你的博客园的分类，以逗号分隔，注意\[Markdown\]必须项】
oschinaClass: 【你的开源中国的分类】
csdnClass: 【你的CSDN分类】
...

注：由于'['、']'是jekyll的关键字，故在分类中请加上'\'；

可以在网站下添加操作看到你的博客分类，案列是自己的分类，需要自行修改。
添加这些分类的目的，是可以自动同步到对应的博客网站，新建博客以此模版文件复制创建markdown文件，如果你不需要，请跳过此步。


图片地址存放参考：
本地存放路径/WindBlog/gh-pages/images/blog/b.png
git上：
![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/b.png)

-->

做下记录，温故而知新。

# 构造函数和析构函数
__construct 构造函数 
类会在每次创建新对象时先调用此方法，所以非常适合在使用对象之前做一些初始化工作。

__deconstruct
析构函数会在到某个对象的所有引用都被删除或者当对象被显式销毁时执行。

```php
<?php
class MyDestructableClass {
    public $name;
   function __construct() {
       print "In constructor\n";
       $this->name = "MyDestructableClass";
   }

   function __destruct() {
       print "Destroying " . $this->name . "\n";
   }
}

$obj = new MyDestructableClass();
?>

```

# 方法重载
```php
public __call ( string $name , array $arguments ) : mixed
public static __callStatic ( string $name , array $arguments ) : mixed
```
在对象中调用一个不可访问方法时，__call() 会被调用。

在静态上下文中调用一个不可访问方法时，__callStatic() 会被调用。

# 属性重载
```
public __set ( string $name , mixed $value ) : void
public __get ( string $name ) : mixed
public __isset ( string $name ) : bool
public __unset ( string $name ) : void
```
在给不可访问属性赋值时，__set() 会被调用。

读取不可访问属性的值时，__get() 会被调用。

当对不可访问属性调用 isset() 或 empty() 时，__isset() 会被调用。

当对不可访问属性调用 unset() 时，__unset() 会被调用。

参数 $name 是指要操作的变量名称。__set() 方法的 $value 参数指定了 $name 变量的值。

属性重载只能在对象中进行。在静态方法中，这些魔术方法将不会被调用。所以这些方法都不能被 声明为 static

```php
<?php
class PropertyTest {
     /**  被重载的数据保存在此  */
    private $data = array();

 
     /**  重载不能被用在已经定义的属性  */
    public $declared = 1;

     /**  只有从类外部访问这个属性时，重载才会发生 */
    private $hidden = 2;

    public function __set($name, $value) 
    {
        echo "Setting '$name' to '$value'\n";
        $this->data[$name] = $value;
    }

    public function __get($name) 
    {
        echo "Getting '$name'\n";
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }

    /**  PHP 5.1.0之后版本 */
    public function __isset($name) 
    {
        echo "Is '$name' set?\n";
        return isset($this->data[$name]);
    }

    /**  PHP 5.1.0之后版本 */
    public function __unset($name) 
    {
        echo "Unsetting '$name'\n";
        unset($this->data[$name]);
    }

    /**  非魔术方法  */
    public function getHidden() 
    {
        return $this->hidden;
    }
}


echo "<pre>\n";

$obj = new PropertyTest;

$obj->a = 1;
echo $obj->a . "\n\n";

var_dump(isset($obj->a));
unset($obj->a);
var_dump(isset($obj->a));
echo "\n";

echo $obj->declared . "\n\n";

echo "Let's experiment with the private property named 'hidden':\n";
echo "Privates are visible inside the class, so __get() not used...\n";
echo $obj->getHidden() . "\n";
echo "Privates not visible outside of class, so __get() is used...\n";
echo $obj->hidden . "\n";
?>

```

# __toString() 
public __toString ( void ) : string
__toString() 方法用于一个类被当成字符串时应怎样回应。例如 echo $obj; 应该显示些什么。此方法必须返回一个字符串，否则将发出一条 E_RECOVERABLE_ERROR 级别的致命错误。
```php
<?php
// Declare a simple class
class TestClass
{
    public $foo;

    public function __construct($foo) 
    {
        $this->foo = $foo;
    }

    public function __toString() {
        return $this->foo;
    }
}

$class = new TestClass('Hello');
echo $class;
?>
```

# __invoke()
  __invoke ([ $... ] ) : mixed
  当尝试以调用函数的方式调用一个对象时，__invoke() 方法会被自动调用。
```php
  <?php
  class CallableClass 
  {
      function __invoke($x) {
          var_dump($x);
      }
  }
  $obj = new CallableClass;
  $obj(5);
  var_dump(is_callable($obj));
  ?>
```
  
