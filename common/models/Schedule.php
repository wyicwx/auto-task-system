<?php

namespace common\models;

use yii\base\Model;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use common\models\TaskModel;
use common\models\Task;

class Schedule extends ActiveRecord {
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