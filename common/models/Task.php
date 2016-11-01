<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use common\models\TaskModel;

class Task extends ActiveRecord {
    const STATUS_RUN = 1;
    const STATUS_PAUSE = 0;
    const FREQUENCY = [1, 2, 3, 4, 6, 12, 24];

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
        return '{{%task}}';
    }

    /**
     * 获取列表
     */
    public static function getTaskList($uid = null) {
        $query = static::find();

        if($uid) {
            $query = $query->where(['uid' => $uid]);
        }

        return $query;
    }

    public function getModel() {
        return $this->hasOne(TaskModel::className(), ['id' => 'mid']);
    }
}