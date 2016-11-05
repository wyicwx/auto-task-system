<?php

namespace common\models;

use yii\base\Model;
use yii\db\ActiveRecord;

class LogCrontab extends ActiveRecord {
    public static function tableName() {
        return '{{%log_crontab}}';
    }
}