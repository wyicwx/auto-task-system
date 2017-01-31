<?php
namespace common\models;

use Yii;
use yii\base\Model;
use common\models\TaskModel;

class TaskModelForm extends Model {
    public $id;
    public $name;
    public $description;
    public $code;
    public $status = 0;
    public $datatype;

    public function rules() {
        return [
            [['name', 'code'], 'required'],
            [['datatype'], 'validateDatatype'],
            [['id', 'description'], 'safe']
        ];
    }

    public function validateDatatype($attribute, $params) {
        if (!$this->hasErrors()) {
            if(!count($this->datatype)) {
                $this->addError($attribute, '数据类型为必填项！');
                return false;
            }

            foreach($this->datatype as $item) {
                if(!$item['name'] || !$item['type']) {
                    $this->addError($attribute, '数据类型为必填项！');
                    return false;
                }
                if(!preg_match('/^[a-zA-Z]+$/', $item['name'])) {
                    $this->addError($attribute, '数据类型必须为区分大小写的字母字符串！');
                    return false;
                }
                if(!in_array($item['type'], TaskModel::DATATYPE)) {
                    $this->addError($attribute, '数据类型非法！');
                    return false;
                }
            }
        }
    }

    public function loadFromDB($model, $prefix = '') {
        if($model['datatype']) {
            $datatype = json_decode($model['datatype'], true);
            $model['datatype'] = $datatype;
        }

        $this->load($model, $prefix);
    }

    public function add() {
        if($this->validate()) {
            $taskModel = new TaskModel();

            $taskModel->uid = Yii::$app->user->id;
            $taskModel->name = $this->name;
            $taskModel->description = $this->description;
            $taskModel->code = $this->code;
            $taskModel->datatype = json_encode($this->datatype);
            $taskModel->status = 0;

            return $taskModel->save() ? $taskModel : null;
        }

        return null;
    }

    public function save() {
        if($this->validate()) {
            $taskModel = TaskModel::findOne($this->id);

            $taskModel->name = $this->name;
            $taskModel->description = $this->description;
            $taskModel->code = $this->code;

            return $taskModel->save(false) ? $taskModel : null;
        }
    }
}