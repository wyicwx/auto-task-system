<?php
namespace common\models;

use Yii;
use yii\base\Model;
use common\models\Task;

class TaskForm extends Model {
    public $id;
    public $frequency;
    public $remark;
    public $data = [];

    public function rules() {
        return [
            [['frequency', 'data'], 'required'],
            ['data', 'dataValidate'],
            [['remark', 'id'], 'safe']
        ];
    }

    public function dataValidate($attribute, $params) {
        if(!$this->hasErrors()) {
            foreach($this->data as $key => $value) {
                if(!$value) {
                    $this->addError($attribute, '运行数据'.$key.'为必填项！');
                    return false;
                }
            }
        }
    }

    public function loadFromDB($model, $prefix = '') {
        if($model['data']) {
            $data = json_decode($model['data'], true);
            $model['data'] = $data;
        }

        $this->load($model, $prefix);
    }

    public function add($modelId) {
        if($this->validate()) {
            $model = new Task();

            $model->uid = Yii::$app->user->id;
            $model->mid = $modelId;
            $model->data = json_encode($this->data);
            $model->frequency = $this->frequency;
            $model->remark = $this->remark;
            $model->status = Task::STATUS_RUN;

            return $model->save() ? $model : null;
        } else {
            return false;
        }
    }

    public function save() {
        if($this->validate()) {
            $task = Task::findOne($this->id);

            $task->data = json_encode($this->data);
            $task->frequency = $this->frequency;
            $task->remark = $this->remark;

            return $task->save(false) ? $task : null;
        }
    }
}