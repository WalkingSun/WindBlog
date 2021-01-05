---
layout: blog
title: Nginx流量控制
categories: [shell, 服务器]
description: nginx学习记录
keywords: shell
cnblogsClass: \[Markdown\],\[随笔分类\]服务器,,\[随笔分类\]网关
oschinaClass: \[Markdown\],服务器,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

# Nginx流量控制

## 流量复制

项目进行迁移上云，如何在不影响现有项目的情况下，进行验证测试，平滑迁移。理论上分割部分流量到云上进行验证，确定没有问题逐渐迁移，如果nginx不好分割流量的情况，其实不太好做迁移，风险太大。

nginx支持流量复制，在接收请求时，可以复制流量到另外的服务器而不关心响应，对原本的项目不会产生任何影响。

复制的流量转发到云上的服务跑动，验证数据流程没有问题，就可以对其整体切换。

## ngx_http_mirror_module
 implements mirroring of an original request by creating background mirror subrequests. Responses to mirror subrequests are ignored.
 通过创建后台镜像子请求实现原始请求的镜像。对镜像子请求的响应将被忽略；
 场景：可以做流量复制，不关心响应。作为机房迁移上云的过渡挺合适的，或者说是作为复制请求测试。

```nginx
location / {
    mirror /mirror;
    proxy_pass http://backend;
}

location = /mirror {
    internal;
    proxy_pass http://test_backend$request_uri;
}
```
参考：http://nginx.org/en/docs/http/ngx_http_mirror_module.html

## 流量分割

服务的流量压力巨大，并且个别接口有时候因为访问量暴涨，会影响到其他的接口服务；单个接口也可能因为某个维度爆量，影响其他维度的服务。所以就有必要对流量进行切割，使他们相互独立，隔离，达到解耦的效果。

举个实际项目中的应用列子，虽然使用k8s中的ingress处理的，但理论上没啥差别。可以看到有根据接口路径进行拆分，有根据解析参数进行切割，其实就是nginx的语法。

```nginx
---
apiVersion: networking.k8s.io/v1beta1
kind: Ingress
metadata:
  namespace: bigdata
  name: adc-ingress
  annotations:
    ingress.kubernetes.io/rewrite-target: /
    kubernetes.io/ingress.class: "nginx"					# ingress指定nginx		
    nginx.ingress.kubernetes.io/server-snippet: |     # 设置nginx 服务脚本配置
        set $flag 0;
        if ( $uri = /click) {
          set $flag 1;
        }
        if ( $args ~ project=ios ) {
          set $flag 1$flag;
        }
        if ( $flag = 11 ) {
          rewrite ^/(.*) $uri-ios break;
        }
spec:
  rules:
    - host: walking.sun.com
      http:
        paths:															# path对应nginx path
          - path: /click/google
            backend:
              serviceName: google-srv       # 指定path 请求会转发到对应的svc
              servicePort: 8080
          - path: /click-ios
            backend:
              serviceName: web-ios-srv
              servicePort: 8080
          - path: /click
            backend:
              serviceName: web-srv
              servicePort: 8080
    - host: walking.sun123.com
      http:
        paths:
          - path: /click/google
            backend:
              serviceName: google-srv
              servicePort: 8080
  tls:																			# 开发tls
    - hosts:
        - walking.sun.com
      secretName: sun.com
    - hosts:
        - walking.sun123.com
      secretName: sun123.com
```