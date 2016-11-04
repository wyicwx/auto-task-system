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
        $mid = Yii::$app->request->get('mid');

        $taskModel = TaskModel::findOne($mid);
        $model = new TaskForm();

        if(Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post(), '');

            if($model->add($mid)) {
                return 'success';
            }
        }

        return $this->render('task', [
            'task' => $taskModel,
            'model' => $model
        ]);
    }

    public function actionList() {
        $list = Task::find()
                    ->where(['uid' => Yii::$app->user->id]);

        $pages = new Pagination(['totalCount' => $list->count()]);

        $list = $list->limit($pages->limit)
                    ->offset($pages->offset)
                    ->with('model')
                    ->asArray()
                    ->all();

        return $this->renderAjaxList($list, $pages);
    }

    public function actionUpdate() {
        $taskId = Yii::$app->request->get('id');

        $task = Task::findOne($taskId);
        $taskModel = $task->model;

        $model = new TaskForm();
        $model->loadFromDB($task->attributes, '');

        if(Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post(), '');

            if($model->save()) {
                return 'success';
            }
        }

        return $this->render('task', [
            'task' => $taskModel,
            'model' => $model
        ]);
    }
}