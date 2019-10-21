---
layout: blog
title: docker容器管理
categories: [docker, composer]
description: docker实际运用中的记录
keywords: docker, composer
cnblogsClass: \[Markdown\],\[随笔分类\]服务器,\[随笔分类\]容器
oschinaClass: \[Markdown\],服务器,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

<!--
![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/b.png)
-->

# 查询容器信息
## docker inspcet
查询信息，包括运行情况、存贮位置、配置参数、网络设置等。

- 查询容器的运行状态
```
docker inspect -f {{.State.Status}} 【容器】
```

- 查询容器的IP
```
docker inspect  -f {{.NetworkSettings.IPAddress}} 【容器】
```

## 查询容器日志信息
docker logs 【容器】

-f 实时打印最新的日志

## docker stats 实时查看容器所占的系统资源
如CPU使用率、内存、网络、磁盘开销

# 容器内部命令
原生方式登入docker exec
```
docker exec + 容器名 +容器内执行的命令
```
比如查询容器php的所有进程：
```
docker exec php7-dev ps -ef
```

容器内连续执行多条命令，可以加上 “-it”参数，相当于以root身份登入容器内，可连续执行命令，执行exit退出。
```
docker exec -it php7-dev /bin/bash
```

# 多容器管理
多个容器有数据交互，依赖，启动方式就必须有先后，如：
```
# db容器优先于WordPress启动
docker start db docker start WordPress
```

## docker composer
容器编排工具，允许用户在一个模版（YAML格式）中定义一组相关联的应用容器，这组容器会根据配置模版中的“--link”等参数，对启动的**优先级自动排序**，简单执行一条“docker-composer up”,就可以把同一服务中的多个容器依次创建和启动。

安装方式,参考[官方](https://docs.docker.com/compose/install/)
```
sudo curl -L "https://github.com/docker/compose/releases/download/1.23.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose

#查看compose版本
docker-compose --version
#docker-compose version 1.23.1, build b02f1306
```

例如启动wordpress项目,创建wordpress文件夹，文件夹内创建docker-composer.yml文件，内容：
```
wordpress:
    image: wordpress
    links:
        - db:mysql
    ports:
        - 8080:80
db:
    image: mariadb
    environment:
        MYSQL_ROOT_PASSWORD: example
```
选项 links、ports、environment、volumes分别对应 docker run中的"--links"(容器互联)、"-p"（端口映射）、“-e”（环境变量设置）、“-v”（映射目录）。
restart: always  一直在线

> docker-compose up 创建和启用服务   加-d后台运行

> docker-compose start 启动

> docker-compose stop 停止

> docker-compose ps 查看运行情况

### 其他选项
- container_name  
指定容器名
```
   image: php:7.0-fpm
   container_name:  php7-dev
```
- environment
加入环境变量，可以使用数组或者字典，只有一个key的环境变量可以在运行Compose的机器上找到对应的值，这有助于加密的或者特殊主机的值
```
environment:
  RACK_ENV: development
  SESSION_SECRET:
environments:
  - RACK_ENV=development
  - SESSION_SECRET
```

- env_file
从一个文件中加入环境变量，该文件可以是一个单独的值或者一张列表，在environment中指定的环境变量将会重写这些值
```
env_file:
  - .env


RACK_ENV: development
```
- net
网络模式，可以在docker客户端的--net参数中指定这些值
```
net: "bridge"
net: "none"
net: "container:[name or id]"
net: "host"
```
- dns
自定义DNS服务，可以是一个单独的值或者一张列表
```
dns: 8.8.8.8
dns:
  - 8.8.8.8
  - 9.9.9.9
```

> 可以看出docker-compose落地到具体的项目中，当具体的项目需要依赖的环境发生变化或者部署生产，可以在这些项目根目录中建立docker-compose.yml，解决如何管理的问题


> 问题：docker-compose创建容器会发现容器name和定义不一致，但是用docker-compose可以管理，没太明白为啥?

- docker-compose 基本包括了docker的基本命令：
```
build 构建或重建服务
help 命令帮助
kill 杀掉容器
logs 显示容器的输出内容
port 打印绑定的开放端口
ps 显示容器
pull 拉取服务镜像
restart 重启服务
rm 删除停止的容器
run 运行一个一次性命令
scale 设置服务的容器数目
start 开启服务
stop 停止服务
up 创建并启动容器
```

如重启nginx
```
docker-compose restart nginx
```

## dockerfile
```
FROM image #代表新的镜像是从image这个基础镜像来的

MAINTAINER：指定该镜像创建者

ENV：指定环境变量

COPY：将编译机本地文件拷贝到镜像文件系统中

EXPOSE：指定监听的端口

ENTERPOINT：欲执行命令，使用该镜像创建容器，容器启动时执行，如 ENTRYPOINT ["php", "/var/www/code/easyswoole", "start"]

RUN：执行shell命令

```
easyswoole dockerfile
```dockerfile
FROM php:7.1

# Version
ENV PHPREDIS_VERSION 4.0.1
ENV SWOOLE_VERSION 4.3.0
ENV EASYSWOOLE_VERSION 3.x-dev

# Timezone
RUN /bin/cp /usr/share/zoneinfo/Asia/Shanghai /etc/localtime \
    && echo 'Asia/Shanghai' > /etc/timezone

# Libs
RUN apt-get update \
    && apt-get install -y \
    curl \
    wget \
    git \
    zip \
    libz-dev \
    libssl-dev \
    libnghttp2-dev \
    libpcre3-dev \
    && apt-get clean \
    && apt-get autoremove

# Composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer self-update --clean-backups

# PDO extension
RUN docker-php-ext-install pdo_mysql

# Bcmath extension
RUN docker-php-ext-install bcmath

# Redis extension
RUN wget http://pecl.php.net/get/redis-${PHPREDIS_VERSION}.tgz -O /tmp/redis.tar.tgz \
    && pecl install /tmp/redis.tar.tgz \
    && rm -rf /tmp/redis.tar.tgz \
    && docker-php-ext-enable redis

# Swoole extension
RUN wget https://github.com/swoole/swoole-src/archive/v${SWOOLE_VERSION}.tar.gz -O swoole.tar.gz \
    && mkdir -p swoole \
    && tar -xf swoole.tar.gz -C swoole --strip-components=1 \
    && rm swoole.tar.gz \
    && ( \
    cd swoole \
    && phpize \
    && ./configure --enable-async-redis --enable-mysqlnd --enable-openssl --enable-http2 \
    && make -j$(nproc) \
    && make install \
    ) \
    && rm -r swoole \
    && docker-php-ext-enable swoole

WORKDIR /var/www/code

# Install easyswoole
RUN cd /var/www/code \
    && composer require easyswoole/easyswoole=${EASYSWOOLE_VERSION} \
    && php vendor/bin/easyswoole install

EXPOSE 9501

ENTRYPOINT ["php", "/var/www/code/easyswoole", "start"]
```

构建image,切换到Dockerfile同级目录：

docker buil -t easyswoole:1.0 

有了Dockerfile文件，维护就很简单了，只需修改文件内容，重新构建即可，-t还可以指定版本标签。

## 仓库
docker Hub存放发布镜像的仓库，用户可以在https://hub.docker.com/中注册账号，既可发布镜像。

```shell
//登录docker Hub
docker login Username: sun Password: 123456 Email:sun@sun.com 

//上传镜像
docker push easyswoole:1.0

```

此外可能由于网络问题、安全问题，还可以使用私有仓库，具体执行命令本文不在细究。


<!--## 网络-->

**注意**
docker compose可以判断容器间的依赖并生成正确的启动顺序，但仅仅是启动顺序，每个容器的启动时间不太一致，如果有依赖可能会不能正常交互导致启动失败。




