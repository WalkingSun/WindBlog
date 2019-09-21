---
layout: blog
title: 数据库基础知识【draft】
categories: [cate1, cate2]
description: 数据库基础知识
keywords: mysql
cnblogsClass: \[Markdown\],\[随笔分类\]数据库
oschinaClass: \[Markdown\],PHP,数据库,服务器,工作日志,日常记录,转贴的文章
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---
# 基础知识
记录下基础（平常容易忽视）的知识，细节考虑。

## 数据类型及占用字节数
```mysql
#数字型所占用的字节数如下，根据字节数即可算出表示的范围了

TINYINT                                    1 字节 
SMALLINT                                 2 个字节 
MEDIUMINT                              3 个字节 
INT                                           4 个字节 
INTEGER                                   4 个字节 
BIGINT                                      8 个字节 
FLOAT(X)                                  4 如果 X < = 24 或 8 如果 25 < = X < = 53 
FLOAT                                       4 个字节 
DOUBLE                                    8 个字节 
DOUBLE PRECISION                  8 个字节 
REAL                                         8 个字节 
DECIMAL(M,D)                          M字节(D+2 , 如果M < D)   # M:数值的总位数。 　D:小数点后面能保留几位
NUMERIC(M,D)                          M字节(D+2 , 如果M < D)
日期和时间类型
列类型                                     需要的存储量 
DATE                                        3 个字节 
DATETIME                                 8 个字节 
TIMESTAMP                               4 个字节 
TIME                                         3 个字节 
YEAR                                         1 字节
字符串类型
列类型                                                需要的存储量 
CHAR(M)                                        M字节，1 <= M <= 255 
VARCHAR(M)                                 L+1 字节, 在此L <= M和1 <= M <= 255 
TINYBLOB, TINYTEXT                     L+1 字节, 在此L< 2 ^ 8 
BLOB, TEXT                                   L+2 字节, 在此L< 2 ^ 16 
MEDIUMBLOB, MEDIUMTEXT         L+3 字节, 在此L< 2 ^ 24 
LONGBLOB, LONGTEXT                 L+4 字节, 在此L< 2 ^ 32 
ENUM('value1','value2',...)                1 或 2 个字节, 取决于枚举值的数目(最大值65535） 
SET('value1','value2',...)                    1，2，3，4或8个字节, 取决于集合成员的数量(最多64个成员）
```

1 bytes = 8 bit ,一个字节最多可以代表的数据长度是2的8次方

> INT[(M)] [UNSIGNED] [ZEROFILL]   M默认为11,代表长度

普通大小的整数。带符号的范围是-2147483648到2147483647。无符号的范围是0到4294967295( 2^(4*8) )。

使用int(3)的时候如果你输入的是10，会默认给你存储位010,也就是说这个3代表的是默认的一个长度，当你不足3位时，会帮你不全，当你超过3位时，就没有任何的影响。

> char(30)与varchar(30)

char类型是使用固定长度空间进行存储，范围0-255。比如CHAR(30)能放30个字符，存放abcd时，尾部会以空格补齐，实际占用空间 30 * 3bytes (utf8)。检索它的时候尾部空格会被去除。

varchar类型保存可变长度字符串，范围0-65535（但受到单行最大64kb的限制）。比如用 varchar(30) 去存放abcd，实际使用5个字节，因为还需要使用额外1个字节来**标识字串长度**（0-255使用1个字节，超过255需要2个字节）。

```html
<table summary="Illustration of the difference between CHAR and VARCHAR storage requirements by showing the required storage for various string values in CHAR(4) and VARCHAR(4) columns.">
<colgroup><col width="15%"><col width="15%"><col width="20%"><col width="15%"><col width="20%"></colgroup>
    <thead>
          <tr>
            <th scope="col"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">值</font></font></th>
            <th scope="col"><code class="literal">CHAR(4)</code></th>
            <th scope="col"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">需要存储</font></font></th>
            <th scope="col"><code class="literal">VARCHAR(4)</code></th>
            <th scope="col"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">需要存储</font></font></th>
          </tr>
    </thead>
    <tbody>
          <tr>
            <td scope="row"><code class="literal">''</code></td>
            <td><code class="literal">'&nbsp;&nbsp;&nbsp;&nbsp;'</code></td>
            <td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">4字节</font></font></td>
            <td><code class="literal">''</code></td>
            <td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">1个字节</font></font></td>
          </tr><tr>
            <td scope="row"><code class="literal">'ab'</code></td>
            <td><code class="literal">'ab&nbsp;&nbsp;'</code></td>
            <td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">4字节</font></font></td>
            <td><code class="literal">'ab'</code></td>
            <td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">3个字节</font></font></td>
          </tr><tr>
            <td scope="row"><code class="literal">'abcd'</code></td>
            <td><code class="literal">'abcd'</code></td>
            <td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">4字节</font></font></td>
            <td><code class="literal">'abcd'</code></td>
            <td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">5个字节</font></font></td>
          </tr><tr>
            <td scope="row"><code class="literal">'abcdefgh'</code></td>
            <td><code class="literal">'abcd'</code></td>
            <td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">4字节</font></font></td>
            <td><code class="literal">'abcd'</code></td>
            <td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">5个字节</font></font></td>
          </tr>
    </tbody>
</table>
```

### float、double、decimal
区别一：

FLOAT显示后面的小数点位大概在40多位，

DOUBLE能显示的就是300多位了，不是一个层次上的，

DECIMAL这个小数点后面能显示的位数跟DOUBLE差不多，

区别二：

FLOAT和DOUBLE在不指定精度时，也就是不用(M,D)，默认会按照实际的精度，也就是你写多少就是多少，而DECIMAL如不指定精度默认为(10,0)，也就是如果不指定精度，插入数值56.89，在数据库中存储的就是57。所以一般使用DECIMAL时就会指定精度，而使用FLOAT和DOUBLE就不用。

区别三:

浮点数相对与定点数(DECIMAL)的优点就是在长度一定的情况下，浮点数能够表示更大的数据范围，但是缺点是会引起精度问题。


## 存储引擎

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/mysql_yinqing.png)

MyISAM 和 InnoDB 区别：

- InnoDB 支持事务（保证数据的完整性）、外健（保证数据一致性的策略）和行锁。
- InnoDB是聚集索引，数据文件是和索引绑在一起的，必须要有主键，通过主键索引效率很高。但是辅助索引需要两次查询，先查询到主键，然后再通过主键查询到数据。因此，主键不应该过大，因为主键太大，其他索引也都会很大。
而MyISAM是非聚集索引，数据文件是分离的，索引保存的是数据文件的指针。主键索引和辅助索引是独立的；
- MyISAM存储空间大得多。MyISAM的索引和数据是分开的，并且索引是有压缩的，内存使用率就对应提高了不少。能加载更多索引，而Innodb是索引和数据是紧密捆绑的，没有使用压缩从而会造成Innodb比MyISAM体积庞大不小
- InnoDB不保存表的具体行数，执行select count(*) from table时需要全表扫描。而MyISAM用一个变量保存了整个表的行数，执行上述语句时只需要读出该变量即可，速度很快；
- Innodb不支持全文索引，而MyISAM支持全文索引，查询效率上MyISAM要高；


