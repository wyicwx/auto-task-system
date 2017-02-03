<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use common\models\TaskModel;
use common\models\Schedule;

class Task extends ActiveRecord {
    const STATUS_RUN = 0;
    const STATUS_PAUSE = 1;
    const STATUS_DELETE = -1;
    const FREQUENCY = [1, 2, 3, 4, 6, 8, 12, 24]; // 频率
    const FREQUENCY_INTERVAL = [
        1 => 24,
        2 => 12, 
        3 => 8, 
        4 => 6, 
        6 => 4,
        8 => 3,
        12 => 2, 
        24 => 1
    ]; // 间隔
    const RETRY_MAX = 10;


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
            // $query = $query->joinWith('times');
        }


        // echo $query->createCommand()->getRawSql();exit;

        return $query;
    }

    public function getModel() {
        return $this->hasOne(TaskModel::className(), ['id' => 'mid']);
    }

    public function getTimes() {
        return $this->hasMany(Schedule::className(), ['tid' => 'id']);
    }
}