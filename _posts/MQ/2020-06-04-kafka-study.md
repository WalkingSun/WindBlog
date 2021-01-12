---
layout: blog
title: kafka运用【draft】
categories: [MQ]
description:MQ理解概念，应用场景
keywords: MQ
cnblogsClass: \[Markdown\],\[随笔分类\]服务器,\[随笔分类\]架构,\[随笔分类\]网络协议,\[发布为文章\]
oschinaClass: \[Markdown\],服务器,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

# 概念

# 消费

# 常见命令
## 创建主题(topic)
127.0.0.1创建topic,10个分区
/opt/app/kafka/bin/kafka-topics.sh --create --zookeeper 127.0.0.1:2181 --topic test-topic --replication-factor 1 --partitions 10

## 发消息
```
/opt/app/kafka/bin/kafka-console-producer.sh   --topic  test-topic   --broker-list 127.0.0.1:9092
>{"test":"qi-sgssst027_ls","clientRealIp":"127.0.0.1","clientUa":"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36"}    # 点击数据
```

## 查看topic数据量
```
/opt/app/kafka/bin/kafka-run-class.sh kafka.tools.GetOffsetShell --broker-list 127.0.0.1:9092 --topic test-topic --time -1 --offsets 1 | awk -F ":" '{sum += $3} END {print sum}'
```

## 查看group消费某个topic的滞后数量
```
/opt/app/kafka/bin/kafka-consumer-groups.sh --bootstrap-server 127.0.0.1:9092 --group test-group --describe | awk '$1 == "test-topic" {sum += $3} END {print sum}'

/opt/app/kafka/bin/kafka-run-class.sh kafka.tools.GetOffsetShell --broker-list 172.16.30.206:9092 --topic click_reader_free --time -1 --offsets 1 | awk -F ":" '{sum += $3} END {print sum}'
```
## 查看group消费某个topic的当前offset
```
/opt/app/kafka/bin/kafka-consumer-groups.sh --bootstrap-server 127.0.0.1:9092 --group test-group --describe | awk '$1 == "test_topic" {sum += $3} END {print sum}'
```
## 查看topic内容
```
/opt/app/kafka/bin/kafka-console-consumer.sh --bootstrap-server 127.0.0.1:9092 --topic test-topic --from-beginning
```
## 查看对应group的描述信息
```
/opt/app/kafka/bin/kafka-consumer-groups.sh --bootstrap-server 172.16.30.206:9092 --group test-group --describe
```

## 查看topic信息、分区数量
```
/opt/app/kafka/bin/kafka-topics.sh --zookeeper  127.0.0.1:2181 --describe --topic click-reader-free-topic 
```
## 查看所有topic列表
```
/opt/app/kafka/bin/kafka-topics.sh --zookeeper 127.0.0.1:2181 --list
```

## 查看所有group列表
```
/opt/app/kafka/bin/kafka-consumer-groups.sh --bootstrap-server 127.0.0.1:9092 --list
```

### 获取topic指定时间戳的offset

```
/opt/app/kafka/bin/kafka-run-class.sh kafka.tools.GetOffsetShell --broker-list 172.16.30.207:9092  -topic send-book-ks -time 1608526800000
```

上述的-time，为毫秒值，-time=-1表示latest，-2表示earliest

## zookeeper操作

1.删除Kafka日志文件
```
rm -rf /opt/app/kafka/logs/kafka-logs
```
2.登录Zookeeper

```
/opt/app/kafka/bin/zookeeper-shell.sh 172.16.30.207:2181
```
3.查看topic列表
```
ls /brokers/topics
```
4.删除topic
```
rmr /brokers/topics/click_reader_free
rmr /brokers/topics/cleantopic
```
5.Ctr + c退出Zookeeper
6.重置topic group的offset至最早的数据
```
/opt/app/kafka/bin/kafka-consumer-groups.sh --bootstrap-server 127.0.0.1:9092 --group test_group --topic click_reader_free_topic --reset-offsets --to-earliest --execute
```
7.查看Kafka topic数据量和group消费情况
```
/opt/app/kafka/bin/kafka-topics.sh --delete --topic test-topic --zookeeper 127.0.0.1:2181
```


