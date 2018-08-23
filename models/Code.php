<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class Code extends Model
{
    public $verifyCode;

    public function rules()
    {
        return [
            ['verifyCode', 'required'],
            ['verifyCode', 'captcha'],
        ];
    }
    public function validateVerifyCode($verifyCode){
        if(strtolower($this->verifyCode) === strtolower($verifyCode)){
            return true;
        }else{
            $this->addError('verifyCode','验证码错误.');
        }
    }
}
