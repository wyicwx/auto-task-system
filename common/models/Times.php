<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Times extends ActiveRecord {
    const TYPE_TASK = 'task';
    const TYPE_MODEL = 'model';

    public static function tableName() {
        return '{{%times}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => null,
                'updatedAtAttribute' => 'update_time',
                'value' => date('Y-m-d H:i:s')
            ]
        ];
    }

    
}