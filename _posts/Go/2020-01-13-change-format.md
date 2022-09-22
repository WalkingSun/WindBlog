---
layout: blog
title: Go 格式转换
categories: [Go, 知识点]
description: 熟悉
keywords: Go
cnblogsClass: \[Markdown\],\[随笔分类\]Go
oschinaClass: \[Markdown\]
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown
---

# string、int、int64、float64相互转换
```go
#string到int
int,err:=strconv.Atoi(string)

#string到int64
int64, err := strconv.ParseInt(string, 10, 64)

#int到string
string:=strconv.Itoa(int)

#int64到string
string:=strconv.FormatInt(int64,10)

#float到string
string := strconv.FormatFloat(float32,'E',-1,32)
string := strconv.FormatFloat(float64,'E',-1,64)
// 'b' (-ddddp±ddd，二进制指数)
// 'e' (-d.dddde±dd，十进制指数)
// 'E' (-d.ddddE±dd，十进制指数)
// 'f' (-ddd.dddd，没有指数)
// 'g' ('e':大指数，'f':其它情况)
// 'G' ('E':大指数，'f':其它情况)

#string到float64
float,err := strconv.ParseFloat(string,64)


# float32转float64 （精度问题解决）
s, _ := decimal.NewFromFloat32(rawScore[i]).Float64()
```

# string、[]byte转换
string转[]byte
```go
var str string = "test"

var data []byte = []byte(str)
```

[]byte转string
```go
var data [10]byte 

byte[0] = 'T'

byte[1] = 'E'

var str string = string(data[:])
```

# struct转map

## 使用json模块
直接使用json.Marshal方法来强制转化struct。
```go
func JSONMethod(content interface{}) map[string]interface{} {
    var name map[string]interface{}
    if marshalContent, err := json.Marshal(content); err != nil {
        fmt.Println(err)
    } else {
        d := json.NewDecoder(bytes.NewReader(marshalContent))
        d.UseNumber() // 设置将float64转为一个number
        if err := d.Decode(&name); err != nil {
            fmt.Println(err)
        } else {
            for k, v := range name {
                name[k] = v
            }
        }
    }
    return name
}
```

## 使用reflect
通过reflect模块来获取结构体的key值和value值，然后直接进行组装。这种方法不能识别结构体中的tag，所以无法兼容首字母小写，而其他字母存在大写的情况.
```go
func ReflectMethod(obj interface{}) map[string]interface{} {
    t := reflect.TypeOf(obj)
    v := reflect.ValueOf(obj)

    var data = make(map[string]interface{})
    for i := 0; i < t.NumField(); i++ {
        data[strings.ToLower(t.Field(i).Name)] = v.Field(i).Interface()
    }
    return data
}
```

## 使用第三方库
github.com/fatih/structs,他提供了比较丰富的函数，让我们可以像python中一样轻松的获取所有的key值（structs.Names(server)），所有的value值（structs.Values(server)），甚至直接进行类型判断（structs.IsZero(server)）等等。

更详细的信息可以查阅：[https://github.com/fatih/structs](https://github.com/fatih/structs)
```go
type Human struct {
    Name     string `json:"name"`
    Age      int    `json:"age"`
    Profile  string `structs:"profile"`
    IsGopher bool   `json:"isGopher"`
}

func main() {
    human := Human{"Detector", 18, "A tester", true}
    fmt.Println("Json method：", JSONMethod(human))
    fmt.Println("========")
    fmt.Println("Reflect method：", ReflectMethod(human))
    fmt.Println("========")
    fmt.Println("Third lb：", structs.Map(human))
}
```

从测试结果可以看到，三种方式都能完成struct转map，但是reflect方法无法识别结构体中的tag，第三方库只能使用tag structs，所以如果考虑兼容性（考虑到协同开发）和尽量使用官方库的原则，推荐使用第一种方法（json转换）




# 转换工具
json2go、yaml2go。。。
https://github.com/miaogaolin/gotl