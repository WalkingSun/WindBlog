---
layout: blog
title: Go View Question
categories: [Go, 知识点]
description: 熟悉
keywords: Go
---

# 题目

## 1. 字符串读写

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

## 2. 下面代码下划线处可以填入哪个选项？

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

## 3. 下面这段代码输出什么？

```
func main() {  
    i := 65
    fmt.Println(string(i))
}
```

- A. A
- B. 65
- C. compilation error

## 4. 切片 a、b、c 的长度和容量分别是多少？

```go
func main() {

    s := [3]int{1, 2, 3}
    a := s[:0]
    b := s[:2]
    c := s[1:2:cap(s)]
}
```

## 5. 下面代码段输出什么？

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

## 6. return 之后的 defer 语句会执行吗，下面这段代码输出什么？

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

## 7. 下面这段代码输出什么？

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

## 8. 下面这段代码输出什么？为什么？

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

## 9. 下面这段代码输出什么？

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

## 10. 下面这段代码输出什么？为什么？

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

## 11. 下面这段代码输出什么？

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

## 12. 下面代码输出什么？

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

## 13. 下面这段代码输出什么？

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

## 14. 下面这段代码输出什么？

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

## 15. 下面代码有什么问题？

```
1const i = 100
2var j = 123
3
4func main() {
5    fmt.Println(&j, j)
6    fmt.Println(&i, i)
7}
```

## 16. 下面代码是否能编译通过？如果通过，输出什么？

```go
 1func Foo(x interface{}) {
 2    if x == nil {
 3        fmt.Println("empty interface")
 4        return
 5    }
 6    fmt.Println("non-empty interface")
 7}
 8func main() {
 9    var x *int = nil
10    Foo(x)
11}
```

## 17. 下面这段代码输出什么？

```go
1var x = []int{2: 2, 3, 0: 1}
2
3func main() {
4    fmt.Println(x)
5}
```

## 18. 下面代码输出什么？

```go
 type ConfigOne struct {
     Daemon string
 }
 
 func (c *ConfigOne) String() string {
     return fmt.Sprintf("print: %v", c)
 }
 
func main() {
    c := &ConfigOne{}
    c.String()
}
```

## 19. 下面的代码有什么问题？

```go
1func main() {  
2    var x = nil 
3    _ = x
4}
```

## 20. 下面代码能编译通过吗？

```go
 type info struct {
     result int
 }
 
 func work() (int,error) {
     return 13,nil
 }
 
 func main() {
    var data info

    data.result, err := work() 
    fmt.Printf("info: %+v\n",data)
}
```

## 21. 下面代码输出什么？

```go
 func test(x byte)  {
     fmt.Println(x)
 }
 
 func main() {
     var a byte = 0x11 
     var b uint8 = a
     var c uint8 = a + b
     test(c)
}
```

## 22. 下面的代码有什么问题？

```go
func main() {
    const x = 123
    const y = 1.23
    fmt.Println(x)
}
```

## 23. 下面代码输出什么？

```go
 const (
     x uint16 = 120
     y
     s = "abc"
     z
 )
 
 func main() {
     fmt.Printf("%T %v\n", y, y)
    fmt.Printf("%T %v\n", z, z)
}
```

## 24. 下面的代码能否正确输出？

```go
func main() {
    var fn1 = func() {}
    var fn2 = func() {}

    if fn1 != fn2 {
        println("fn1 not equal fn2")
    }
}
```

## 25. 下面的代码有什么问题？

```go
 func (n N) value(){
     n++
     fmt.Printf("v:%p,%v\n",&n,n)
 }
 
 func (n *N) pointer(){
     *n++
     fmt.Printf("v:%p,%v\n",n,*n)
 }


func main() {

    var a N = 25

    p := &a
    p1 := &p

    p1.value()
    p1.pointer()
}
```

## 26. 下面的代码输出什么？

```go
 type N int
 
 func (n N) test(){
     fmt.Println(n)
 }
 
 func main()  {
     var n N = 10
     fmt.Println(n)

    n++
    f1 := N.test
    f1(n)

    n++
    f2 := (*N).test
    f2(&n)
}
```

## 27. 下面的代码有什么问题？

```go
 package main
 
 import "fmt"
 
 func main() {
     s := make([]int, 3, 9)
     fmt.Println(len(s)) 
     s2 := s[4:8]
     fmt.Println(len(s2)) 
}
```

## 28. 下面代码输出什么？

```go
 type N int
 
 func (n N) test(){
     fmt.Println(n)
 }
 
 func main()  {
     var n N = 10
     p := &n

    n++
    f1 := n.test

    n++
    f2 := p.test

    n++
    fmt.Println(n)

    f1()
    f2()
}
```

## 29. 下面哪一行代码会 panic，请说明原因？

```go
package main

func main() {
  var x interface{}
  var y interface{} = []int{3, 5}
  _ = x == x
  _ = x == y
  _ = y == y
}
```

## 30. 下面哪一行代码会 panic，请说明原因？

```go
package main

func main() {
    x := make([]int, 2, 10)
    _ = x[6:10]
    _ = x[6:]
    _ = x[2:]
}
```

## 31. 下面的代码输出什么？

```go
type N int

func (n *N) test(){
    fmt.Println(*n)
}

func main()  {
    var n N = 10
    p := &n

    n++
    f1 := n.test

    n++
    f2 := p.test

    n++
    fmt.Println(n)

    f1()
    f2()
}
```

## 32. 下面哪一行代码会 panic，请说明原因？

```go
package main

func main() {
  var m map[int]bool // nil
  _ = m[123]
  var p *[5]string // nil
  for range p {
    _ = len(p)
  }
  var s []int // nil
  _ = s[:]
  s, s[0] = []int{1, 2}, 9
}
```

## 33. 下面哪一行代码会 panic，请说明原因？【指针解引用】

```go
package main
 
type T struct{}
 
func (*T) foo() {
}

func (T) bar() {
}

type S struct {
  *T
}

func main() {
  s := S{}
  _ = s.foo
  s.foo()
  _ = s.bar
}
```

## 34. 下面的代码有什么问题？

```go
type data struct {
    sync.Mutex
}

func (d data) test(s string)  {
    d.Lock()
    defer d.Unlock()

    for i:=0;i<5 ;i++  {
        fmt.Println(s,i)
        time.Sleep(time.Second)
    }
}


func main() {

    var wg sync.WaitGroup
    wg.Add(2)
    var d data

    go func() {
        defer wg.Done()
        d.test("read")
    }()

    go func() {
        defer wg.Done()
        d.test("write")
    }()

    wg.Wait()
	}
```

# 题解

## 1. 
C。知识点：常量，Go 语言中的字符串是只读的。

## 2. 
A。知识点：nil切片和空切片，nil 切片和 nil 相等，一般用来表示一个不存在的切片；空切片和 nil 不相等，表示一个空的集合。

## 3. 
A。UTF-8 编码中，十进制数字 65 对应的符号是 A。

## 4.
a、b、c 的长度和容量分别是 0 3、2 3、1 2。知识点：数组或切片的截取操作。截取操作有带 2 个或者 3 个参数，形如：[i:j] 和 [i:j:k]，假设截取对象的底层数组长度为 l。在操作符 [i:j] 中，如果 i 省略，默认 0，如果 j 省略，默认底层数组的长度，截取得到的**切片长度和容量计算方法是 j-i、l-i**。操作符 [i:j:k]，k 主要是用来限制切片的容量，但是不能大于数组的长度 l，截取得到的**切片长度和容量计算方法是 j-i、k-i**

## 5.
29 29 28; 第二个defer，传入的函数参数是一个*，当变量值改变时，也会随着改变

## 6.
defer 关键字后面的函数或者方法想要执行必须先注册，return 之后的 defer 是不能注册的， 也就不能执行后面的函数或方法。

## 7.
   10 1 2 3
   20 0 2 2
   2 0 2 2
   1 1 3 4

## 8.
B。**基于类型创建的方法必须定义在同一个包内**，上面的代码基于 int 类型创建了 PrintInt() 方法，由于 int 类型和方法 PrintInt() 定义在不同的包内，所以编译出错。解决的办法可以定义一种新的类型：

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

## 9.
0 1 1 2。知识点：iota 的用法。

   iota 是 golang 语言的常量计数器，只能在常量的表达式中使用。

   iota 在 const 关键字出现时将被重置为0，const中每新增一行常量声明将使 iota 计数一次。

## 10.
`s is nil` 和 `p is not nil`。这道题会不会有点诧异，我们分配给变量 p 的值明明是 nil，然而 p 却不是 nil。记住一点，**当且仅当动态值和动态类型都为 nil 时，接口类型值才为 nil**。上面的代码，给变量 p 赋值之后，p 的动态值是 nil，但是动态类型却是 *Student，是一个 nil 指针，所以相等条件不成立。

## 11.
South。知识点：iota 的用法、类型的 String() 方法。

    根据 iota 的用法推断出 South 的值是 2；另外，如果类型定义了 String() 方法，当使用 `fmt.Printf()`、`fmt.Print()` 和 `fmt.Println()` 会自动使用 String() 方法，实现字符串的打印

## 12.
B，编译报错 `cannot assign to struct field m["foo"].x in map`。错误原因：对于类似 `X = Y`的赋值操作，必须知道 `X` 的地址，才能够将 `Y` 的值赋给 `X`，但 go 中的 map 的 value 本身是不可寻址的。

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

## 13.
7。“三步拆解法”，第一步执行`r = n +1`，接着执行第二个 defer，由于此时 f() 未定义，引发异常，随即执行第一个 defer，异常被 recover()，程序正常执行，最后 return。

## 14.
```
    r =  [1 2 3 4 5]
    a =  [1 12 13 4 5]
```

    range 表达式是副本参与循环

## 15.
编译报错`cannot take the address of i`。知识点：常量。常量不同于变量的在运行期分配内存，常量通常会被编译器在预处理阶段直接展开，作为指令数据使用，所以常量无法寻址。

## 16.
`non-empty interface` 考点：interface 的内部结构，我们知道接口除了有静态类型，还有动态类型和动态值，当且仅当动态值和动态类型都为 nil 时，接口类型值才为 nil。这里的 x 的动态类型是 `*int`，所以 x 不为 nil。

## 17.
输出`[1 0 2 3]`，字面量初始化切片时候，可以指定索引，没有指定索引的元素会在前一个索引基础之上加一，所以输出`[1 0 2 3]`，而不是`[1 3 2]`。

## 18.
实现String方法，fmt.Sprintf执行对应String方法，造成循环调用。

## 19.
nil 用于表示 interface、函数、maps、slices 和 channels 的“零值”。如果不指定变量的类型，编译器猜不出变量的具体类型，导致编译错误。

## 20.
编译失败。

    ```shell
    non-name data.result on left side of :=
    ```
    
    不能使用短变量声明设置结构体字段值

## 21.
34。与 rune 是 int32 的别名一样，byte 是 uint8 的别名，别名类型无序转换，可直接转换。

## 22.
编译可以通过。知识点：常量。常量是一个简单值的标识符，在程序运行时，不会被修改的量。不像变量，常量未使用是能编译通过的

## 23.
知识点：常量。

    输出：
    
    ```
    uint16 120
    string abc
    ```

## 24.
编译错误

    ```
    invalid operation: fn1 != fn2 (func can only be compared to nil)
    ```
    
    函数只能与 nil 比较。

## 25.
编译错误：

    ```
    calling method value with receiver p1 (type **N) requires explicit dereference
    calling method pointer with receiver p1 (type **N) requires explicit dereference
    ```
    
    不能使用多级指针调用方法。

## 26.
10 11 12。知识点：方法表达式。通过类型引用的方法表达式会被还原成普通函数样式，接收者是第一个参数，调用时显示传参。类型可以是 T 或 *T，只要目标方法存在于该类型的方法集中就可以。

## 27.
代码没问题，输出 3 4。**从一个基础切片派生出的子切片的长度可能大于基础切片的长度**。假设基础切片是 baseSlice，使用操作符 [low,high]，有如下规则：0 <= low <= high <= cap(baseSlice)，只要上述满足这个关系，下标 low 和 high 都可以大于 len(baseSlice)。

## 28.
13 11 12。知识点：方法值。当指针值赋值给变量或者作为函数参数传递时，会立即计算并复制该方法执行所需的接收者对象，与其绑定，以便在稍后执行时，能隐式第传入接收者参数。

## 29.
第 8 行。因为两个比较值的动态类型为同一个不可比较类型。

## 30.
第 6 行，截取符号 [i:j]，如果 j 省略，默认是原切片或者数组的长度，x 的长度是 2，小于起始下标 6 ，所以 panic。

## 31.
13 13 13。知识点：方法值。当目标方法的接收者是指针类型时，那么被复制的就是指针。

## 32.
第 12 行。因为左侧的 s[0] 中的 s 为 nil

## 33.
第 19 行，因为 s.bar 将被展开为 (*s.T).bar，而 s.T 是个空指针，解引用会 panic

指针是指向变量内存地址的变量；

解引用指针的意思是通过指针访问被指向的值。指针 `a` 的解引用表示为：`*a`。

调用bar会自动解引用，s .T是空指针造成panic；

## 34.

锁失效。将 Mutex 作为匿名字段时，相关的方法必须使用指针接收者，否则会导致锁机制失效。

