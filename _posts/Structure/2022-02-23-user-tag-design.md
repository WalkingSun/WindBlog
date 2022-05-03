# 基于标签维度的数据分析



用户打标签应用方案

## 业务背景

市场推广业务是七猫小说比较重要的部分，广告主需要评估推广活动实际的效果，来帮助运营进一步的分析。在媒体广告后台中会展示广告计划、广告创意相对应的转化效果数据，主要包括新增、活跃、推广消耗、成本等指标，这部分数据是对应系统最细的维度——渠道，每日都会生成日报表，另外广告主可以看到更高维度的转化效果数据，会由最低的渠道维度，往上汇总生成代理商、渠道组、媒体、类型以及每日汇总维度的报表。

### 业务需求

实际投放的广告计划、广告创意会有很多设置的属性，比如年龄阶段、广告版位、出价类型等标签。随着业务的发展，需将数据做更精细的标注，调整能够评估出各个标签对应的转化效果。因此需要每天生成对应的渠道标签转化效果数据，并且能够从渠道以及标签维度实现更高维度的转化效果数据展示以及支持多维度标签聚合。

图示转化示意图

## 需求分析
需求看起来描述挺简单，但技术实现上面临诸多问题：
1. 渠道数据数据量较大（大宽表），目前日增120万，业务中经常查询一个月的数据，一个月就是3600万，目前存储MySQL中；
2. 每个渠道对应标签的数量较大，比如当前使用广告计划下的版位、出价方式属性，未来会增加定向等其他的属性标签，并且标签还可以手动设置，所以标签的数量会越来越多；
3. 渠道标签不是一成不变的，会随着推广策略的调整，发生变更添加；
4. 渠道维度往更高维度汇总数据量剧增，理论上标签的筛选是全排列，任何标签的组合查询都是有可能发生的。
   - 方案一预处理，即全排列的标签组合对应的聚合数据存储，假设每个渠道都有10个标签，标签组合存在2^n个维度,再对应日增120万，显然这将引起维度数据的爆炸，千万级的数据量会演变成亿级，甚至T级；（列举渠道组，维度爆炸图示）
   - 方案二寻找一种存储结构做到高效的实时汇总查询；

经过分析，需要确定技术方案上需要注重的点：
- 
## 方案调研

在方案设计上需要注重的点主要是数据的查询效率及存贮效率。经过团队的讨论，主要确定在三个方向上的调研设计：

1. 大宽表记录每日的渠道标签
2. 渠道数据与渠道标签关联进行查询
3. 搜索引擎查询
4. bitmap索引标签查询

方案设计，优缺点

原业务结构表，渠道表，渠道数据，介绍数据量

### 方案一 ：大宽表增加标签字段

在渠道数据表横向增加标签字段，预留50个字段存储标签，当标签数量不够，再手动添加。假设有20个标签，我们的数据是这样：

| ID   | date       | channel | group_id（渠道组） | promotion_fee（推广费） | Tag1（年龄标签） | Tag2（版位标签） | ...  | Tag10（出价类型标签） |
| ---- | ---------- | ------- | ------------------ | ----------------------- | ---------------- | ---------------- | ---- | --------------------- |
| 1    | 2022-02-20 | 渠道1   | 3008               | 1000                    | 18～20岁         | 版位1            | ...  | OCPC                  |
| 2    | 2022-02-20 | 渠道2   | 3008               | 1000                    | 18～20岁         | 版位1            | ...  | OCPC                  |
| 3    | 2022-02-20 | 渠道3   | 3008               | 2000                    | 21～24岁         | 版位2            | ...  | OCPM                  |

多个标签维度的查询看起来性能跟原表差不多，但在往上维度进行汇总，需要考虑各种标签维度进行组合查询的情况：

```mysql
SELECT SUM(推广费),date,group_id from channel_data GROUP BY group_id,(标签A,..标签N);
```

显然对于上亿数据量直接聚合查询，查询耗时，性能比较差，所以需要做维度预处理，对标签维度进行组合并事先聚合到渠道组，存储下来以便查询。标签的排列组合是2^n,10个标签就是1024，目前渠道组数据单日是5万，预处理将会5w*1024=5120万，数据膨胀又会带来新的性能和存储压力。

这个方案还存在标签字段无法动态添加，维护性可扩展性较差，字段需手动添加并且代码也需要做相应调整。

图示 渠道标签 =》 渠道数据标签



如果还是沿用关系数据库，查询结构是：

SELECT * FROM channel_data WHERE date = '2022-02-15' AND tag1='111' AND tag2='222' 



存在问题：

- 有新的标签添加

### 方案二： 标签渠道关系表（码表）

创建渠道标签码表，标签查询联合渠道数据、渠道标签进行查询。


![20220221211710](https://note.youdao.com/yws/res/55574/WEBRESOURCEf6804dd29227c8ba18d979c23f8041a9)



渠道数据标签关系表数据量？

标签查询：

```mysql
SELECT * FROM 渠道数据 a JOIN 渠道数据标签关系 b ON a.ID=b.渠道数据ID WHERE 标签 IN(A,B) 
或者
SELECT * FROM 渠道数据 WHERE id in (SELECT channel_data_id FROM 渠道数据标签关系 b 标签 IN(A,B) )
```

关系表关联查询也势必会降低点性能，往上维度汇总也是需要做维度预处理，造成维度组合爆炸，数据膨胀。

 

### 方案三：bitmap标签存储

显然关系型数据库无法解决当下的标签场景，我们需要寻找更优的存储介质、解决方案，需要注意3个点：

1. 标签可动态添加；
2. 能否实时查询，往上维度不需要预处理；
3. 解决维度数据爆炸；

如果能将大规模维度数据集处理成线性顺序结构，其存储、查询效率肯定会是质的提升。于是把方向放到了Bitmap，经过调研发现ClickHouse集成Bitmap，空间占用小，性能优越，支持高效的查询、排序及去重；clickhouse是列式存储，查询性能高效，原先使用的关系性数据库MySQL存储，可以替换做迁移。

bitmap怎么解决的？

具体技术实现上：

- 建立标签渠道数据bitmap数据

```mysql
-- 标签渠道表
CREATE TABLE promotion.h_channel_tag (
 `tag_id` Int64 COMMENT 'tag ID',
 `channel_data_id` Int64 COMMENT '渠道数据ID'
) ENGINE = ReplacingMergeTree() ORDER BY (tag_id, channel_data_id) SETTINGS index_granularity = 8192

-- 标签渠道数据bitmap表
CREATE TABLE promotion_test.h_tag_channel_bitmap (
 `tag_id` Int64 COMMENT '标签ID',
 `channel_data_ids` AggregateFunction(groupBitmap UInt64) COMMENT '渠道ID',
  date string
) ENGINE = AggregatingMergeTree() PARTITION BY tag_id ORDER BY (tag_id,date) SETTINGS index_granularity = 128
```

创建标签对应的渠道数据ID bitmap集合。Bitmap对象构建方式，一种是从聚合函数 groupBitmap 构建，另一种是从 Array 对象构建。

```mysql
-- 标签渠道数据bitmap数据生成
insert into promotion_test.h_tag_channel_bitmap select tag_id ,groupBitmapState(toUInt64(channel_data_id)) channel_ids from promotion_test.h_channel_tag group by tag_id;
```

- 标签查询渠道数据ID。支撑多个业务场景，支持与、或、异或等运算。

  ```mysql
  SELECT groupBitmapAndState(channel_ids) from promotion_test.h_tag_channel_bitmap where tag_id in(2,3,4) 
  ```

- 渠道数据标签查询，往上汇总可进行实时汇总。

  ```mysql
  -- 渠道数据标签查询 6000w 2s
  select d.* from promotion_test.h_channel_data as d where id in (
  with(
  SELECT groupBitmapAndState(channel_ids) from promotion_test.h_tag_channel_bitmap where  tag_id in(2,3,4) 
  ) as cc
  select  arrayJoin(bitmapToArray(cc)) as id 
  )  settings enable_scalar_subquery_optimization = 0 ;
  -- 参数 enable_scalar_subquery_optimization = 0 表示 with 语句的查询结果不做优化，每个节点都需要执行。
  -- 默认情况，在 ClickHouse 中 with 语句的结果作为标量进行缓存，会将查询节点的标量分发到其他服务器，当发现已经存在标量时，就不会在本地节点执行 with 语句。
  ```

  

## 调研实施

具体实施方案，优化点

## 总结

## 参考资料

https://zhuanlan.zhihu.com/p/68050217

https://www.modb.pro/db/40263



了解了需求，下面就来看下需求实现上涉及的难点、问题：








<table >
    <tr>
        <th align="center" width="150">渠道<br>channel_name</th>
        <th align="center" width="150">标签ID</br>tag_id</th>
    </tr>
    <tr>
        <td align="center">qm-001</td>
        <td align="center">1</td>
    </tr>
        <tr>
        <td align="center">qm-001</td>
        <td align="center">2</td>
    </tr>
        <tr>
        <td align="center">qm-002</td>
        <td align="center">1</td>
    </tr>
        <tr>
        <td align="center">qm-003</td>
        <td align="center">3</td>
        <tr>
        <td align="center">...</td>
        <td align="center">...</td>
    </tr>
</table>


<table >
    <tr>
        <th align="center" width="150">渠道数据ID<br>channel_data</th>
        <th align="center" width="150">标签ID</br>tag_id</th>
    </tr>
    <tr>
        <td align="center">1001</td>
        <td align="center">1</td>
    </tr>
        <tr>
        <td align="center">1001</td>
        <td align="center">2</td>
    </tr>
        <tr>
        <td align="center">1002</td>
        <td align="center">1</td>
    </tr>
        <tr>
        <td align="center">1003</td>
        <td align="center">3</td>
        <tr>
        <td align="center">...</td>
        <td align="center">...</td>
    </tr>
</table>