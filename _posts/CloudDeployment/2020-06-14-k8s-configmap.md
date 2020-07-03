---
layout: blog
title: K8S ConfigMap更新
categories: [k8s]
description: k8s
keywords: k8s
cnblogsClass: \[Markdown\],\[随笔分类\]服务器,\[随笔分类\]k8s
oschinaClass: \[Markdown\],服务器,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

# ConfigMap
ConfigMap 是 configMap 是一种 API 对象，用来将非机密性的数据保存到健值对中。使用时可以用作环境变量、命令行参数或者存储卷中的配置文件。

ConfigMap 将您的环境配置信息和 容器镜像 解耦，便于应用配置的修改。当您需要储存机密信息时可以使用 Secret 对象。

具体用法查看[官网](https://kubernetes.io/zh/docs/concepts/configuration/configmap/)，这里记录下使用过程中遇到的问题。 

项目中会将配置放到configmap，然后创建应用时，会读取configmap内容，映射到pod容器中，对应到项目的配置路径。

## 创建configmap
- k8s配置文件形式
configmap-nginx.yaml
```yaml
kind: ConfigMap
apiVersion: v1
metadata:
  name: nginx-config
data:
  app.conf: |
    server {
      listen 80 default_server;
      listen [::]:80 default_server;

      root /var/www/html/app/;
      server_name walking.com;
      index  index.php index.html index.htm;
      location / {
        try_files $uri $uri/ /index.php$is_args$args;
      }
      location ~ \.php {
        fastcgi_pass   app-php:9000;
        fastcgi_index  index.php;
        include        fastcgi.conf;
      }
    }
  abc.conf: walking.com
```

创建configmap，
```bash
kubectl apply -f configmap-nginx.yaml -n [namesapce]
```
kubectl apply -f  也可以更新操作。

 -n [namesapce] 指定命名空间，没有就会是默认default命名空间。
 
- 从文件或者目录加载进去
```bash
kubectl create configmap game-config --from-file=configure-pod-container/configmap/ -n [namesapce]
```

更新会麻烦点，使用管道，先获取内容，在使用```kubectl replace -f```实现更新。
```bash
kubectl create configmap nginx-config --from-file configure-pod-container/configmap/ -o yaml --dry-run -n [namesapce] | kubectl replace -f -
```
- 从文字生成ConfigMap
为了从字面一个ConfigMap special.type=charm并且special.how=very，你可以指定ConfigMap发电机kustomization.yaml作为
```bash
  # Create a kustomization.yaml file with ConfigMapGenerator
  cat <<EOF >./kustomization.yaml
  configMapGenerator:
  - name: special-config-2
    literals:
    - special.how=very
    - special.type=charm
  EOF
``` 
  
应用Kustomization目录创建ConfigMap对象。
```bash
kubectl apply -k .

configmap/special-config-2-c92b5mmcf2 created

```

> 关于configmap的更新着实躺了个坑,当时也没查到相关资料，就自己动手用shell实现了套。
```bash
#!/bin/bash

path=./config

cd $path

# kubectl 更新
kubectlUpdate() {
   `rm -rf ../configmap.yaml`

  if [ -f "$1" ];then
    str=$str"  "$1:" |-\n"$(awk '{print "    "$0}' $1)"\n"
  else
    callback=$(ls $1)
    str="data:\n"
    for filename in $callback
    do
      if [  -d "$1/$filename" ];then
        continue
      else
        # 获取所有配置
        str=$str"  "$filename:" |-\n"$(awk '{print "    "$0}' $1/$filename)"\n"
      fi
    done
  fi

  # configmap内容写入临时文件configmap.yaml
  content="---
apiVersion: v1
kind: ConfigMap
metadata:
  name: $2
  namespace: namespace"
  `echo -e "${content}" >> ../configmap.yaml && echo -e "${str}" >> ../configmap.yaml`

  # 更新configmap
  echo `kubectl apply -f ../configmap.yaml -n bigdata`
  return
}


# params create
res_params=`kubectl create configmap params-configmap --from-file=config/ -n [namespace]`
if [ -z "$res_params" ];then
  kubectlUpdate config/ params-configmap
else
  echo $res_params
fi
```
还是躺了个坑。

## 查看configmap
```bash
# -0 yaml 代表输出以yaml形式
kubectl get configmaps special-config -o yaml
```

