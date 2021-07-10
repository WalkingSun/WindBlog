---
layout: blog
title: kafka运用
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
```shell
/opt/app/kafka/bin/kafka-console-producer.sh  --topic  test-topic   --broker-list 127.0.0.1:9092
>{"test":"qi-sgssst027_ls","clientRealIp":"127.0.0.1","clientUa":"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36"}    # 点击数据
```

## 查看topic数据量
```shell
/opt/app/kafka/bin/kafka-run-class.sh kafka.tools.GetOffsetShell --broker-list 127.0.0.1:9092 --topic test-topic --time -1 --offsets 1 | awk -F ":" '{sum += $3} END {print sum}'
```

## 查看group消费某个topic的滞后数量
```shell
/opt/app/kafka/bin/kafka-consumer-groups.sh --bootstrap-server 127.0.0.1:9092 --group test-group --describe | awk '$1 == "test-topic" {sum += $3} END {print sum}'

/opt/app/kafka/bin/kafka-run-class.sh kafka.tools.GetOffsetShell --broker-list 172.16.30.206:9092 --topic click_reader_free --time -1 --offsets 1 | awk -F ":" '{sum += $3} END {print sum}'
```
## 查看group消费某个topic的当前offset
```shell
/opt/app/kafka/bin/kafka-consumer-groups.sh --bootstrap-server 127.0.0.1:9092 --group test-group --describe | awk '$1 == "test_topic" {sum += $3} END {print sum}'
```
## 查看topic内容
```shell
/opt/app/kafka/bin/kafka-console-consumer.sh --bootstrap-server 127.0.0.1:9092 --topic test-topic --from-beginning
```
## 查看对应group的描述信息
```shell
/opt/app/kafka/bin/kafka-consumer-groups.sh --bootstrap-server 172.16.30.206:9092 --group test-group --describe
```

## 查看topic信息、分区数量
```shell
/opt/app/kafka/bin/kafka-topics.sh --zookeeper  127.0.0.1:2181 --describe --topic click-reader-free-topic 
```
## 查看所有topic列表
```shell
/opt/app/kafka/bin/kafka-topics.sh --zookeeper 127.0.0.1:2181 --list
```

## 查看所有group列表
```shell
/opt/app/kafka/bin/kafka-consumer-groups.sh --bootstrap-server 127.0.0.1:9092 --list
```

### 获取topic指定时间戳的offset

```shell
/opt/app/kafka/bin/kafka-run-class.sh kafka.tools.GetOffsetShell --broker-list 172.16.30.207:9092  -topic send-book-ks -time 1608526800000
```

上述的-time，为毫秒值，-time=-1表示latest，-2表示earliest

## zookeeper操作

1.删除Kafka日志文件
```shell
rm -rf /opt/app/kafka/logs/kafka-logs
```
2.登录Zookeeper

```shell
/opt/app/kafka/bin/zookeeper-shell.sh 172.16.30.207:2181
```
3.查看topic列表
```shell
ls /brokers/topics
```
4.删除topic
```shell
rmr /brokers/topics/click_reader_free
rmr /brokers/topics/cleantopic
```
5.Ctr + c退出Zookeeper
6.重置topic group的offset至最早的数据
```shell
/opt/app/kafka/bin/kafka-consumer-groups.sh --bootstrap-server 127.0.0.1:9092 --group test_group --topic click_reader_free_topic --reset-offsets --to-earliest --execute
```
7.查看Kafka topic数据量和group消费情况
```shell
/opt/app/kafka/bin/kafka-topics.sh --delete --topic test-topic --zookeeper 127.0.0.1:2181
```



## Docker-compose部署

部署，学习研究

```dockerfile
version: '3'

services:
  zookeeper:
    image: wurstmeister/zookeeper
    container_name: zookeeper
    restart: on-failure:5
    volumes:
      - ./data/zookeeper:/data
    ports:
      - "2181:2181"
    networks:
      - backend
  kafka:
    image: wurstmeister/kafka
    container_name: kafka
    restart: on-failure:1 # always、unless-stopped
    ports:
      - "9092:9092"
    depends_on: [ zookeeper ]
    environment: 
#    broker配置
      KAFKA_BROKER_ID: 0											  # broker标识
      KAFKA_ADVERTISED_PORT: 9092 							# 监听端口
      KAFKA_ADVERTISED_HOST_NAME: 127.0.0.1     # 修改:宿主机IP (如不需要外网访问，设置成内网IP，否则设成外网IP)
      KAFKA_ZOOKEEPER_CONNECT: zookeeper:2181       # kafka运行是基于zookeeper的；用于保存broker元数据的Zookeeper地址是通过zookeeper.connnect来指定
      KAFKA_NUM_PARTITIONS: 3												# 指定新创建的主体将包含多少个分区（阿里云分区数量按6的倍数创建）
      KAFKA_LOG_RETENTION_HOURS: 120							# 配置数据可以保留的时间
      KAFKA_LOG_RETENTION_BYTES: 1000000000				# 另一种方式通过保留的消息字节数来判断过期 同时指定字节数、保留时间，任意条件满足，消息就会删除
      KAFKA_MESSAGE_MAX_BYTES: 10000000					  # 限制单个消息的大小	
      KAFKA_REPLICA_FETCH_MAX_BYTES: 10000000
      KAFKA_GROUP_MAX_SESSION_TIMEOUT_MS: 60000
      KAFKA_DELETE_RETENTION_MS: 1000
#     KAFKA_ADVERTISED_LISTENERS: PLAINTEXT://127.0.0.1:9092 # 把kafka的地址端口注册给zookeeper，如果是远程访问要改成外网IP,类如Java程序访问出现无法连接。
      KAFKA_LISTENERS: PLAINTEXT://0.0.0.0:9092 # 配置kafka的监听端口
    volumes:
      - /var/run/docker.sock:/var/run/docker.sock
      - ./data/kafka:/kafka
#      - /etc/localtime:/etc/localtime # mac error: is not shared from OS X and is not known to Docker.
    networks:
      - backend
networks: # 容器配置可保证容器在同一网络
  backend:
```

验证kafka是否可以使用

```shell
# 进入容器
$ docker exec -it kafka bash

# 进入卡夫卡命令 目录下
$ cd /opt/kafka_2.13-2.7.0/bin/

# 运行kafka生产者发送消息
$ ./kafka-console-producer.sh --broker-list localhost:9092 --topic mmr

# 发送消息
> {"datas":[{"channel":"","sn":"IJA0101-00002245","time":"1543207156000","value":"80"}],"ver":"1.0"}
 
# 运行kafka消费者接收消息
$ ./kafka-console-consumer.sh --bootstrap-server localhost:9092 --topic mmr --from-beginning

# 查看topic信息、分区数量
./kafka-topics.sh --bootstrap-server localhost:9092 --describe  --topic mmr
# or
./kafka-topics.sh --zookeeper zookeeper:2181 --describe  --topic mmr 
```
