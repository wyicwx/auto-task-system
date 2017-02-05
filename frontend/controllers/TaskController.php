<?php
namespace frontend\controllers;

use yii;
use frontend\components\BaseController;
use common\models\TaskModel;
use common\models\TaskForm;
use common\models\Task;
use yii\data\Pagination;
use common\components\SandBox;
use common\models\Schedule;

class TaskController extends BaseController {
    public function actionCreate() {
        if(Yii::$app->request->isPost) {
            $mid = Yii::$app->request->post('mid');
            $taskModel = TaskModel::findOne($mid);
            $form = new TaskForm();

            $form->load(Yii::$app->request->post(), '');
            $result = $form->add($mid);

            if($result) {
                return $this->renderAjax([
                    'id' => $result->id
                ]);
            } else {
                return $this->renderAjaxFormError($form);
            }
        } else {
            return $this->renderAjaxError();
        }
    }

    public function actionList() {
        $list = Task::find()
                    ->where(['uid' => Yii::$app->user->id])
                    ->andWhere(['!=', 'status', Task::STATUS_DELETE])
                    ->orderBy('update_time desc');

        $pages = new Pagination(['totalCount' => $list->count()]);

        $list = $list->limit($pages->limit)
                    ->offset($pages->offset)
                    ->with('model')
                    ->asArray()
                    ->all();

        return $this->renderAjaxList($list, $pages);
    }

    public function actionUpdate() {
        if(Yii::$app->request->isPost) {
            $taskId = Yii::$app->request->post('id');

            $task = Task::find()
                    ->where([
                        'id' => $taskId,
                        'uid' => Yii::$app->user->id
                    ])
                    ->one();

            if($task) {
                $form = new TaskForm();
                $form->loadFromDB($task->attributes, '');

                $form->load(Yii::$app->request->post(), '');

                if($form->save()) {
                    return $this->renderAjax();
                } else {
                    return $this->renderAjaxFormError($form);
                }
            }
        }
        return $this->renderAjaxError();
    }

    public function actionPause() {
        $taskId = Yii::$app->request->post('id');

        $task = Task::find()
                    ->where([
                        'id' => $taskId,
                        'uid' => Yii::$app->user->id
                    ])
                    ->one();

        if($task) {
            if($task->status == Task::STATUS_RUN) {
                $task->status = Task::STATUS_PAUSE;
                if($task->save()) {
                    return $this->renderAjax();
                } else {
                    return $this->renderAjaxError();
                }
            } else {
                return $this->renderAjaxError();
            }
        } else {
            return $this->renderAjaxError();
        }
    }

    public function actionResume() {
        $taskId = Yii::$app->request->post('id');

        $task = Task::find()
                    ->where([
                        'id' => $taskId,
                        'uid' => Yii::$app->user->id
                    ])
                    ->one();

        if($task) {
            if($task->status == Task::STATUS_PAUSE) {
                $task->status = Task::STATUS_RUN;
                if($task->save()) {
                    return $this->renderAjax();
                } else {
                    return $this->renderAjaxError();
                }
            } else {
                return $this->renderAjaxError();
            }
        } else {
            return $this->renderAjaxError();
        }
    }

    public function actionDelete() {
        $taskId = Yii::$app->request->post('id');

        $task = Task::find()
                    ->where([
                        'id' => $taskId,
                        'uid' => Yii::$app->user->id
                    ])
                    ->one();

        if($task) {
            $task->status = Task::STATUS_DELETE;
            if($task->save()) {
                return $this->renderAjax();
            } else {
                return $this->renderAjaxError();
            }
        } else {
            return $this->renderAjaxError();
        }
    }

    public function actionView() {
        $taskId = Yii::$app->request->get('id');

        $task = Task::find()
            ->where([
                'id' => $taskId,
                'uid' => Yii::$app->user->id
            ])
            ->asArray()
            ->one();

        if($task) {
            return $this->renderAjax($task);
        } else {
            return $this->renderAjaxError();
        }
    }
    // 单次一次
    public function actionRunone() {
        if(Yii::$app->request->isPost) {
            $id = Yii::$app->request->post('id');

            if(!$id) {
                return $this->renderAjaxError(5);
            }

            $task = Task::find()
                ->where([
                    'uid' => Yii::$app->user->id,
                    'id' => $id
                ])
                ->with('model')
                ->one();

            if(!$task) {
                return $this->renderAjaxError(3, '找不到id为'.$id.'的任务！');
            }

            $taskCode = SandBox::generateCode($task->model->code, $task->data);
            $result = SandBox::execute($taskCode);

            $schedule = new Schedule();
            $schedule->uid = $task['uid'];
            $schedule->tid = $task['id'];
            $schedule->mid = $task['mid'];
            $schedule->status = $result['code'] == 0 ? Schedule::STATUS_SUCCESS : Schedule::STATUS_FAIL;

            if($result['code'] == 0) {
                $msg = '';
            } else {
                $msg = $result['msg'] ? $result['msg'] : '';
            }

            $schedule->result = $msg;
            $schedule->save();

            return $this->renderAjax($result);
        } else {
            return $this->renderAjaxError();
        }
    }
}