<?php
namespace common\models;

use yii\db\ActiveRecord;

class UserAuth extends ActiveRecord {
    const TYPE_EMAIL = 1;
    const TYPE_PHONE = 2;
    const TYPE_USERNAME = 3;

    public static function tableName() {
        return '{{%user_auth}}';
    }

    public static function checkType() {
        
    }

    public function login() {

    }
}