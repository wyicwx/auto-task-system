<?php

namespace common\models;

use yii\base\Model;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use common\models\TaskModel;
use common\models\Task;
use common\models\User;

class Schedule extends ActiveRecord {
    const STATUS_SUCCESS = 0;
    const STATUS_FAIL = 1;
    const STATUS_UNRUN = 2;
    const STATUS_TERMINATION = 3;
    const STATUS_RETRY_UNRUN = 4;

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'create_time',
                'updatedAtAttribute' => 'update_time',
                'value' => date('Y-m-d H:i:s')
            ]
        ];
    }

    public static function tableName() {
        return '{{%schedule}}';
    }

    public function getUser() {
        return $this->hasOne(User::className(), [
            'id' => 'uid'
        ]);
    }

    public function getModel() {
        return $this->hasOne(TaskModel::className(), [
            'id' => 'mid'
        ]);
    }

    public function getTask() {
        return $this->hasOne(Task::className(), [
            'uid' => 'uid',
            'id' => 'tid'
        ]);
    }
}