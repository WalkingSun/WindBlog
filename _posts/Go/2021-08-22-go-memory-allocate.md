---
layout: blog
title: Go 内存分配
categories: [Go]
description: 熟悉
keywords: Go
---

程序的运行都需要内存，比如像变量的创建、函数的调用、数据的计算等。在需要内存的时候就要申请内存，进行内存分配。在 C/C++ 这类语言中，内存是由开发者自己管理的，需要主动申请和释放，而在 Go 语言中则是由该语言自己管理的，开发者不用做太多干涉，只需要声明变量，Go 语言会根据变量的类型自动分配相应的内存。

Go 语言程序所管理的虚拟内存空间会被分为两部分：堆内存和栈内存。栈内存主要由 Go 语言来管理，开发者无法干涉太多，堆内存才是我们开发者发挥能力的舞台，因为程序的数据大部分分配在堆内存上，一个程序的大部分内存占用也是在堆内存上。

> Go 语言的内存垃圾回收是针对堆内存的垃圾回收。

- 一个变量必须要经过声明、内存分配才能赋值，才可以在声明的时候进行初始化。指针类型在声明的时候，Go 语言并没有自动分配内存，所以不能对其进行赋值操作，这和值类型不一样。

## new

可以通过它的源代码定义分析，如下所示：

```go
// The new built-in function allocates memory. The first argument is a type,
// not a value, and the value returned is a pointer to a newly
// allocated zero value of that type.
func new(Type) \*Type
```

它的作用就是**根据传入的类型申请一块内存，然后返回指向这块内存的指针，指针指向的数据就是该类型的零值**。

比如传入的类型是 string，那么返回的就是 string 指针，这个 string 指针指向的数据就是空字符串，如下所示：

```go
sp1 = new(string)
fmt.Println(*sp1)//打印空字符串,也就是 string 的零值。
```

通过 new 函数分配内存并返回指向该内存的指针后，就可以通过该指针对这块内存进行赋值、取值等操作

## 指针变量初始化

new 函数可以申请内存并返回一个指向该内存的指针，但是这块内存中数据的值默认是该类型的零值，在一些情况下并不满足业务需求。如果得到一个 复合类型的指针，可以使用自定义的工厂函数来初始化属性，返回非零值的指针。

## make

初始化内置的数据结构: 切片、哈希表和 Channe, make(T, args) 返回的是初始化之后的 T 类型的值，这个新值并不是 T 类型的零值，也不是指针 \*T，是经过初始化之后的 T 的引用。;

make 函数是 map、 chan、slice 的工厂函数。它同时可以用于 slice、chan 和 map 这三种类型的初始化(容量、长度)。

src/runtime/map.go

```go
// makemap implements Go map creation for make(map[k]v, hint).
func makemap(t *maptype, hint int, h *hmap) *hmap{
  //省略无关代码
}
```

src/runtime/map.go

```go
// A header for a Go map.
type hmap struct {
   // Note: the format of the hmap is also encoded in cmd/compile/internal/gc/reflect.go.
   // Make sure this stays in sync with the compiler's definition.
   count     int // # live cells == size of map.  Must be first (used by len() builtin)
   flags     uint8
   B         uint8  // log_2 of # of buckets (can hold up to loadFactor * 2^B items)
   noverflow uint16 // approximate number of overflow buckets; see incrnoverflow for details
   hash0     uint32 // hash seed
   buckets    unsafe.Pointer // array of 2^B Buckets. may be nil if count==0.
   oldbuckets unsafe.Pointer // previous bucket array of half the size, non-nil only when growing
   nevacuate  uintptr        // progress counter for evacuation (buckets less than this have been evacuated)
   extra *mapextra // optional fields
}
```
