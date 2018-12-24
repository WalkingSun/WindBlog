<?php

namespace app\controllers;

use app\models\ArticleFactory;
use app\models\Common;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class IndexController extends BaseController
{
    public $result;

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
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $d = $this->data;
        $data = [
            'type'   =>  !empty($d['type'])?$d['type']:1,
            'page'   =>  !empty($d['page'])?$d['page']:1,
            'size'   =>  !empty($d['size'])?$d['size']:10,
        ];
        $this->result =  ArticleFactory::init($data)->list($data);
        if( !empty( $d['async'] ) ) Common::echoJson(200,$this->result);

        return $this->render('index',['result'=>$this->result]);
    }

}
