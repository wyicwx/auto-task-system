<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Times extends ActiveRecord {
    const TYPE_TASK = 'task';
    const TYPE_MODEL = 'model';

    public function tableName() {
        return '{{%times}}';
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

    
}