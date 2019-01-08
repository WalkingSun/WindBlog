---
layout: blog
title: 备战数据库三级SQL Server（&记录）
categories: [服务器]
description:
keywords: SQL Server
cnblogsClass: \[Markdown\],\[随笔分类\]服务器
oschinaClass: \[Markdown\],服务器,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---
# 理论知识

## 数据模型的分类：
最常用的数据模型是概念数据模型和结构数据模型：

   ①概念数据模型（信息模型）：面向用户的，按照用户的观点进行建模，典型代表：E-R图

   ②结构数据模型：面向计算机系统的，用于DBMS的实现，典型代表有：层次模型，网状模型、关系模型，面向  对象模型
## 数据模型的三要素：
   数据结构、数据操作、数据约束。

   数据约束规定数据及其联系的制约和依存规则。
## 网状模型：
        ①　用网络结构表示数据与数据之间的联系的模型

        ②　网状模型子节点和父节点联系不唯一，需要为联系命名

        ③　网状模型的优点是能更直观的描述世界，良好的性能，缺点是结构复杂

用网络结构表示实体类型及其实体之间联系的模型。顾名思义，一个事物和另外的几个都有联系，这样构成一张网状图。

![image](https://images2015.cnblogs.com/blog/809752/201610/809752-20161029143545843-1008074030.png)

网状模型的数据结构主要有以下两个特征:

(1)允许有一个以上的节点无双亲。

(2)至少有一个节点可以有多于一个的双亲。

## 数据库领域公认的标准结构是三级模式结构，它包括外模式、概念模式、内模式
内层：最接近实际存储体，亦即有关数据的实际存储方式。

外层：最接近用户，即有关个别用户观看数据的方式。

概念层：介于两者之间的间接层。

![image](https://gss0.baidu.com/-Po3dSag_xI4khGko9WTAnF6hhy/zhidao/wh%3D600%2C800/sign=d29fed57cb5c1038242bc6c48221bf2b/a8014c086e061d9531b4da7576f40ad163d9ca89.jpg)


外模式又称子模式或用户模式，对应于用户级。它是某个或某几个用户所看到的数据库的数据视图，是与某一应用有关的数据的逻辑表示。

概念模式又称模式或逻辑模式，对应于概念级。它是由数据库设计者综合所有用户的数据，按照统一的观点构造的全局逻辑结构，是对数据库中全部数据的逻辑结构和特征的总体描述，是所有用户的公共数据视图(全局视图)。

内模式又称存储模式，对应于物理级。它是数据库中全体数据的内部表示或底层描述，是数据库最低一级的逻辑描述，它描述了数据在存储介质上的存储方式和物理结构，对应着实际存储在外存储介质上的数据库。

要保证数据库的逻辑数据独立性，需要修改的是（模式与外模式的映射）。

==当模式改变时，数据库管理员对各个外模式／模式映像做相应改变，可保持外模式不变。应用程序是依据数据的外模式编写的，从而应用程序不必修改，保证了数据与程序的逻辑独立性。==

> 数据库三级模式引入二级映象的主要作用  提高数据和程序的独立性 SS

> 数据库系统达到了数据独立性是  采用了   三级模式结构   SS

## 候选码
若关系中的某一属性或属性组的值能唯一的标识一个元组，而其任何、子集都不能再标识，则称该属性组为（超级码）候选码。

## 主码
主码也就是主键，是惟一标识表中的每一行的字段或者多个字段的组合，它可以实现表的实体完整性

## 关系和关系运算
元组（tuple）是关系数据库中的基本概念，关系是一张表，表中的每行（即数据库中的每条记录）就是一个元组，每列就是一个属性。 在二维表里，元组也称为行。
```
若关系中的某一属性组的值能唯一地识别一个元组，则称该属性为候选码

若一个关系有多个候选码，则选定其中一个作为主码
候选码的诸属性称为主属性
不包含在任何候选码中的属性称为非码属性
若关系模式的所有属性组是这个关系模式的候选码，则称为全码
示例：学生选课表（学号，课程号，成绩）
            候选码：{学号，课程号} ，也即该关系的主码。


无限关系在数据库系统中无意义，元组个数是无限的，限定关系数据模型中的关系必须是有限集合
列是同质的： 每一列的分量是同一类型的数据，来自同一个域，
不同的列可出自同一个域
列的顺序可以任意交换
任意两个元组的候选码不能完全相同
行的次序可以任意交换
分量必须取原子值

```

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/TIM截图20181219114035.jpg)

（1）选择，是从二维表中选出符合条件的记录，它是从行的角度对关系进行的运算。
（2）投影，是从二维表中选出所需要的列，它是从列的角度对关系进行的运算。
（3）连接，是同时涉及到两个二维表的运算，它是将两个关系在给定的属性上满足给定条件的记录连接起来而得到的一个新的关系。
```
选择操作：感觉是数据库当中最简单的一种操作了，其定义如下：
σF(R)=t|t∈R∧F(t)=true
F是我们的选择条件，就是选出符合条件的元素

投影操作：
就是从R中选择出若干属性组成新的关系。
πA(R)={t[A]|t ∈R}$

连接操作：从两个关系的笛卡尔积当中选择出满足条件的元组
就是笛卡尔积的一个加强版，没什么好说的。
等值连接：即将两个集合选中的属性的值相同的元素存入我们的结果当中去。
自然连接：连接两个关系当中同名且相同类型的属性
外连接：在结果中保存悬浮元组，即保存了没有得到匹配的属性的值
左外连接：只保存了左边的联系当中没有得到匹配的属性的值
类似的，我们有右外连接的定义。
```

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/TIM截图20181219142405.jpg)

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/TIM截图20181219142611.jpg)

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/TIM截图20181219142706.jpg)
![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/TIM截图20181219142812.jpg)
![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/TIM截图20181219142835.jpg)
- 外连接
如果把舍弃的元组也保存在结果关系中，而在其他属性上填空值(Null)，这种连接就叫做外连接（OUTER JOIN）。
- 左外连接
如果只把左边关系R中要舍弃的元组保留就叫做左外连接(LEFT OUTER JOIN或LEFT JOIN)
- 右外连接
如果只把右边关系S中要舍弃的元组保留就叫做右外连接(RIGHT OUTER JOIN或RIGHT JOIN)。

## 关系演算
关系验算是用谓词来表达查询要求的方式；

按谓词变元不同 进行分类
1.元组关系演算：   以元组变量作为谓词变元的基本对象
   元组关系演算语言 ALPHA
2.域关系演算：   以域变量作为谓词变元的基本对象
  域关系演算语言 QBE

> 域关系演算公式的递归定义概述不正确的是  若f是域关系演算公式，则 ^f和f也是域关系演算公式  SS

## 元组关系演算
```
元组表达式：在元组演算中，元组关系演算表达式(简称为元组表达式)是以元组变量为单位。
     记作：{t|Φ(t)}
其中t是元组变量，Φ(t)是由原子公式和运算符组成的公式。
如果元组变量前有“全称量词”（"）或“存在量词”（$），则称其为约束变量，否则称为自由变量

元组表达式中原子公式的三种形式：
  （1）  R(t)
    R是关系名，t是关系元组变量。R(t)表示 t是关系R中的元组。
    关系可表示：{t|R(t)}
  （2） t[i]θu[j]
    其中t和u都是元组变量，θ是算术比较运算符。
    表示元组t的第i的分 量与元组u的第j个分量之间满足θ关系。
    例如：t[1]<u[2]
  （3） t[i]θa 或 aθt[i]
   其中：a是一个常量，表示元组t的第i个分量与常量a之间满足θ关系

   用元组关系演算表达式表示关系代数的五种基本运算：
   （1）并  R∪S={ t |R(t)∪S(t)}
   （2）差  R-S ={ t | R(t) ∩ ┑S(t)}
   （3）广义笛卡儿积   RⅹS= { t(n+m) |
   ($ u(n))($v(m))(R(u)∩S(v)∩t[1]=u[1]∩…∩t[n]=u[n]∩t[n+1]=v[1]∩…∩t[n+m]=v[m])}
        t(n+m)表示t有目数(n+m)，u(n)表示u的n元组，v(m)表示v的m元组。
    (4）投影   ∏i1,i2,… ik(R)={t(k) | ($u)(R(u)∩t[1]=u[i1]∩…∩t[k]=u[ik]) }
   （5）选择   σF(R) = { t |R(t)∩‘F’}    其中： F’是F的等价公式
```

## SQL语言具有两种使用方式，分别称为交互式SQL和嵌入式SQL

## 计算机系统的三类安全性 技术安全；管理安全，政策法律

## 用于实现数据库安全控制技术
1）用户标识和鉴别：

该方法由系统提供一定的方式让用户标识自己的名字或身份。每次用户要求进入系统时，由系统进行核对，通过鉴定后才能提供系统的使用权

(2)存取控制技术

通过用户权限定义和合法权检查确保只有合法权限的用户访问数据库，所有未授权的人员无法存取数据

(3)视图技术

为不同的用户定义视图，通过视图机制把要保密的数据对无权存取的用户隐藏起来，从而自动地对数据提供一定程度的安全保护。

(4)审计技术

建立审计日志，把用户对数据库的所有操作自动记录下来放入审计日志中，DBA可以利用审计跟踪的信息，重现导致数据库现有状况的一系列事件，找出非法存取数据的人，时间和内容等。

(5)数据加密

对存储和传输的数据进行加密处理，从而使得不知道解密算法的人无法获知数据的内容。

> 不是用于数据库安全控制技术的是  三级封锁协议  SS

### 自主存取控制功能
通过SQL 的GRANT语句和REVOKE语句实现

### 视图
视图的作用（小结）
1. 视图能够简化用户的操作
2. 视图使用户能以多种角度看待同一数据
3. 视图对重构数据库提供了一定程度的逻辑独立性
4. 视图能够对机密数据提供安全保护
5. 适当的利用视图可以更清晰的表达查询

### 审计
分为 用户级审计 和 系统级审计。
#### 审计操作语句
```
     AUDIT语句：设置审计功能
                    ［例13］对修改SC表结构或修改SC表数据的操作进行审计
                                                AUDIT ALTER，UPDATE
                                            ON  SC；
     NOAUDIT语句：取消审计功能
                ［例14］取消对SC表的一切审计
                                     NOAUDIT  ALTER，UPDATE
                                           ON  SC；
```

### 数据加密
加密方法：替换方法、置换方法、混合方法


## 数据完整性
数据的完整性----是指数据的正确性、有效性、相容性

> 数据的正确、有效和相容称之为数据的完整性

> 实体完整性和参照完整性属于静态关系约束

### 实体完整性
```
含义：
    规定表的每一行在表中是唯一实体
关系模型的实体完整性：
CREATE  TABLE中用PRIMARY KEY定义
     单属性构成的码有两种说明方法 ：列级约束条件、表级约束条件
     对多个属性构成的码只有一种说明方法：表级约束条件
     例：在Student表中定义Sno为主码
              Sno  CHAR(9)  PRIMARY KEY

实体完整性检查和违约处理：
      插入或对主码列进行更新操作时，RDBMS按照实体完整性规则自动进行检查。包括：
1. 检查主码值是否唯一，如果不唯一则拒绝插入或修改
2. 检查主码的各个属性是否为空，只要有一个为空就拒绝插入或修改

```

### 参照完整性
```
参照域完整性定义
在CREATE  TABLE中用FOREIGN KEY短语定义哪些列为外码
用REFERENCES短语指明这些外码参照哪些表的主码
【例】 关系SC中一个元组表示一个学生选修的某门课程的成绩，（Sno，Cno）是主码。Sno，Cno分别参照引用Student表的主码和Course表的主码，定义SC中的参照完整性：
      CREATE TABLE SC
         (Sno    CHAR(9)  NOT NULL，
          Cno     CHAR(4)  NOT NULL，
          Grade    SMALLINT，
          PRIMARY KEY (Sno， Cno)，   /*在表级定义实体完整性*/
          FOREIGN KEY (Sno) REFERENCES Student(Sno)，   /*在表级定义参照完整性*/
          FOREIGN KEY (Cno) REFERENCES Course(Cno)     /*在表级定义参照完整性*/
      );

```
> 参照完整性不正确的是  参照完整性的目的是保证某个数据表中数据的正确性。 SS

### 用户定义完整性
```
用户定义的完整性：
    就是针对某一具体应用的数据必须满足的语义要求
 CREATE TABLE时定义
列值非空（NOT NULL）
列值唯一（UNIQUE）
检查列值是否满足一个布尔表达式（CHECK）

```

## 触发器
对触发器可进行的操作 定义、激活、删除

- 触发器是一种特殊的存储过程，它在试图更改触发器所保护的数据时自动执行
- 它被定义为在对表或视图发出UPDATE、INSERT或DELETE语句时自动执行，在有数据修改时自动强制执行其业务规则
- 触发器可以扩展SQL Server约束、默认值和规则的完整性检查逻辑，但只要约束和默认值提供了全部所需的功能，就应使用约束和默认值

特点：

- 与表相关联
- 自动激活触发器
- 确保数据安全性

> 删除触发器sql命令  DROP TRIGGER    【SS】

## 数据依赖   ss
一个关系内部属性与属性之间的约束关系，定义属性值间的相互关连（主要体现于值的相等与否），是数据库模式设计的关键
- 是现实世界属性间相互联系的抽象
- 是数据内在的性质和语义的体现
- 是数据内在关系的体现

- 数据依赖是指在程序引用数据之前处理过的数据的状态
- 在编译学中，数据依赖是数据分析的一部分
- 数据依赖有三种:流依赖、反依赖和输出依赖

数据依赖类型： 函数依赖、多值依赖和连接依赖

函数依赖简单点说就是：某个属性集决定另一个属性集时，称另一属性集依赖于该属性集。
```
[例]  示例，由于模式中的某些数据依赖引起更新操作异常和数据冗余
	学生的学号（Sno）、所在系（Sdept）、	系主任姓名（Mname）、课程名（Cname）、成绩（Grade）
   关系模式 ：   Student <U、F>
   U ＝｛ Sno, Sdept, Mname, Cname, Grade ｝
       属性组U上的一组函数依赖F：
       F ＝｛ Sno → Sdept,  Sdept → Mname,  (Sno, Cname) → Grade}
      解决方法：通过分解关系模式来消除其中不合适的数据依赖
```

> 连接依赖叙述正确的是   如果只有一个表符合3NF，同时连接依赖是函数依赖，此表才符合第四范式。   SS

## 范式
### 第一范式（1NF）
如果一个关系模式R的所有属性都是不可分的基本数据项，则   R∈1NF

### 第二范式
若R∈1NF，且每一个非主属性完全函数依赖于码，则R∈2NF

### 第三范式
关系模式R<U，F> 中若不存在这样的码X、属性组Y及非主属性Z（Z  Y）, 使得X→Y，Y→Z成立， Y → X，则称R<U，F> ∈ 3NF

### BC范式（BCNF）
关系模式R<U，F>∈1NF，若X→Y且Y  X时，X必含有码，
             则R<U，F> ∈BCNF。（等价于每一个决定属性因素都包含码）
若R∈BCNF
        所有非主属性对每一个码都是完全函数依赖
        所有的主属性对每一个不包含它的码，也是完全函数依赖
        没有任何属性完全函数依赖于非码的任何一组属性
        ![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/TIM截图20181225163529.jpg)
若R∈3NF，则每一个非主属性既不部分依赖于码也不传递依赖于码

### 多值依赖
```
 设R(U)是一个属性集U上的一个关系模式， X、 Y和Z是U的子集，并且Z＝U－X－Y。关系模式R(U)中多值依赖 X→→Y成立，当且仅当对R(U)的任一关系r，给定的一对（x，z）值，有一组Y的值，这组值仅仅决定于x值而与z值无关。
［例10］关系模式WSC（W，S，C），唯一候选码（W，S，C）
     W表示仓库，S表示保管员，C表示商品
     假设每个仓库有若干个保管员，有若干种商品
     每个保管员保管所在的仓库的所有商品
     每种商品被所有保管员保管
WSC模式中存在的问题：  (1)数据冗余度大  (2)插入操作复杂  (3) 删除操作复杂(4) 修改操作复杂
```

### 第四范式（4NF）
```
定义： 关系模式R<U，F>∈1NF，如果对于R的每个非平凡多值依赖X→→Y（Y  X），X都含有码，则R∈4NF。
如果R ∈ 4NF， 则R ∈ BCNF
不允许有非平凡且非函数依赖的多值依赖
允许的非平凡多值依赖是函数依赖

```

### 连接依赖
```
    设关系模式R、Ri的属性集是Ui(1≤i≤n).
    若R每个容许的实例r均满足r=∏U1(r)∞...∞∏Un(r)，则称R满足连接依 赖，记作∞(R1,...,Rn).
    若其中某个Ui＝U，则称连接依赖是平凡连接依赖

多值依赖也是连接依赖。

```


### 第五范式（5NF）
如果关系模式R(U)上任意一个非平凡的连接依赖∞(R1,...,Rn).都由R的某个候选键所蕴含，则称关系模式R满足第五范式，记为R(U)∈5NF.

> 模式规范化的基本步骤

( ![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/TIM截图20181225164043.png)

将1NF规范为2NF，应消除非主属性对码的部分函数依赖
关系模型中的关系模式至少是1NF

关系模式中各级模式之间的关系为 3NF⊂2NF⊂1NF
( ![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/图片1.png)
 )

当关系模式R (A，B)已属于3NF时,仍存在一定的插人和删除异常

属于BCNF的关系模式:在函数依赖范畴内已消除了插人和删除的异常

关系模式R中，若其函数依赖集中所有候选关键字都是决定因素•则R最高范式 : 4NF

**3NF (消除非平凡且非函数依赖的多值依赖 )规范为4NF**

4NF 第四范式的概念叙述:
- 除对一个候选键扩展集存在属性组函数依赖外，不存在其他非平凡多值函数依赖
- 如果有且只有一个表符合BCNF，同时多值依赖为函数依赖，此表才符合第四范式
- 4NF删除了不必要的数据结构:多值依赖

5NF 第五范式叙述
- 第五范式要求能从由原始表分解和转换而得的新表中精确重建出原始表
- 利用第五范式可以确定在分解和转换过程中有没有数据丢失
- 第五范式将表分割成尽可能小的块，是为了排除在表中所有的冗余
- 如果关系模式R中的每一个连接依顿都是由R的候选键所蕴涵，则称R是第五范式
- 如果有且只有一个表符合4NF，同时其中的每个连接依赖被候选键所包含，此表才符合第五依赖
- 如果只有一个表符合BCNF，同时多值依赖为函数依赖，此表才符合第五范式

> 关系R中的属性全部都是主属性，则R的最高范式必定是  3NF   SSS

## 码
```
设K为R<U,F>中的属性或属性组合。
                若KU，则K称为R的侯选码（Candidate Key）。
          若候选码多于一个，则选定其中的一个做为主码（Primary Key）。
```


## FoxBASE、FoxPro属于最小关系系统
## 多值依赖的毛病在于 数据冗余太大
- 4NF就是限制关系模式的属性之间不允许有非平凡且非函数依赖的多值依赖
- 4NF是多值依赖范畴内最高程度的规范化
- 设关系模式R和R上的关系r， X、Y∈R且Z=R一(XY)。若r满足多值依
  赖X→→Y，则r满足多值依赖X→→Z
- **4NF是多值依赖范畴内最高程度的规范化**
## 模式分解
模式分解的等价标准
- 分解具有无损连接
- 分解要保持函数依赖
- 分解既要保持依赖，又要具有无损连接

模式的分解叙述
- 关系模式的分解不仅仅是属性集合的分解，它是对关系模式上的函数依赖集以
  及关系模式的当前值分解的具体表现
- 分解过程中，除了要求模式分解的无损连接以外，保持关系模式的一个分解是
  等价的另一个重要条件，是:关系模式的函数依赖集在分解后仍在数据库模式
  中保持不变
- 所有分解出的模式所满足的函数依赖的全体应当等价于原模式的函数依赖集

> 具有无损连接性的模式分解

定义：关系模式R<U,F>的一个分解 ρ={ R1<U1,F1>，  R2<U2,F2>， …，Rn<Un,Fn>}
   若R与R1、R2、…、Rn自然连接的结果相等，则称关系模式R的这个分解ρ具有无损连接性（Lossless join）
- 具有无损连接性的分解保证不丢失信息
- 无损连接性不一定能解决插入异常、删除异常、修改复杂、数据冗余等问题

> 如果R1∩R2是R1或R2的超码，则R上的分解(R1，R2)是无损分解。这是一个充分条件

> 设关系模式R<U，F>，其中U= {A，B，C， D，E}，F= {A→BC， C→D， BC→E， E→A}，则分解ρ= {R1(ABCE)，R2(CD)}满足具有无损连接性、保持函数依赖

> 如果F上的每一个函数依赖都在其分解后的某一个关系上成立，则这个分解是保持依赖的(这是一个充分条件) ,属于保持依赖的

> 给定关系模式R<U， F>， U= {A，B，C，D，E}，F= {B→A，D→A，A→
  E，AC→B}，则分解ρ= {R1 [ABCE]， R2 [CD]}满足 不具有无损连接性、不保持函数依赖

> 关于模式分解的说法中，不正确的是要求分解既有无损连接性，又可以保持函数依赖，可以达到5NF

>   模式分解的算法不包括无损保持法

> 模式分解的合成法内容不包括 在保证BCNF的基础上具有无损连接的分解

> 关系数据库设计中的陷阱(pitfalls)是指 信息重复和不能表示特定信息

> 数据库设计原则不包括的是索引(Index)的使用技巧和数据类型的选择

## 数据库设计
> 实体联系图中，椭圆代表 属性类型  SS

> 关系数据库中，实现实体之间的联系是通过关系与关系之间的 公共属性

> 在数据库的概念设计中，最常用的数据模型是 实体联系模型

> 从E-R模型关系向关系模型转换时，一个M:川联系转换为关系模式时，该关系模式的码是 M端实体码与N端实体码组合

> 从E-R模型关系向关系模型转换时，一个M:J联系转换为关系模式时，该关系
  模式的关键字是  M端实体关键字与N端实体关键字组合

> 在数据库设计中，用E-R图来描述信息结构但不涉及信息在计算机中的表示，它
  是数据库设计的(  概念设计  )阶段

> 将E-R模型转换成关系模型，属于数据库的 逻辑设计

> 在关系数据库设计中，设计关系模式是( 逻辑设计阶段  )的任务

> 数据库物理设计完成后，进入数据库实施阶段，下列选项中不属于实施阶段的工作是 扩充功能  SS

> 数据库物理设计阶段得到的结果是 包括存储结构和存取方法的物理结构

> 数据库的运行和维护不包含  数据库服务器硬件的升级

> 不属于查询处理的基本步骤  sorting

> RDBMS查询处理的4个阶段  查询分析、查询检查、查询优化、查询执行

> 实现查询处理算法的是 连接操作的实现、选择操作的实现

> 不属于连接操作的实现  嵌套循环方法

> 为提高效率，关系数据库系统必须进行(  定义视图  )处理

> COMPTE生成合计作为附加的汇总列出现在结果集的最后。当与BY一起使用时，COMPUTE 子句在结果集内生成控制中断和分类汇总。
        ![image](https://images2015.cnblogs.com/blog/665662/201608/665662-20160825111441944-119001201.png)
        ![image](https://images2015.cnblogs.com/blog/665662/201608/665662-20160825111959569-2075041026.png)
COMPUTE BY 子句的规则：

　　（1）不能将distinct与行统计函数一起使用

　　（2）compute ？？？ by 子句中 ？？？出的列必须出现在选择列表中

　　（3）不能在含有compute by 子句的语句中使用select into 子句，因为包括compute 子句的语句会产生不规则的行。

　　（4）如果使用了compute by子句，则必须使用order by 子句， 而且compute by子句中的列必须包含在order by 子句中，并且对列的前后顺序和起始项都要一致（即compute by子句中的列必须是order by子句中列表的全部，或者前边的连续几个）。

> 关系表达式的优化过程是 输入一个关系表达式的语法树和输出一个计算该表达式的程序

> 代数优化算法的方法不包括  对每个关系代数，都能通过语法树进行优化

> 关系代数表达式的优化规则不包括  尽量将选择和笛卡儿积运算提前，以减少元组数和关系大小

> 系统可以比用户程序的优化做得更好，其原因不包括   优化器可以从数据字典中获取许多统计信息，而用户程序也可以获得这些信息

>   查询优化的一般步骤不包括  逻辑优化:选择高阶逻辑的存取路径

> 事务  是DBMS的基本单位，它是用户定义的一组逻辑一致的程序序列。

> 若在运行过程中由于某种原因造成系统停止运行，致使事务在执行过程中以非控制方式终止，这时内存中的信息丢失，而存储在外存上的数据未受影响，这种情况称为  系统故障

> 若系统在运行过程中由于某种硬件故障，致使存储在外存上的数据部分损失或全部损失，这种情况称为 介质故障

> 介质故障的恢复需要  数据转储和日志文件

> 制作后援副本的过程称为 数据转储

> 描述错误的是 日志文件可以存在于任意文件组中

> 数据库恢复的基础是利用转储的冗余数据，这些转储的冗余数据包括 日志文件、数据库后备副本

> 事务日志的用途是 数据恢复   SS

> 数据库镜像可以用于 进行数据库恢复或并发操作

> 不属于数据库备份方式的是 手工备份和自动备份

> 数据库备份方案正确的有 分数据库结构和数据记录做两次备份

> 数据库中的封锁机制(locks)是   并发控制  的主要方法

> 解决并发操作带来的数据不一致性问题普遍采用  封锁

> 只有出现并发操作时，才有可能出现死锁

> 预防死锁通常有  一次封锁法和顺序封锁法

> 属于死锁的诊断与解除方法的是  超时法和等待图法

> 关于并发调度的可串行性说法不正确的是 以相同的顺序串行执行事务可能会产生不同的结果，但也会将数据库置于不一致状态

> 关于并发调度的可串行性概念叙述不正确的是 可串行性导致不能并发执行

> 排它锁(X锁)和共享锁(S锁)

> 对两段锁协议的不正确描述是  事务遵守两阶段锁协议不会发生死锁

> 关于封锁的粒度叙述不正确的是   行级锁比表级锁更容易引起死锁

>   客户/服务器结构与其他数据库体系结构的根本区别在于 DBMS和应用分开

> DBMS的基本功能不包括 数据的加工和优化

> 由于进程数目少，内存开销和进程通信开销小，因此，( N+1方案  )是较优的一种

> 线索与进程相比，不具有(   线索可以脱离进程存在    )特征

> 从模块结构考察， DBMS由(  查询处理器和存储管理器  )两大部分组成

> DBMS的层次结构不包括 第5层是硬件层

> 对数据存取层的含义叙述错误的是 数据存取层处理的对象不是单个元组

> RAID
- RAID是"Redundant Array of Independent Disk"的缩写，中文意思是独立冗
余磁盘阵列
- RAID是由多个磁盘驱动器组成的磁盘系统，可提供更高的性能、可靠性、存
  储容量和更低的成本
- RAID磁盘阵列支援不需停机的硬盘备援HotSpare

RAID的叙述不正确的是  RAID是数据库正常工作的必需组件

> 关于RAID的优点叙述不正确的是   RAID可以提高存储效率

> 内存参数的调整主要是指Oracle数据库的系统全局区(SGA)的调整， SGA主要(   共享池、数据缓冲区和日志缓冲区   )三部分构成

> 关于缓冲区的概念叙述不正确的是  缓冲区的作用主要是实现数据共享

> 有关缓冲区的说法中不正确的是  缓冲区的作用主要是保证数据安全性

> 构成文件的基本单位是字符，这一类文件称为 流式文件

> 文件的结构不包括 数据集

> 一个关系数据库文件中的各条记录    前后顺序可以任意颠倒，不影响数据库中的数据关系

> 文件系统的多级目录结构是 树形结构

> 关于索引技术有关概念的说法不正确的是 索引可提高安全性

> 索引技术的主要内容不包括 缓冲区调度

> 属于散列技术的处理冲突的方法是  开放定址法和拉链法 SS

> 散列表的冲突现象叙述不正确的是  冲突可以完全避免

> 关于关系性质的说法中错误的是  表中任意两行可能相同

> 关于SQL Server的数据复制功能，下列说法中不正确的是   利用数据复制功能支持SQL Server数据和SQL Server数据之间的复制

> 为了实现SQL Server 2005的数据复制，需要包括除(  复制服务器  )外的服务器角色

> SQL Server的数据复制架构通常遵循(  分发→发布→订阅  )的基本架构

> 配置SQL Server的数据复制功能可以通过SQL Server Management Studio的复制配置向导进行，下列不属于复制配置过程的是  创建订阅数据库

> 利用SQL Server 2005的配置管理器，可以实现对各种SQL Server 2005网络协议的配置，但不包括   启用或禁用HTTP

> 利用SQL Server 2005的配置管理器，可以实现对SQL Server的各种参数配置，但不包括  配置客户端IP地址  SS

> 利用SQL Server 2005的配置管理器，可以实现对SQL Server的各种参数配置，但不包括 配置SQL Server使用内存大小

> 利用SQL Server 2005的配置管理器，可以实现对SQL Server的各种参数配置，其中包括  SQL Native Client配置

> 利用SQL Server Management Studio中的活动监视器可以监视服务器上各个进程的情况。例如可以观察一个SELECT语句的进程执行的情况，但不包括下列(  语句执行后的查询结果  )的信息

> 利用SQL Server Management Studio中的活动监视器可以监视服务器上各个进程的情况。例如，可以观察一个DELETE语句的进程执行的情况，但不包括下列(  所占用的CPU时间、内存空间 )的信息。

> 利用SQL Server Management Studio中的活动监视器可以监视服务器上的除了(  按服务器分类的锁   )的信息

> SQL Server Profiler可用于捕捉SQL Server服务器中发生的事件，因而常用来监控户端发送给服务器的语句中的内容，但通常SQL Server Profiler不能用于   分析数据库服务器中数据表之间的关系

> 使用SQL Server Profiler的图形界面新建一个跟踪时，可以配置事件选择，用于指定跟踪的内容，但不包括(  想要关注哪些数据表  )  SS

> SQL Server Profiler可用于捕捉SQL Server服务器中发生的事件，在SQL Server Profiler中以图形化方式查看死锁的步骤不包括  发生死锁时，动态显示表示死锁的图形

> SQLServer Profiler可用于捕捉SQL Server服务器中发生的事件， SQL Server Profiler的事件被划分为多个事件类别，其中不包括 CPU

> SQL Server Profiler可用于捕捉SQL Server服务器中发生的事件，如要将跟踪信息保存到一个SQL Server数据表中，则需要执行除(  指定每个跟踪记录的大小  )外的步骤。

> SQL Server Profiler可用于捕捉SQL Server服务器中发生的事件，如要将跟踪信息保存到一个文件中，则在指定了文件位置和名称后，可以配置其他跟踪属性的选项，但不包括  监控的客户端最大数量

> SQL Server使用不同的锁模式锁定资源，锁的模式确定了并发事务访问资菁、的方式，其中( 更新锁 )能防止常见的死锁

> SQL Server使用不同的锁模式锁定资源，锁的模式确定了并发事务访问资源的方式，其中(  意向锁 )用于建立锁的层次结构

## 数据库恢复模型
> SQL Server 2005支持三种数据库恢复模型:简单模型、完全模型和大容量日志恢复模型，如果日志文件未被破坏，则其中( 完全模型 )的数据库恢复不会丢失数据

> SQL Server 2005支持三种数据库恢复模型:简单模型、完全模型和大容量日志恢复摸型，用(  简单模型  )能尽量减少操作所需要的存储空间，提高性能

> SQL Server 2005支持三种数据库恢复模型:简单模型、完全模型和大容量日志恢复模型，其中(  简单模型 )无法将数据库恢复到失败点状态

>  SQL Server 2005支持简单、完全、大容量日志三种数据库恢复模型，以下( 完全模型 )是数据库默认使用的恢复模型

> SQL Server 2005支持简单、完全、大容量日志二种数据库恢复模型，以下(  大容量日志恢复模型 )在恢复数据时只需记录操作的结果

## 视图
> 视图  是-个由基表导出的表，它所使用的数据不独立存储在数据库中    SS

> .在视图上不能完成的操作是 在视图上定义新的基本表

> 视图是一种常用的数据对象，它是提供(   查看和存放  )数据的另一种途径，可以简化数据库操作

> 视图是一种常用的数据对象，当使用多个数据表来建立视图时，表的连接不能使用(  外连接  )方式

> 当使用多个数据表来建立视图时，不允许在该语句中包括(  ORDER BY， COMPUTE， COMPUTE BY )等关键字

> 下列完整性中，(  实体完整性  )将每一条记录定义为表中的唯一实体，即不能重复

> 在MS SQL Server中，用来显示数据库信息的系统存储过程是  sp _ helpdb

> 在存储过程的创建中，一个存储过程最多可以有(  2048 )个参数，如果声明一个返回参数，必须使用( OUTPUT )

## 触发器
> 触发器可以创建在( 表 )中

> 触发器可引用视图或临时表，并产生两个特殊的表的是 Deleted、Inserted   SS

> 公司A使用SQL Server 2005数据库，来自贸易伙伴的客户数据每天晚上都要导人
  到客户表。要确保在导人的过程中，对于存在的客户数据进行更新、对于不存在的客户数据
  进行插入，应  创建一个INSTEAD OF触发器

> 限制输入到列的值的范围，应使用(  CHECK  )约束

> SQL的全局约束是指基于元组的检查子句和(  断言  )

> UNIQUE约束和主键约束也是(  实体完整性 )的体现

> 以下用户定义函数分类和描述错误的是  多语句表值函数可以返回一个单一的数值

> 完整性约束包括( 实体完整性 参照完整性 用户定义完整性 )

> SQL Serevr系统中的三种事务模式是  自动提交事务 显式事务 隐性事务

> 当一个表带有约束后，执行对表的各种操作时，将自动( 选择 检查 )相应的约束，只有
  符合约束条件的合法操作才能被真正执行。

> 根据数据库系统的组织结构描述，下列视图中( 概念视图 内部视图 存储视图 )不是用户或应用程序设计员的视图。   【A.	外部视图 是的】

> 根据数据库系统的组织结构，下列视图中( 外部视图 存储视图 )不是全体用户的公共视图

> 规则和check   SSS
<!-- 210+96+ -->
<!-- todo  每天三十题+模拟；上机题 18道每天2道 -->

## 上机题
https://docs.microsoft.com/zh-tw/sql/relational-databases/system-dynamic-management-views/sys-dm-exec-query-stats-transact-sql?view=sql-server-2017

参考 http://www.doc88.com/p-7045099355679.html

1.2) 以sa登录数据库，在Master数据库上执行SQL语句Select * from sysobjects；利用SQL Server Management Studio监控数据库服务器，观察当前有多少个进程，哪些登录帐户在访问数据库实例，请在“2.1.1.doc”文档内写出操作步骤，并在该文档内将下列操作界面截屏后保存：

    阅读进程信息，登录帐户信息；

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/TIM截图20190107165122.jpg)

1.3) 打开SQL Server Profiler建立跟踪对数据库活动进行监视，同时打开性能监视器利用SQL Server:SQL Statistics对象监视数据库服务器每秒的编译次数，运行3分钟后，观察重合时间段内SQL Server的活动和上述性能计数器的值，请在“2.1.1.doc”文档内写出操作步骤，并在该文档内将下列三个操作界面截屏后依次保存：

     a、在SQL Server Profiler中新建跟踪testtrace；

     b、在性能监视器中新建SQL Server: SQL Statistics计数器；

     c、在SQL Server Profiler中查看指定性能计数器的情况。



 a、
 ![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/TIM截图20190107165403.jpg)

 b、添加计数器日志，在日志中添加指定计数器（记录跟踪文件地址、性能数据地址）
  ![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/TIM截图20190107183331.jpg)
![image](https://img-blog.csdn.net/20180628110638829?watermark/2/text/aHR0cHM6Ly9ibG9nLmNzZG4ubmV0L1ZvaWRfd29ya2Vy/font/5a6L5L2T/fontsize/400/fill/I0JBQkFCMA==/dissolve/70)

c、停止跟踪，停止监视；打开跟踪文件，导入性能数据
SQL Server Profiler 文件->打开跟踪文件
SQL Server Profiler 文件->导入性能文件
![image](https://img-blog.csdn.net/20180628110854590?watermark/2/text/aHR0cHM6Ly9ibG9nLmNzZG4ubmV0L1ZvaWRfd29ya2Vy/font/5a6L5L2T/fontsize/400/fill/I0JBQkFCMA==/dissolve/70)

### sys.dm_exec_query_stats
```
sql_handle 這是指查詢所屬批次或預存程序的 Token
total_worker_time 這個計畫從編譯以來執行所耗用的 CPU 時間總量
execution_count  計畫從上次編譯以來被執行的次數
statement_start_offset	表示資料列於其批次或保存物件的文字中所描述之查詢的起始位置
statement_end_offset 表示資料列於其批次或保存物件的文字中所描述之查詢的結束位置 (由 0 開始並以位元組為單位)。 以前的版本 SQL Server 2014 (12.x)，值為-1 表示批次的結尾。
```
### sys.dm_exec_sql_text
```
傳回文字的 SQL 批次也就是識別由指定sql_handle
语法 sys.dm_exec_sql_text(sql_handle | plan_handle)

text SQL 查詢的文字。
```

```
datalength  计算长度

case
when ... then...
when ... then ...
end
```

活动监视器位置   管理-》活动监视器

1. 使用SQL语句实现DMV查询，显示当前缓存的占用了大部分 CPU 执行时间的前20个批处理或过程，按各个批处理或过程的CPU执行时间降序排列。
```sql
select top 20 sql_handle from sys.dm_exec_query_stats order by total_worker_time desc;
```

2. 使用SQL语句实现DMV查询，显示当前CPU平均占用时间最高的前12个SQL语句，以CPU平均占用时间从高到低排列。

        sys.dm_exec_query_optimizer_info   编译的所有信息

```
  select
  top 12
  	sql_handle,
  	substring(text,
  	(statement_start_offset)/2+1,
  	(case statement_end_offset
  	when -1 then datalength(text)
  	else statement_end_offset-statement_start_offset
  	end)/2+1),
  	total_worker_time/execution_count avg_time
  from sys.dm_exec_query_stats
  cross apply sys.dm_exec_sql_text(sql_handle)
  order by avg_time desc

##cross apply  交叉连接  https://blog.csdn.net/Wikey_Zhang/article/details/77480118
```

3. 使用SQL语句实现DMV查询，显示出过多编译/重新编译的所有信息，即计数器为optimizations或elapsed time的记录。

```sql
select *
from sys.dm_exec_query_optimizer_info
where
counter in ('optimizations','elapsed time')
```

4. 使用SQL语句实现DMV查询，显示10个占用了最多的 CPU 累计使用时间的查询，按累计时间降序排列。
```sql
select
top 10
	sql_handle,
	total_worker_time
from sys.dm_exec_query_stats
order by total_worker_time desc
```

5. 使用SQL语句实现DMV查询，显示当前CPU的信息、计划程序内存的信息和缓冲池的信息（每个至少列出一项以上）。
sys.dm_os_sys_info  傳回有關電腦以及有關 [SQL Server] 可用和耗用資源的其他有用資訊。
```
cpu_count	int	指定系統上的邏輯 CPU 數目。 不可為 Null。
hyperthread_ratio	int	指定單一實體處理器封裝所公開的邏輯或實體核心數目比率。 不可為 Null。
physical_memory_in_bytes	bigint 指定電腦上實體記憶體的總數。 不可為 Null。
virtual_memory_in_bytes	bigint 使用者模式之處理序可用的虛擬記憶體數量。
bpool_committed 緩衝集區中可以直接在處理虛擬位址空間中存取的 8 KB 緩衝區數目。
bpool_commit_target 代表可由 SQL Server 記憶體管理員耗用的記憶體數量 (KB)。
```
```sql
select
	cpu_count,
	hyperthread_ratio,
	physical_memory_in_bytes,
	virtual_memory_in_bytes,
	bpool_committed,
	bpool_commit_target
from sys.dm_os_sys_info
```

6. 使用SQL语句实现DMV查询，显示当前挂起的 I/O 请求信息，包括database_id, file_id,io_stall,io_pending_ms_ticks,scheduler_address。
```
 #sys.dm_io_pending_io_requests  I/O 请求信息
 scheduler_address 發出這項 I/O 要求所在的排程器。
 io_pending_ms_ticks  单个I/O在挂起队列中等待的总时间

 #dm_io_virtual_file_stats   I/O 統計資料
database_id  資料庫的識別碼。
file_id  檔案識別碼
io_stall 使用者等候檔案完成 I/O 的總時間 (以毫秒為單位)
```
```sql
select
	database_id,
	file_id,
	io_stall,
	io_pending_ms_ticks,
	scheduler_address
from sys.dm_io_pending_io_requests t1,
sys.dm_io_virtual_file_stats(null,null) t2
where t1.io_handle=t2.file_handle

```

### 添加维护计划
7.  1) 利用SQL Server Management Studio的维护计划功能，设置系统每天1：00自动执行增量备份数据库Model到文件夹C:\BACKUP，请在“2.2.1.doc”文档内写出操作步骤，并在该文档内将下列两个操作界面截屏后依次保存：

       a、设置备份数据库任务的界面；

       b、维护计划设置完成的界面。

a. 备份类型选差异（增量备份）
![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/aaa.png)
![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/bbb.png)

b.
![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/ccc.png)
![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/ddd.png)

2) 利用SQL Server Agent功能，创建作业job1，设置每天1:00自动完成以下步骤：先删除备份文件C:\BACKUP\Model1.bak，然后对数据库Master进行全备份，并将备份文件保存为C:\BACKUP\Model1.bak，请在“2.2.1.doc”文档内写出操作步骤，并在该文档内将下列三个操作界面截屏后依次保存：

   a、设置删除备份文件的界面；

   b、设置对数据库Model进行全备份的界面；

    c、设置作业计划属性的界面。
a、
![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/ggg.png)
b、
![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/hhh.png)
c、
![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/jjj.png)

#### 注意
- 删除备份文件
```
#类型选操作系统
del C:\BACKUP\Model1.bak
```

- 备份数据库到文件地址
```
#选择T-SQL
backup database model to disk='C:\BACKUP\Model1.bak'
```

### 存贮过程、函数
8. 素材内容:

   已建数据库“DEMO_3_3_1”，数据库中建有表“Employee”，表结构如下：

<table class="MsoNormalTable" border="1" cellspacing="0" cellpadding="0" style="border-collapse: collapse; border: medium none" id="table1">
		<tbody><tr style="height: 3.5pt">
			<td width="99" rowspan="7" style="width: 74.0pt; height: 3.5pt; border: 1.0pt solid black; padding-left: 2.85pt; padding-right: 2.85pt; padding-top: 0cm; padding-bottom: 0cm">
			<p class="MsoNormal" style="text-indent: 0cm; line-height: normal">
			<span lang="EN-US" style="font-size: 10.5pt; font-family: 宋体">
			Employee </span></p></td>
			<td width="151" valign="top" style="width: 113.1pt; height: 3.5pt; border-left: medium none; border-right: 1.0pt solid black; border-top: 1.0pt solid black; border-bottom: 1.0pt solid black; padding-left: 2.85pt; padding-right: 2.85pt; padding-top: 0cm; padding-bottom: 0cm">
			<p class="MsoNormal" style="text-indent: 21.0pt; line-height: normal; layout-grid-mode: char">
			<span lang="EN-US" style="font-size: 10.5pt; font-family: 宋体">ID</span></p></td>
			<td width="104" valign="top" style="width: 78.0pt; height: 3.5pt; border-left: medium none; border-right: 1.0pt solid black; border-top: 1.0pt solid black; border-bottom: 1.0pt solid black; padding-left: 2.85pt; padding-right: 2.85pt; padding-top: 0cm; padding-bottom: 0cm">
			<p class="MsoNormal" style="text-indent: 3.25pt; line-height: normal; layout-grid-mode: char">
			<span style="font-size: 10.5pt; font-family: 宋体">雇员号</span></p></td>
			<td width="118" valign="top" style="width: 88.3pt; height: 3.5pt; border-left: medium none; border-right: 1.0pt solid black; border-top: 1.0pt solid black; border-bottom: 1.0pt solid black; padding-left: 2.85pt; padding-right: 2.85pt; padding-top: 0cm; padding-bottom: 0cm">
			<p class="MsoNormal" align="center" style="text-align: center; text-indent: 0cm; line-height: normal; layout-grid-mode: char">
			<span lang="EN-US" style="font-size: 10.5pt; font-family: 宋体">Int</span></p></td>
			<td width="118" valign="top" style="width: 88.4pt; height: 3.5pt; border-left: medium none; border-right: 1.0pt solid black; border-top: 1.0pt solid black; border-bottom: 1.0pt solid black; padding-left: 2.85pt; padding-right: 2.85pt; padding-top: 0cm; padding-bottom: 0cm">
			<p class="MsoNormal" style="text-indent: 21.0pt; line-height: normal; layout-grid-mode: char">
			<span lang="EN-US" style="font-size: 10.5pt; font-family: 宋体">NOT
			NULL</span></p></td>
		</tr>
		<tr>
			<td width="151" valign="top" style="width: 113.1pt; border-left: medium none; border-right: 1.0pt solid black; border-top: medium none; border-bottom: 1.0pt solid black; padding-left: 2.85pt; padding-right: 2.85pt; padding-top: 0cm; padding-bottom: 0cm">
			<p class="MsoNormal" style="text-indent: 21.0pt; line-height: normal; layout-grid-mode: char">
			<span lang="EN-US" style="font-size: 10.5pt; font-family: 宋体">NAME</span></p></td>
			<td width="104" valign="top" style="width: 78.0pt; border-left: medium none; border-right: 1.0pt solid black; border-top: medium none; border-bottom: 1.0pt solid black; padding-left: 2.85pt; padding-right: 2.85pt; padding-top: 0cm; padding-bottom: 0cm">
			<p class="MsoNormal" style="text-indent: 3.25pt; line-height: normal; layout-grid-mode: char">
			<span style="font-size: 10.5pt; font-family: 宋体">姓名</span></p></td>
			<td width="118" valign="top" style="width: 88.3pt; border-left: medium none; border-right: 1.0pt solid black; border-top: medium none; border-bottom: 1.0pt solid black; padding-left: 2.85pt; padding-right: 2.85pt; padding-top: 0cm; padding-bottom: 0cm">
			<p class="MsoNormal" align="center" style="text-align: center; text-indent: 0cm; line-height: normal; layout-grid-mode: char">
			<span lang="EN-US" style="font-size: 10.5pt; font-family: 宋体">
			VARCHAR(25)</span></p></td>
			<td width="118" valign="top" style="width: 88.4pt; border-left: medium none; border-right: 1.0pt solid black; border-top: medium none; border-bottom: 1.0pt solid black; padding-left: 2.85pt; padding-right: 2.85pt; padding-top: 0cm; padding-bottom: 0cm">
			<p class="MsoNormal" style="text-indent: 21.0pt; line-height: normal; layout-grid-mode: char">
			<span lang="EN-US" style="font-size: 10.5pt; font-family: 宋体">NOT
			NULL</span></p></td>
		</tr>
		<tr>
			<td width="151" valign="top" style="width: 113.1pt; border-left: medium none; border-right: 1.0pt solid black; border-top: medium none; border-bottom: 1.0pt solid black; padding-left: 2.85pt; padding-right: 2.85pt; padding-top: 0cm; padding-bottom: 0cm">
			<p class="MsoNormal" style="text-indent: 21.0pt; line-height: normal; layout-grid-mode: char">
			<span lang="EN-US" style="font-size: 10.5pt; font-family: 宋体">
			HIREDATE</span></p></td>
			<td width="104" valign="top" style="width: 78.0pt; border-left: medium none; border-right: 1.0pt solid black; border-top: medium none; border-bottom: 1.0pt solid black; padding-left: 2.85pt; padding-right: 2.85pt; padding-top: 0cm; padding-bottom: 0cm">
			<p class="MsoNormal" style="text-indent: 3.25pt; line-height: normal; layout-grid-mode: char">
			<span style="font-size: 10.5pt; font-family: 宋体">工作日期</span></p></td>
			<td width="118" valign="top" style="width: 88.3pt; border-left: medium none; border-right: 1.0pt solid black; border-top: medium none; border-bottom: 1.0pt solid black; padding-left: 2.85pt; padding-right: 2.85pt; padding-top: 0cm; padding-bottom: 0cm">
			<p class="MsoNormal" align="center" style="text-align: center; text-indent: 0cm; line-height: normal; layout-grid-mode: char">
			<span lang="EN-US" style="font-size: 10.5pt; font-family: 宋体">
			datetime</span></p></td>
			<td width="118" valign="top" style="width: 88.4pt; border-left: medium none; border-right: 1.0pt solid black; border-top: medium none; border-bottom: 1.0pt solid black; padding-left: 2.85pt; padding-right: 2.85pt; padding-top: 0cm; padding-bottom: 0cm">
			<p class="MsoNormal" style="text-indent: 21.0pt; line-height: normal; layout-grid-mode: char">
			<span lang="EN-US" style="font-size: 10.5pt; font-family: 宋体">NOT
			NULL</span></p></td>
		</tr>
		<tr>
			<td width="151" valign="top" style="width: 113.1pt; border-left: medium none; border-right: 1.0pt solid black; border-top: medium none; border-bottom: 1.0pt solid black; padding-left: 2.85pt; padding-right: 2.85pt; padding-top: 0cm; padding-bottom: 0cm">
			<p class="MsoNormal" style="text-indent: 21.0pt; line-height: normal; layout-grid-mode: char">
			<span lang="EN-US" style="font-size: 10.5pt; font-family: 宋体">JOB</span></p></td>
			<td width="104" valign="top" style="width: 78.0pt; border-left: medium none; border-right: 1.0pt solid black; border-top: medium none; border-bottom: 1.0pt solid black; padding-left: 2.85pt; padding-right: 2.85pt; padding-top: 0cm; padding-bottom: 0cm">
			<p class="MsoNormal" style="text-indent: 3.25pt; line-height: normal; layout-grid-mode: char">
			<span style="font-size: 10.5pt; font-family: 宋体">岗位</span></p></td>
			<td width="118" valign="top" style="width: 88.3pt; border-left: medium none; border-right: 1.0pt solid black; border-top: medium none; border-bottom: 1.0pt solid black; padding-left: 2.85pt; padding-right: 2.85pt; padding-top: 0cm; padding-bottom: 0cm">
			<p class="MsoNormal" align="center" style="text-align: center; text-indent: 0cm; line-height: normal; layout-grid-mode: char">
			<span lang="EN-US" style="font-size: 10.5pt; font-family: 宋体">
			VARCHAR(10)</span></p></td>
			<td width="118" valign="top" style="width: 88.4pt; border-left: medium none; border-right: 1.0pt solid black; border-top: medium none; border-bottom: 1.0pt solid black; padding-left: 2.85pt; padding-right: 2.85pt; padding-top: 0cm; padding-bottom: 0cm">
			<p class="MsoNormal" style="text-indent: 21.0pt; line-height: normal; layout-grid-mode: char">
			<span lang="EN-US" style="font-size: 10.5pt; font-family: 宋体">NOT
			NULL</span></p></td>
		</tr>
		<tr>
			<td width="151" valign="top" style="width: 113.1pt; border-left: medium none; border-right: 1.0pt solid black; border-top: medium none; border-bottom: 1.0pt solid black; padding-left: 2.85pt; padding-right: 2.85pt; padding-top: 0cm; padding-bottom: 0cm">
			<p class="MsoNormal" style="text-indent: 21.0pt; line-height: normal; layout-grid-mode: char">
			<span lang="EN-US" style="font-size: 10.5pt; font-family: 宋体">SAL</span></p></td>
			<td width="104" valign="top" style="width: 78.0pt; border-left: medium none; border-right: 1.0pt solid black; border-top: medium none; border-bottom: 1.0pt solid black; padding-left: 2.85pt; padding-right: 2.85pt; padding-top: 0cm; padding-bottom: 0cm">
			<p class="MsoNormal" style="text-indent: 3.25pt; line-height: normal; layout-grid-mode: char">
			<span style="font-size: 10.5pt; font-family: 宋体">工资</span></p></td>
			<td width="118" valign="top" style="width: 88.3pt; border-left: medium none; border-right: 1.0pt solid black; border-top: medium none; border-bottom: 1.0pt solid black; padding-left: 2.85pt; padding-right: 2.85pt; padding-top: 0cm; padding-bottom: 0cm">
			<p class="MsoNormal" align="center" style="text-align: center; text-indent: 0cm; line-height: normal; layout-grid-mode: char">
			<span lang="EN-US" style="font-size: 10.5pt; font-family: 宋体">
			Numeric(8,2)</span></p></td>
			<td width="118" valign="top" style="width: 88.4pt; border-left: medium none; border-right: 1.0pt solid black; border-top: medium none; border-bottom: 1.0pt solid black; padding-left: 2.85pt; padding-right: 2.85pt; padding-top: 0cm; padding-bottom: 0cm">
			<p class="MsoNormal" style="text-indent: 21.0pt; line-height: normal; layout-grid-mode: char">
			<span lang="EN-US" style="font-size: 10.5pt; font-family: 宋体">&nbsp;</span></p></td>
		</tr>
		<tr>
			<td width="151" valign="top" style="width: 113.1pt; border-left: medium none; border-right: 1.0pt solid black; border-top: medium none; border-bottom: 1.0pt solid black; padding-left: 2.85pt; padding-right: 2.85pt; padding-top: 0cm; padding-bottom: 0cm">
			<p class="MsoNormal" style="text-indent: 21.0pt; line-height: normal; layout-grid-mode: char">
			<span lang="EN-US" style="font-size: 10.5pt; font-family: 宋体">MGR</span></p></td>
			<td width="104" valign="top" style="width: 78.0pt; border-left: medium none; border-right: 1.0pt solid black; border-top: medium none; border-bottom: 1.0pt solid black; padding-left: 2.85pt; padding-right: 2.85pt; padding-top: 0cm; padding-bottom: 0cm">
			<p class="MsoNormal" style="text-indent: 3.25pt; line-height: normal; layout-grid-mode: char">
			<span style="font-size: 10.5pt; font-family: 宋体">管理者编号</span></p></td>
			<td width="118" valign="top" style="width: 88.3pt; border-left: medium none; border-right: 1.0pt solid black; border-top: medium none; border-bottom: 1.0pt solid black; padding-left: 2.85pt; padding-right: 2.85pt; padding-top: 0cm; padding-bottom: 0cm">
			<p class="MsoNormal" align="center" style="text-align: center; text-indent: 0cm; line-height: normal; layout-grid-mode: char">
			<span lang="EN-US" style="font-size: 10.5pt; font-family: 宋体">Int</span></p></td>
			<td width="118" valign="top" style="width: 88.4pt; border-left: medium none; border-right: 1.0pt solid black; border-top: medium none; border-bottom: 1.0pt solid black; padding-left: 2.85pt; padding-right: 2.85pt; padding-top: 0cm; padding-bottom: 0cm">
			<p class="MsoNormal" style="text-indent: 21.0pt; line-height: normal; layout-grid-mode: char">
			<span lang="EN-US" style="font-size: 10.5pt; font-family: 宋体">&nbsp;</span></p></td>
		</tr>
		<tr>
			<td width="151" valign="top" style="width: 113.1pt; border-left: medium none; border-right: 1.0pt solid black; border-top: medium none; border-bottom: 1.0pt solid black; padding-left: 2.85pt; padding-right: 2.85pt; padding-top: 0cm; padding-bottom: 0cm">
			<p class="MsoNormal" style="text-indent: 21.0pt; line-height: normal; layout-grid-mode: char">
			<span lang="EN-US" style="font-size: 10.5pt; font-family: 宋体">DEPTNO</span></p></td>
			<td width="104" valign="top" style="width: 78.0pt; border-left: medium none; border-right: 1.0pt solid black; border-top: medium none; border-bottom: 1.0pt solid black; padding-left: 2.85pt; padding-right: 2.85pt; padding-top: 0cm; padding-bottom: 0cm">
			<p class="MsoNormal" style="text-indent: 3.25pt; line-height: normal; layout-grid-mode: char">
			<span style="font-size: 10.5pt; font-family: 宋体">部门号</span></p></td>
			<td width="118" valign="top" style="width: 88.3pt; border-left: medium none; border-right: 1.0pt solid black; border-top: medium none; border-bottom: 1.0pt solid black; padding-left: 2.85pt; padding-right: 2.85pt; padding-top: 0cm; padding-bottom: 0cm">
			<p class="MsoNormal" align="center" style="text-align: center; text-indent: 0cm; line-height: normal; layout-grid-mode: char">
			<span lang="EN-US" style="font-size: 10.5pt; font-family: 宋体">Int</span></p></td>
			<td width="118" valign="top" style="width: 88.4pt; border-left: medium none; border-right: 1.0pt solid black; border-top: medium none; border-bottom: 1.0pt solid black; padding-left: 2.85pt; padding-right: 2.85pt; padding-top: 0cm; padding-bottom: 0cm">
			<p class="MsoNormal" style="text-indent: 21.0pt; line-height: normal; layout-grid-mode: char">
			<span lang="EN-US" style="font-size: 10.5pt; font-family: 宋体">&nbsp;</span></p></td>
		</tr>
	</tbody></table>



   具体要求：

   1、完成以下所有操作，并将对应的SQL脚本依次保存至“3.1.1.doc”文件。

   针对表Employee，完成以下操作内容：

   （1）建立存储过程add_emp，输入雇员号、姓名、岗位、工作日期、工资、管理者编号、部门号，为Employee表插入数据。
```sql
create proc add_emp
@ID int,
@NAME varchar(25),
@HAREDATE datetime,
@JOB varchar(10),
@SAL numeric(8,2),
@MGR int,
@DEPTNO int
as
begin
	insert into dbo.Employee values(@ID,@NAME,@HAREDATE,@JOB,@SAL,@MGR,@DEPTNO)
	print 'success'
end

##插入数据
exec add_emp 12, '张三', '2018-01-23','DBA', '2','1','1'
```
   （2）建立函数valid_id，根据输入的雇员号，检查雇员是否存在。如果雇员存在，则返回1；否则返回0。
```
create function valid_id( @id int)
returns bit
as
begin
declare @count int
declare @isExit int

select @count=count(ID) from dbo.employee where ID=@id
if @count >= 1
	set @isExit=1
else
	set @isExit=0
return @isExit
end
```
   （3）建立函数get_sal，根据输入的雇员号返回雇员名和工资。调用函数valid_id确定雇员是否存在，不存在则显示消息“该雇员不存在”。
```sql
create function get_sal( @id int )
returns @tmptable table (name varchar(25), sal numeric(8,2), msg varchar(32))
begin
declare @count int

if dbo.valid_id(@id)=1
    insert into @tmptable select NAME,SAL,'该雇员存在' from dbo.employee where ID=@id
else
    insert into @tmptable values('',0.0,'该雇员不存在')
return
end

##表值函数调用
select * from dbo.get_sal(0)
```

   （4）建立函数get_table,根据输入的部门号返回所有员工信息

   ```sql
   create function get_table(@dep int)
     returns table

     return select * from dbo.employee where DEPTNO=@dep

     ##查询
     select * from dbo.get_table(1)
   ```

   （5）编写存储过程disp_emp，根据输入的部门号，采用游标方式按下列格式输出所有该部门的雇员名、岗位和工资。
        雇员名         岗位           工资

   ————————————————————————

   —————————————————————（此处为数据）
 ```sql
 create proc disp_emp
   @dep int
   as
   begin
   declare @name varchar(25)
   declare @job varchar(10)
   declare @sal numeric(8,2)
   declare youbiao cursor for select NAME,JOB,SAL from dbo.employee where DEPTNO=@DEP
   open youbiao
   fetch next from youbiao into @name,@job,@sal

   print '雇员名   岗位   工资   '
   print '-----------------------'

  while @@fetch_status=0
  begin
  print @name+'   '+@job+'   '+cast(@sal as varchar)+'   '
  fetch next from youbiao into @name,@job,@sal
  end
  close youbiao
  deallocate youbiao  #释放游标
   end
```

> 游标

```
#声明一个动态游标
declare youbiao cursor for select NAME,JOB,SAL from dbo.employee where DEPTNO=@DEP

#打开游标
open youbiao

#提取数据  next表示当前位置下一个 first表示第一个
fetch next from youbiao into @name,@job,@sal

#获取游标指针状态 0代表结束
@@fetch_status

#关闭游标
close youbiao
```

> 强制转换 (转换为varchar)

```sql
cast( @sal as varchar )
```

