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
    public $retry = 0;

    public function rules() {
        return [
            [['frequency', 'data'], 'required'],
            ['frequency', 'frequencyValidate'],
            ['data', 'dataValidate'],
            ['retry', 'retryValidate'],
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

    public function retryValidate($attribute, $params) {
        if(!$this->hasErrors()) {
            $retry = (int) $this->retry;

            if($retry < 0) {
                $this->addError($attribute, '重试次数需在0~10之间！');
                return false;
            }
            if($retry > Task::RETRY_MAX) {
                $this->addError($attribute, '重试次数需在0~10之间！');
                return false;
            }
        }
    }

    public function frequencyValidate($attribute, $params) {
        if(!$this->hasErrors()) {
            if(!in_array($this->frequency, Task::FREQUENCY)) {
                $this->addError($attribute, '执行次数非法！');
                return false;
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
            $task = new Task();

            $task->uid = Yii::$app->user->id;
            $task->mid = $modelId;
            $task->data = json_encode($this->data);
            $task->frequency = $this->frequency;
            $task->remark = $this->remark;
            $task->status = Task::STATUS_RUN;
            $task->retry = $this->retry;

            return $task->save() ? $task : null;
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
            $task->retry = $this->retry;

            return $task->save(false) ? $task : null;
        }
    }
}