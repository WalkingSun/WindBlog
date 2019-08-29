title: 进程环境
categories: [服务器, UNIX]
description:
keywords: 进程环境, 进程
cnblogsClass: \[Markdown\],\[随笔分类\]服务器
oschinaClass: \[Markdown\],服务器,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

# 进程环境
介绍程序的开始、命令参数的接受和环境变量、程序终止的动作、进程的地址空间和内存分配等。

## main()函数
每一个完整的C程序都必须有一个main()函数，系统通过调用main()执行一个C程序。
```
int main(int argc,char *argv[]);
```

## 命令行参数
命令行参数是在启动程序执行的shell命令中给出的以空格为分隔符的字符串。当程序执行的时候调用exec()的进行将命令行参数传送给它。程序能看到命令行参数的唯一途径是main()，如果没有main(),也得不到命令行。

main()从参数argc中获取命令行参数个数，从argv中获取值。argv是一个文件字符串指针组成的数组，它的每一个元素指向命令行中参数对应的字符串。

如：
```
$a.out -f foo bar
```
mian() 中 argc为4，argv有四个元素，a.out、 -f、 foo、 bar。

## 环境变量
程序除了可通过main()的argc、argv参数获取执行环境外，还可以通过环境变量获得执行环境。
环境变量定义不经常改变的或者很多程序共享的信息。

如，环境变量PATH记录着可执行程序的查找路径，shell经常需要用来查找用户输入的命令中的执行文件。

标准环境变量：

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/TIM截图20181126105618.png)

### 环境表
记录进程的所有环境变量及其值的数据结构。

环境指针和环境表数据结构示意图：

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/TIM截图20181126110211.png)

### 访问环境
应用程序一般在需要访问整个环境或向其他程序递交环境的情况下才会使用environ,当只需要访问某个特定的环境变量时，通常使用getenv()和putenv()。

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/TIM截图20181126110459.png)

## 终止进程
进程终止有两种情况，一种是正常终止，一种是异常终止。

正常终止由main()返回，或直接调用exit()或_exit()而终止。

异常终止通过调用abort()或由于信号而终止。

### 出口状态
调用exit()和_exit()都需要传递一个整数作为出口状态。出口状态用于向父进程报告程序运行成功与否。

### 终止前的清理
程序常常会需要在正常终止之前执行一些清理动作。

### 流产程序
异常终止程序常用的方法是调用abort()函数。由于该函数会在进程的当前工作目录中生成一个内存转储文件（core），因此也称它使程序流产。

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/TIM截图20181126111516.png)

调用abort()将立即终止程序的执行。所有异常终止程序的原因都是信号造成的，实际上，abort()通过生成一个SIGABRT信号来流产程序。

## 基础的存储空间
所有计算机系统中，存储器总是一个稀有资源，不论有多大似乎总是不够的。

UNIX决不允许用户进程直接访问存储器的物理地址，进程看到都是由操作系统分配的虚拟空间地址。进程的虚地址由UNIX内核管理，每当进程申请一片存储空间时，内核负责映射虚地址到物理地址，即负责虚地址空间和实地址空间的转换。

每个进程只能看到它自己的虚地址空间，从用户的角度来看是一片连续的地址。系统提供存储保护，分配给一个进程的空间，其他进程既不能读也不能写。这种机制保证了不正确的程序不会侵犯或破坏其他进程或操作系统的存储空间。

进程开始时的虚地址空间大小有程序代码长度、静态数据空间大小以及系统保持默认栈和堆空间的大小确定。进程除了访问其静态空间和栈内的变量之外，还可以用malloc()等存储分配函数从堆中动态的申请空间。当用户需要的动态存储超过虚地址空间提供的大小时，由malloc()调用系统调用sbrk()进行扩张。

一旦物理空间用完之后，内核便开始使用所谓的“交换区”。这是一片独立的磁盘空间。内核在存储器和交换区之间移动程序数据和代码，使得每当读或写存储器时数据看起来已经在物理空间一样。

### 进程的地址空间
进程的地址空间是由系统允许程序引用或访问的所有存储单元组成。进程的地址空间及其寄存器上下文，反映了进程所运行的程序状态。当进程用exec()装入一个新程序时，内核便为这个新程序建立地址空间。

进程的地址空间由若干个不同的段组成。每一段都是一片连续存储单元，分别用于存放程序的代码、初始数据、静态变量，以及用作堆或栈的空间。由以下组成：
- 正文段
- 初始数据段
- 末初始化数据段
- 栈：用于存放函数内的局部变量、临时变量以及函数的调用环境。如函数的返回地址、函数的栈帧指针、函数入口参数等。
- 堆：用于动态申请的存储空间。

典型的进程地址空间映象：

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/TIM截图20181126135735.png)

### 动态存储分配和释放
程序除了可通过变量声明而静态获得存储空间外，也可在运行时想操作系统动态申请存储空间。

常用C函数：

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/TIM截图20181126140021.png)

### 释放分配的存储单元
应用程序可占用由malloc()分配的存储空间一直到程序结束，程序结束时会自动释放空间。但为了更有效的利用空间，常常是需要时申请，不需要时释放。

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/TIM截图20181126140351.png)

## setjmp()和longjump()函数
C程序中，不能用转移到一个标号的方法转移到其他函数中去，但是可以用setjmp()和longjmp()实现从一个函数直接跳至另一个函数，这种控制成为非局部转移。
不同于正常的函数调用与返回，这种非局部转移可以从最内层活跃函数跳至最外层活跃函数，期间可能间隔好几层函数调用，而正常的函数调用与返回遵循先进后出原则。

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/TIM截图20181126222614.png)

## 进程资源
每一个进程都回受到资源的限制，如进程能够占用的最大存储空间大小、最多能创建的子进程个数、core文件的最大大小、可用的CPU时间最大值、最多能够打开的文件个数等。进程可以查看这些限定值，也可以设置自己的当前资源小于系统资源限制的最大值。

系统规定的资源限制最大值称为硬限制，进程的当前资源限制值称为软限制。软限制超过可能会造成程序返回错误，硬限制超过将导致系统发送信号而终止程序。

所有进程一开始时均从父进程集成资源限制，对资源限制的改变影响进程本身及其子进程继承。
### 查看和设置资源限制
getrlimit()和setrlimit()分别用于查看和设置资源限制。

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/TIM截图20181126223550.png)

### 资源使用统计
对进程运行的使用情况进行详细的了解。系统提供getrusage()来报告进程实际运行了多少CPU时间，读写了多少次磁盘，出现多少次缺页，收到多少个信号等。

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/TIM截图20181126223848.png)

rusage结构：

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/TIM截图20181126223936.png)

## 用户信息
用户信息包括用户名、用户ID、用户的基本组和附加组等信息。

### 用户数据库
用户数据库保存所有用户的信息。

/etc/passwd和/etc/shadow都属于用户数据库，前者为口令数据库文件，对所有用户开放；后者为口令影子文件，只对特权用户才能访问。

口令数据库文件/etc/passwd,包含每个用户的几乎所有注册信息,如：
```
zkj:x:501:517::/home/zkj:/bin/bash
```
七个域表示信息：
- 用户名
- 口令域
- 用户ID
- 组ID
- 用户名及其他个人信息。
- 用户的初始目录
- 用户的默认shell或注册时运行的初始程序。

passwd结构描述：

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/TIM截图20181126225219.png)

### 组数据库
类似于用户数据库，包含：组文件 /etc/group 和 组口令影子文件 /etc/gshadow。

组文件由四个域组成：组名、组的口令、组ID、组成员。

如：
```
users:x:500:zkj,Hc
```

group结构成员：

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/TIM截图20181126225637.png)

## 进程的身份凭证
进程可以访问属于他自己的一切资源，如果允许，也可以访问同组或其他用户的资源。UNIX系统中，用户、组和附加组关系总是以某种方式遗传给进程和它们创建的文件。用户ID和组ID是进程最基本的身份，也是判断一个进程是否有权限进行某种操作或访问文件的依据。

为了保证系统安全，又能执行某个程序的用户有适当的权限可访问属于这个程序属主的文件或资源，UNIX系统设置了调整用户ID和调整组ID机制允许进程调整其身份。


## 调整进程的身份
进程需要调整它的用户ID或组ID的一个典型列子是login程序。

## 思考
1. 环境变量和命令行参数有何区别？使用它们的一般原则是什么？访问环境有哪几种方法？
2. 程序结束时的出口状态有何作用？如果想在程序结束时让系统自动执行某些函数，应当如何实现？
3. 进程的地址空间包含哪些区域？程序代码位于什么区域？
4. 进程的堆和栈有何不同？程序如何使用栈空间？如何使用堆空间？
5. 什么是存储泄露？如何避免它？
