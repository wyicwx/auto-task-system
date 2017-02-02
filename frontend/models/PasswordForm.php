<?php

namespace frontend\models;

use yii;
use yii\base\Model;

class PasswordForm extends Model {
    public $password;
    public $newpassword;
    public $repassword;

    public function rules() {
        return [
            [['password', 'newpassword', 'repassword'], 'required'],
            ['newpassword', 'string', 'min' => 6, 'message' => '密码至少6位！'],
            ['newpassword', 'string', 'max' => 24,'message' => '密码至多24位！'],
            [['newpassword'], 'validateNewPassword'],
            ['password', 'validatePassword']
        ];
    }

    public function validatePassword($attribute) {
        if(!$this->hasErrors()) {
            if(!Yii::$app->user->identity->validatePassword($this->password)) {
                $this->addError($attribute, '原密码错误！');
            }
        }
    }

    public function validateNewPassword() {
        if(!$this->hasErrors()) {
            if($this->newpassword !== $this->repassword) {
                $this->addError($attribute, '密码不一致！');
            }
        }
    }
}