<?php

namespace frontend\models;

use yii;
use yii\base\Model;
use common\models\User;

class RegisterForm extends Model {
    public $nickname;
    public $email;
    public $password;

    public function rules() {
        return [
            [['nickname', 'email', 'password'], 'required'],
            ['email', 'email'],
            ['password', 'string', 'min' => 6, 'message' => '密码至少6位！'],
            ['password', 'string', 'max' => 24,'message' => '密码至多24位！'],
            ['nickname', 'string', 'length' => [4, 24], 'message' => '请输入4~24个字符昵称！'],
            ['email', 'email', 'message' => '请填写正确邮箱格式！'],
            ['nickname', 'validateNickname'],
            ['email', 'validateEmail']
        ];
    }

    public function validateNickname($attribute) {
        if(!$this->hasErrors()) {
            $result = User::find()
                        ->where([
                            'nickname' => $this->nickname
                        ])
                        ->andWhere(['!=', 'id', Yii::$app->user->id])
                        ->one();

            if($result) {
                $this->addError($attribute, '昵称已存在！');
                return false;
            }
        }
    }

    public function validateEmail($attribute) {
        if(!$this->hasErrors()) {
            $result = User::find()
                        ->where([
                            'email' => $this->email
                        ])
                        ->andWhere(['!=', 'id', Yii::$app->user->id])
                        ->one();

            if($result) {
                $this->addError($attribute, '邮箱已存在！');
                return false;
            }
        }
    }

    public function register() {
        if($this->validate()) {
            $user = new User();
            $user->nickname = $this->nickname;
            $user->email = $this->email;
            $user->password = md5($this->password);
            $user->role = User::ROLE_NORMAL;
            $user->status = User::STATUS_ACTIVE;

            return $user->save() ? $user : null;
        } else {
            return null;
        }
    }
}

