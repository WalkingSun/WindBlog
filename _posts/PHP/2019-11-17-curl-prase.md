---
layout: blog
title: 抓包curl解析
categories: [PHP, 知识点]
description: 熟悉
keywords: php
cnblogsClass: \[Markdown\],\[随笔分类\]PHP
oschinaClass: \[Markdown\],PHP,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

# 背景
抓包工具charles抓取的请求curl，是这样：
```
curl -H ':method: POST' -H ':path: /client.action?functionId=signInCouponCenter&clientVersion=8.3.4&build=70302&client=android&d_brand=HUAWEI&d_model=JKM-AL00bxxxxx' -H ':authority: api.m.jd.com' -H ':scheme: https' -H 'cookie:xxxxx' -H 'charset: UTF-8' -H 'accept-encoding: gzip,deflate'  -H 'cache-control: no-cache' -H 'content-type: application/x-www-form-urlencoded; charset=UTF-8' -H 'content-length: 95' -H 'user-agent: okhttp/3.12.1' --data-binary "body=%7B%22monitorRefer%22%3A%22%22%2C%22monitorSource%22%3A%22ccsign_android_index_sign%22%7D&" 'https://api.m.jd.com/client.action?functionId=signInCouponCenter&clientVersion=8.3.4&build=70302&client=android&d_brand=HUAWEI&d_model=JKM-AL00bxxx'
```

拿到这个curl我可以直接在服务器跑这个curl命令，现在我想使用php做脚本，我希望可以便利的转换，不需要我自己写太多代码爬取，写了下如下方法，后面去爬取内容两行代码轻松搞定，舒畅！

# code
```php
<?php

  //linux curl 解析
    public function curlParse( $curls ){

        $curls = trim($curls,'curl');
        $h = explode(' -H ',$curls);
        $h = array_filter($h);
        $data = array_pop($h);
        $d = explode(' --data-binary ',$data);
        $h[] = array_shift($d);

        $header = [];
        $actions = [];
        foreach ($h as $k=>$v){
            $v = trim($v,"'");
            $t = explode(' ',$v);
            $key = array_shift($t);
            if( in_array($key,[':path:',':method:','authority','scheme']) ){
                $actions[trim($key,':')] = implode(' ',$t);
                unset($h[$k]);
            }

            $header[trim($key,':')] = implode(' ',$t);
        }

        $d = explode(' ',array_pop($d));
        $submitData = trim($d[0],"\"");
        $url = trim(array_pop($d),"'");

        $method = $actions['method'];
        return httpRequest($url,$submitData,$header,$method);
    }


    //请求
    public function httpRequest($url,$data,$header=[],$method){

        if ( empty($header[0]) ) {
            $headers = [];
           foreach ($header as $k => $v){
               $headers[] = "{$k}: {$v}";
           }
            $header = $headers;
        }

        $curl = curl_init();

        $curlSet = [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_HTTPHEADER => $header
        ];

        if( $method=='POST' ){
            $curlSet[CURLOPT_CUSTOMREQUEST] = "POST";
            $curlSet[CURLOPT_POSTFIELDS] = $data;
        }

        curl_setopt_array($curl,$curlSet);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err)
            throw new \Exception("cURL Error #:" . $err);

        $response = json_decode($response,1);
        return $response;
    }
    
    $curl = "curl -H ':method: POST' -H ':path: /client.action?functionId=signInCouponCenter&clientVersion=8.3.4&build=70302&client=android&d_brand=HUAWEI&d_model=JKM-AL00bxxxxx' -H ':authority: api.m.jd.com' -H ':scheme: https' -H 'cookie:xxxxx' -H 'charset: UTF-8' -H 'accept-encoding: gzip,deflate'  -H 'cache-control: no-cache' -H 'content-type: application/x-www-form-urlencoded; charset=UTF-8' -H 'content-length: 95' -H 'user-agent: okhttp/3.12.1' --data-binary "body=%7B%22monitorRefer%22%3A%22%22%2C%22monitorSource%22%3A%22ccsign_android_index_sign%22%7D&" 'https://api.m.jd.com/client.action?functionId=signInCouponCenter&clientVersion=8.3.4&build=70302&client=android&d_brand=HUAWEI&d_model=JKM-AL00bxxx'";
    curlParse($curl);
    
```