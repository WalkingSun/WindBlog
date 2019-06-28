<?php
/**
 * Created by PhpStorm.
 * User: zhaoyu
 * Date: 2019/6/28
 * Time: 4:29 PM
 */

namespace app\models;


trait HttpRequestTrait
{

    /**get请求
     * @param $url
     * @return mixed
     */
    public function httpGet($url){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "Postman-Token: d42a1ecc-b2fc-4221-8792-50786434efff",
                "cache-control: no-cache"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            var_dump("cURL Error #:" . $err );
            Common::addLog('error.log',"cURL Error #:" . $err,0);
        }

        return $response;
    }



}