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
            foreach($this->datatype_name as $value) {
                if(!$value) {
                    $this->addError($attribute, '数据类型为必填项！');
                    return false;
                }
                if(!preg_match('/^[a-zA-Z]+$/', $value)) {
                    $this->addError($attribute, '数据类型必须为区分大小写的字母字符串！');
                    return false;
                }
            }
        }
    }

    public function loadFromDB($model, $prefix = '') {
        if($model['datatype']) {
            $datatype = json_decode($model['datatype'], true);
            $datatype_name = [];
            $datatype_type = [];

            foreach ($datatype as $item) {
                array_push($datatype_name, $item['name']);
                array_push($datatype_type, $item['type']);
            }
        }

        $model['datatype_name'] = $datatype_name;
        $model['datatype_type'] = $datatype_type;

        $this->load($model, $prefix);
    }

    protected function encodeDatatype() {
        $datatype = [];

        foreach($this->datatype_type as $index => $type) {
            $datatype[] = [
                'name' => $this->datatype_name[$index],
                'type' => $this->datatype_type[$index]
            ];
        }

        $this->datatype = json_encode($datatype);
    }

    public function add() {
        if($this->validate()) {
            $this->encodeDatatype();

            $taskModel = new TaskModel();

            $taskModel->uid = Yii::$app->user->id;
            $taskModel->name = $this->name;
            $taskModel->description = $this->description;
            $taskModel->code = $this->code;
            $taskModel->datatype = $this->datatype;
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