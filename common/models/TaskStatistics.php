<?php

use yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class TaskStatistics extends ActiveRecode {

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => 'update_time',
                'value' => date('Y-m-d H:i:s')
            ]
        ];
    }

    public function tableName() {
        return '{{%task_statistics}}';
    }
}