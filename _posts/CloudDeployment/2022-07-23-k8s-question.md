---
layout: blog
title: K8S question
categories: [k8s]
description: k8s
keywords: k8s
cnblogsClass: \[Markdown\],\[随笔分类\]服务器,\[随笔分类\]k8s
---

# ImagePullBackoff
secret没配置

# job更新部署失败，提示metadata.nama不可更新

job name不可更新，必须保证不能重复，可增加job标识

```yaml
apiVersion: batch/v1  
kind: Job  
metadata:  
  namespace: {{ .Values.namespace }}  
  name: {{ .Values.app.name }}{{ .Values.env.version }}{{ .Values.env.jobID }}  
  labels:  
    app: {{ .Values.app.name }}  
    chart: {{ .Chart.Name }}  
    instance: {{ .Release.Name }}  
    managed-by: {{ .Release.Service }}
...
```

# k8s 服务滚动触发go panic

滚动更新或重启，会传递中断信号，触发go server panic