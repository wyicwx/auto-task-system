<?php
namespace frontend\controllers;

use yii;
use frontend\components\BaseController;
use common\models\TaskModel;
use common\models\TaskForm;
use common\models\Task;
use yii\data\Pagination;

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
                    ->andWhere(['!=', 'status', Task::STATUS_DELETE]);

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
}