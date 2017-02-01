<?php

namespace frontend\models;

use yii\base\Model;

class ProfileForm extends Model {
    public $nickname;
    public $email;

    public function rules() {
        return [
            [['nickname', 'email'], 'required'],
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
                        ->one();

            if($result) {
                $this->addError($attribute, '邮箱已存在！');
                return false;
            }
        }
    }
}