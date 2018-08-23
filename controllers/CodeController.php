<?php

namespace app\controllers;

use app\models\Code;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\CodeForm;
use app\modules\Common;
use app\modules\UpYunForm;

class CodeController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'maxLength' => 5,
                'minLength' => 5
            ],
        ];
    }

    public function actionIndex()
    {

        $upyun = new UpYunForm('gongyinglian', 'LAQBrwLQXEkYzBxqzUF1YYTkv40=');
        $opts = array();
        $opts['save-key'] = '/' . date('Y/m/d') . '/{random32}/{filename}{.suffix}';   // 保存路径
        $opts['notify-url'] = 'http://pos.tunnel.qydev.com/v1/upyuns/notify';
        $opts['content-length-range'] = '102400,5120000';
        $fsOptionsId = uniqid("", true) . mt_rand(1000, 99999);
        $type='Supplier';
        $user=[
            'fsUserId'=>1,
            'fsUserName'=>'admin',
            'fsShopGUID'=>66666
        ];
        $ext_param = [
            'fsOptionsId' => $fsOptionsId,
            'userId'=>$user['fsUserId'],
            'userName'=>$user['fsUserName'],
            'fsShopGUID'=>$user['fsShopGUID'],
            'type'=>$type
        ];
        $opts['ext-param'] = json_encode($ext_param);
        $policy = $upyun->policyCreate($opts);
        $sign = $upyun->signCreate($opts);
        $action = $upyun->action();
        $version = $upyun->version();
        $data = [
            'policy' => $policy,
            'sign' => $sign,
            'action' => $action,
            'version' => $version,
            'fsOptionsId' => $fsOptionsId,
        ];
        return $this->render('index', ['data' => $data]);
    }

    public function actionLogin()
    {
        $code = Yii::$app->request->post('code');
        if (strtolower($this->createAction('captcha')->getVerifyCode()) !== strtolower($code)) {


            Common::echoJson(400, '输入的验证码不正确');
        }

    }

}
