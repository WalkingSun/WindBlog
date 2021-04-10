---
layout: blog
title: Go View Question
categories: [Go, 知识点]
description: 熟悉
keywords: Go
---

# 题目

1.

```go
func main() {
    str := "hello"
    str[0] = 'x'
    fmt.Println(str)
}
```

- A. hello
- B. xello
- C. compilation error

2. 下面代码下划线处可以填入哪个选项？

```go
func main() {
    var s1 []int
    var s2 = []int{}
    if __ == nil {
        fmt.Println("yes nil")
    }else{
        fmt.Println("no nil")
    }
}
```

- A. s1
- B. s2
- C. s1、s2 都可以

3. 下面这段代码输出什么？

```
func main() {  
    i := 65
    fmt.Println(string(i))
}
```

- A. A
- B. 65
- C. compilation error

4. 切片 a、b、c 的长度和容量分别是多少？

```go
func main() {

    s := [3]int{1, 2, 3}
    a := s[:0]
    b := s[:2]
    c := s[1:2:cap(s)]
}
```

5. 下面代码段输出什么？

```go
type Person struct {
    age int
}

func main() {
    person := &Person{28}

    // 1. 
    defer fmt.Println(person.age)

    // 2.
    defer func(p *Person) {
        fmt.Println(p.age)
    }(person)  

    // 3.
    defer func() {
        fmt.Println(person.age)
    }()

    person.age = 29
}
```

6. return 之后的 defer 语句会执行吗，下面这段代码输出什么？

```
var a bool = true
func main() {
    defer func(){
        fmt.Println("1")
    }()
    if a == true {
        fmt.Println("2")
        return
    }
    defer func(){
        fmt.Println("3")
    }()
}
```

7. 下面这段代码输出什么？

```go
func main() {
    a := 1
    b := 2
    defer calc("1", a, calc("10", a, b))
    a = 0
    defer calc("2", a, calc("20", a, b))
    b = 1
}

func calc(index string, a, b int) int {
    ret := a + b
    fmt.Println(index, a, b, ret)
    return ret
}
```

7. 下面这段代码输出什么？为什么？

```go
func (i int) PrintInt ()  {
    fmt.Println(i)
}

func main() {
    var i int = 1
    i.PrintInt()
}
```

- A. 1
- B. compilation error

9. 下面这段代码输出什么？

```go
const (
    a = iota
    b = iota
)
const (
    name = "name"
    c    = iota
    d    = iota
)
func main() {
    fmt.Println(a)
    fmt.Println(b)
    fmt.Println(c)
    fmt.Println(d)
}
```

10. 下面这段代码输出什么？为什么？

```
type People interface {
    Show()
}

type Student struct{}

func (stu *Student) Show() {

}

func main() {

    var s *Student
    if s == nil {
        fmt.Println("s is nil")
    } else {
        fmt.Println("s is not nil")
    }
    var p People = s
    if p == nil {
        fmt.Println("p is nil")
    } else {
        fmt.Println("p is not nil")
    }
}
```

11. 下面这段代码输出什么？

```go
type Direction int

const (
    North Direction = iota
    East
    South
    West
)

func (d Direction) String() string {
    return [...]string{"North", "East", "South", "West"}[d]
}

func main() {
    fmt.Println(South)
}
```

12. 下面代码输出什么？

```go
type Math struct {
    x, y int
}

var m = map[string]Math{
    "foo": Math{2, 3},
}

func main() {
    m["foo"].x = 4
    fmt.Println(m["foo"].x)
}
```

- A. 4
- B. compilation error

13. 下面这段代码输出什么？

```go
func f(n int) (r int) {
    defer func() {
        r += n
        recover()
    }()

    var f func()

    defer f()
    f = func() {
        r += 2
    }
    return n + 1
}

func main() {
    fmt.Println(f(3))
}
```

14. 下面这段代码输出什么？

```go
func main() {
    var a = [5]int{1, 2, 3, 4, 5}
    var r [5]int

    for i, v := range a {
        if i == 0 {
            a[1] = 12
            a[2] = 13
        }
        r[i] = v
    }
    fmt.Println("r = ", r)
    fmt.Println("a = ", a)
}
```

# 题解

1. C。知识点：常量，Go 语言中的字符串是只读的。

2. A。知识点：nil切片和空切片，nil 切片和 nil 相等，一般用来表示一个不存在的切片；空切片和 nil 不相等，表示一个空的集合。

3. A。UTF-8 编码中，十进制数字 65 对应的符号是 A。

4. a、b、c 的长度和容量分别是 0 3、2 3、1 2。知识点：数组或切片的截取操作。截取操作有带 2 个或者 3 个参数，形如：[i:j] 和 [i:j:k]，假设截取对象的底层数组长度为 l。在操作符 [i:j] 中，如果 i 省略，默认 0，如果 j 省略，默认底层数组的长度，截取得到的**切片长度和容量计算方法是 j-i、l-i**。操作符 [i:j:k]，k 主要是用来限制切片的容量，但是不能大于数组的长度 l，截取得到的**切片长度和容量计算方法是 j-i、k-i**

5. 29 29 28; 第二个defer，传入的函数参数是一个*，当变量值改变时，也会随着改变

6. defer 关键字后面的函数或者方法想要执行必须先注册，return 之后的 defer 是不能注册的， 也就不能执行后面的函数或方法。

7. 10 1 2 3
   20 0 2 2
   2 0 2 2
   1 1 3 4

8. B。**基于类型创建的方法必须定义在同一个包内**，上面的代码基于 int 类型创建了 PrintInt() 方法，由于 int 类型和方法 PrintInt() 定义在不同的包内，所以编译出错。解决的办法可以定义一种新的类型：

   ```go
   type Myint int
   
   func (i Myint) PrintInt ()  {
       fmt.Println(i)
   }
   
   func main() {
       var i Myint = 1
       i.PrintInt()
   }
   ```

9. 0 1 1 2。知识点：iota 的用法。

   iota 是 golang 语言的常量计数器，只能在常量的表达式中使用。

   iota 在 const 关键字出现时将被重置为0，const中每新增一行常量声明将使 iota 计数一次。

10. `s is nil` 和 `p is not nil`。这道题会不会有点诧异，我们分配给变量 p 的值明明是 nil，然而 p 却不是 nil。记住一点，**当且仅当动态值和动态类型都为 nil 时，接口类型值才为 nil**。上面的代码，给变量 p 赋值之后，p 的动态值是 nil，但是动态类型却是 *Student，是一个 nil 指针，所以相等条件不成立。

11. South。知识点：iota 的用法、类型的 String() 方法。

    根据 iota 的用法推断出 South 的值是 2；另外，如果类型定义了 String() 方法，当使用 `fmt.Printf()`、`fmt.Print()` 和 `fmt.Println()` 会自动使用 String() 方法，实现字符串的打印

12. B，编译报错 `cannot assign to struct field m["foo"].x in map`。错误原因：对于类似 `X = Y`的赋值操作，必须知道 `X` 的地址，才能够将 `Y` 的值赋给 `X`，但 go 中的 map 的 value 本身是不可寻址的。

    有两个解决办法：

    1.**使用临时变量**

    ```go
    type Math struct {
        x, y int
    }
    
    var m = map[string]Math{
        "foo": Math{2, 3},
    }
    
    func main() {
        tmp := m["foo"]
        tmp.x = 4
        m["foo"] = tmp
        fmt.Println(m["foo"].x)
    }
    ```

    2.**修改数据结构**

    ```go
    type Math struct {
        x, y int
    }
    
    var m = map[string]*Math{
        "foo": &Math{2, 3},
    }
    
    func main() {
        m["foo"].x = 4
        fmt.Println(m["foo"].x)
        fmt.Printf("%#v", m["foo"])   // %#v 格式化输出详细信息
    }
    ```

13. 7。“三步拆解法”，第一步执行`r = n +1`，接着执行第二个 defer，由于此时 f() 未定义，引发异常，随即执行第一个 defer，异常被 recover()，程序正常执行，最后 return。

14. ```
    r =  [1 2 3 4 5]
    a =  [1 12 13 4 5]
    ```

    range 表达式是副本参与循环