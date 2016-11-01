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
        $limit = 10;
        $list = Task::getTaskList(Yii::$app->user->id);
        $model = $list->limit($limit)->all();
        $pages = new Pagination(['totalCount' => $list->count(), 'pageSize' => $limit]);

        $modelIds = [];

        foreach ($model as $item) {
            array_push($modelIds, $item['mid']);
        }

        $modelIds = array_unique($modelIds);

        $taskModelsResult = TaskModel::getTaskModelListByIds($modelIds)->limit($limit)->all();;

        $taskModels = [];

        foreach ($taskModelsResult as $item) {
            $taskModels[$item['id']] = $item;
        }

        return $this->render('list', [
            'pages' => $pages,
            'model' => $model,
            'taskModels' => $taskModels
        ]);
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