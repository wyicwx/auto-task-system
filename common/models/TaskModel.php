<?php 
namespace common\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use common\models\User;

class TaskModel extends ActiveRecord {
    const DATATYPE = ['string', 'number'];

    public static function tableName() {
        return '{{%model}}';
    }

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

    public static function getTaskModelById($id) {
        return static::find()
                    ->where(['id' => $id]);
    }
    public function getUser() {
        return $this->hasOne(User::className(), [
            'id' => 'uid'
        ]);
    }
    /**
     * 获取列表
     */
    public static function getTaskModelList($uid = null, $online = false) {
        $query = static::find();

        if($uid) {
            $query = $query->where(['uid' => $uid]);
        }

        if($online) {
            $query = $query->where(['status' => '1']);
        }

        return $query;
    }

    public static function getTaskModelListByIds($ids) {
        $query = static::find();

        $query = $query->where(['id' => $ids]);

        return $query;
    }
}