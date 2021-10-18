# 微服务
## rpc微服务框架  
- go micro
- Go Kit
- Gizmo

https://learnku.com/go/t/36973

# go
## 包
### runtime包里面的方法
runtime调度器是非常有用的东西，关于runtime包几个方法：

Gosched：让当前线程让出cpu以让其他线程运行，它不会挂起当前线程，因此当前线程未来会继续执行

NumCPU：返回当前系统的CPU核数量

GOMAXPROCS：设置最大的可同时使用的CPU核数

Goexit：退出当前goroutine（但是defer语句会照常执行）

NumGoroutine：返回真该执行和排队的任务总数

GOOS：目标操作系统

GOROOT：返回本机的GO路径

https://www.cnblogs.com/binHome/p/11928542.html

## test
go的profile工具？


## GC
go语言的时候垃圾回收，写代码的时候如何减少小对象分配

go的gc原理了解吗？

## GMP
gmp具体的调度策略



## 框架
gin框架的路由是怎么处理的？

# MQ
## mq底层数仓

# redis
## redis过期策略和内存淘汰策略
redis的存储结构？

redis的setnx底层怎么实现的？
# MySQL
sql索引优化问题

一个update语句的执行过程

mysql索引结构

B+树和B树有什么区别

sql查询性能瓶颈处理方式

sql索引优化方式，explain字段含义

# 数据结构
实现map的方法除了哈希还有哪些？

# 网络
http和tcp有什么区别

用netstat看tcp连接的时候有关注过time_wait和close_wait吗？

fork的底层实现方式