<?php
$params = require(__DIR__ . '/../config/params.php');

@define('SYS_PREFIX', ['Z-', 'X-', 'Y-']);
$config = [
    'id' => 'basic',
    'timeZone' => 'PRC',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => 'metaweblog/index',
    'modules' => [
        'v1' => [
            'class' => 'app\modules\v1\Module'
        ]
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '3taPEpht1wW1256KJrT-9yE-X8DyHohc',
            // 解析request请求为json
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]

        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [//邮件发送，接收配置
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,//这句一定有，false发送邮件，true只是生成邮件在runtime文件夹下，不发邮件
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.qq.com',  //每种邮箱的host配置不一样
                'username' => '',
                'password' => '',
                'port' => '25',
                'encryption' => 'tls',

            ],
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => ['zhang.email.wei@qq.com' => 'admin']
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                'file' => [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['trace', 'info', 'warning'],
                    'categories' => ['yii\*'],
                ],
            ]
        ],
        'db' => require(__DIR__ . '/db.php'),
//        'redis' => require(__DIR__ . '/../../config/redis.php'),
//        'session' => [
//            'class' => 'yii\redis\Session',
//            'timeout' => 10000,
//        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'keyPrefix' => 'jump',    // 唯一键前缀

        ],
        'urlManager' => require(__DIR__ . '/urlmanage.php'),

    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.33.1', '192.168.1.*'] // adjust this to your needs
    ];
}

return $config;
