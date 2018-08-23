<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/16
 * Time: 17:52
 */
return [
    'enablePrettyUrl' => true, // 路由美化
    'enableStrictParsing' => true, // 严格检查路由美化,后缀加s
    'showScriptName' => false,
    'cache' => false, // 关闭路由缓存
    'rules' => [
        [
            'class' => 'yii\rest\UrlRule',
            'controller' => [
                'site'
            ],
            'extraPatterns' => [
                'index' => 'index',
                'login' => 'login'
            ],
        ]
    ],

];
