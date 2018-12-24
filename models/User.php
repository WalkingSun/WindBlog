<?php

namespace app\models;

class User extends \yii\base\Object implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $password;
    public $salt;
    public $authKey;
    public $accessToken;

    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'super',
            'password' => '3.1415926',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
//        '101' => [
//            'id' => '101',
//            'username' => 'admin',
//            'password' => 'admin111111',
//            'authKey' => 'test101key',
//            'accessToken' => '101-token',
//        ],
    ];


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        if( !isset(self::$users[$id]) ){
            $users = JpUser::find()->select([])->where(['userId'=>$id])->one();
            self::$users[$id] = [
                'id' => $users->userId,
                'username' => $users->username,
                'password' => $users->password,
                'salt' => $users->salt,
                'authKey' => "test{$users->userId}key",
                'accessToken' => $users->userId.'-token',
            ];
        }

        return new static(self::$users[$id]);
//        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        //查询用户信息
        if( $users = JpUser::find()->select([])->where(['username'=>$username])->one() ){
            $user = [
                'id' => $users->userId,
                'username' => $users->username,
                'password' => $users->password,
                'salt' => $users->salt,
                'authKey' => "test{$users->userId}key",
                'accessToken' => $users->userId.'-token',
            ];
            self::$users[$users->userId] = $user;
            return new static($user);
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        if( $this->salt ){
            return $this->password === md5($password.$this->salt);
        }
        return $this->password === $password;
    }
}
