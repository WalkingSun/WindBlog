---
layout: blog
title: docker及服务器遇到的坑
categories: [服务器,docker]
description: 记录docker遇到的坑
keywords: IM
cnblogsClass: \[Markdown\],\[随笔分类\]遇到问题,\[随笔分类\]服务器
oschinaClass: \[Markdown\],服务器,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

# DNS不可用
如出现这样的错误：
```
ERROR: error pulling image configuration: Get https://production.cloudflare.docker.com/registry-v2/docker/registry/v2/blobs/sha256/88/881bd08c0b08234bd19136957f15e4301097f4646c1e700f7fea26e41fc40069/data?verify=1552449302-pJVj4p2TS9sUquWEjuDZgIA0f7E%3D: dial tcp: lookup production.cloudflare.docker.com on 10.0.2.3:53: no such host
```

进入 /etc/resolv.conf  添加
```
nameserver 8.8.8.8
```

vagrant 搭的虚拟环境或者docker里面遇到过，每次重启都会失效，可以写个shell脚本修改，每次开机启动就好了。

docker使用还有种方案，容器内的/etc/resolv.conf挂载到宿主机下 /etc/resolv.conf。

# 修改docker查找源
```
docker search centos
Error response from daemon: Get https://index.docker.io/v1/search?q=centos: read tcp 52.200.132.201:443: i/o timeout
```

进入/etc/docker

查看有没有 daemon.json。这是docker默认的配置文件。

如果没有新建，如果有，则修改。
```
$ vi daemon.json
 {
   "registry-mirrors": ["https://registry.docker-cn.com"]
 }
```
 保存退出。

重启docker服务

service docker restart

成功！

# 容器保持固定ip
 https://yaxin-cn.github.io/Docker/docker-container-use-static-IP.html


# 查看docker连接

查看容器进程号

docker inspect -f '{{.State.Pid}}' <containerid>

查看连接

nsenter -t 1840 -n netstat   #1840为上面操作获取的pid

# 容器间通信
参考文章 https://birdben.github.io/2017/05/02/Docker/Docker实战（二十七）Docker容器之间的通信/

新版docker，在容器B run中使用 --link 【容器A】，这样在容器B中就能与容器A建立连接，如需要用到容器A的ip，进行连接服务：
```
# mysql是容器名
mysql:3306/users?user=root&password=123456
```

# 容器拷贝数据

- 从容器拷贝数据到宿主机

docker cp 容器名：要拷贝的文件在容器里面的路径       要拷贝到宿主机的相应路径

- 从宿主机拷贝数据到容器

docker cp 要拷贝的文件路径 容器名：要拷贝到容器里面对应的路径

# php连接docker mysql 8.0出错authentication method unknown
```
SQLSTATE[HY000] [2054] The server requested authentication method unknown to the client
```

MySQL 8默认使用了新的密码验证插件：caching_sha2_password，而之前的PHP版本中所带的mysqlnd无法支持这种验证

解决方法两种，一种是升级PHP支持mysql8的新验证插件，另一种mysql验证方式降级。

mysql配置文件 my.cnf添加配置：
```
default_authentication_plugin=mysql_native_password
```

# docker php容器 fpm总是出现file not found

nginx 配置SCRIPT_FILENNAME 一定要注意  配置的是php容器中代码所在的路径，不是nginx的路径，这个坑坑了我许久!!!

```nginx
location ~ \.php$ {
    fastcgi_pass 127.0.0.1:9000;
    fastcgi_index index.php;
    #fastcgi_param SCRIPT_FILENAME  $document_root$fastcgi_script_name;
    fastcgi_param SCRIPT_FILENAME  /var/www/html/$fastcgi_script_name;
    include fastcgi_params;
}    
```

# docker 安装amqp扩展
php7.1-fpm  总提示lib错误
```
apt-get -y install librabbitmq-dev
```

# Docker容器内连接宿主机的Mysql服务器

宿主机在与容器同一局域网的IP地址一般是docker0对应的IP地址段的首个地址（如172.0.17.1）
我们可以在容器里通过172.0.17.1:3306访问到宿主机的mysql服务器

mysql服务器默认的设置为允许127.0.0.1段的ip地址访问
所以此时用172.0.17.1:3306仍然无法访问到宿主机
此时需要在设置一下mysql

```
 mysql>GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY '123456' WITH GRANT OPTION;
 mysql>flush privileges;
// 其中各字符的含义：
// *.* 对任意数据库任意表有效
// "root" "123456" 是数据库用户名和密码
// '%' 允许访问数据库的IP地址，%意思是任意IP，也可以指定IP
// flush privileges 刷新权限信息
```

我用vagrant+virtualbox,ipconfig查询本机ip，然后去连，连上了