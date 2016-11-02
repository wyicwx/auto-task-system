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
            ['email', 'email', 'message' => '请填写正确邮箱格式！']
        ];
    }
}