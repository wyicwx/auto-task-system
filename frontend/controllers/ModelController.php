<?php
namespace frontend\controllers;

use yii;
use frontend\components\BaseController;
use common\models\TaskModel;
use common\models\TaskModelForm;
use yii\data\Pagination;
use common\models\User;

class ModelController extends BaseController {
    public function actionCreate() {
        $this->checkLoginStatus();

        $model = new TaskModelForm();

        if(Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post(), '');

            if($model->add()) {
                return 'success';
            }
        }

        return $this->render('model', [
            'model' => $model
        ]);
    }

    public function actionView() {
        $id = Yii::$app->request->get('id');

        $model = new TaskModel([
            'id' => $id
        ]);
        $model->refresh();

        $maintainer = new User(['id' => $model->uid]);
        $maintainer->refresh();

        return $this->render('view', [
            'model' => $model,
            'maintainer' => $maintainer
        ]);
    }

    public function actionUpdate() {
        $this->checkLoginStatus();

        $id = Yii::$app->request->get('id');

        $form = new TaskModelForm();

        $model = TaskModel::getTaskModelById($id);
        $form->loadFromDB($model->asArray()->one(), '');

        if(Yii::$app->request->isPost) {
            $form->load(Yii::$app->request->post(), '');

            if($form->save()) {
                return 'success';
            }
        }

        return $this->render('model', [
            'model' => $form
        ]);
    }

    public function actionDelete() {

    }

    public function actionList() {
        $limit = 10;
        $list = TaskModel::getTaskModelList(Yii::$app->user->id);
        $model = $list->limit($limit)->all();
        $pages = new Pagination(['totalCount' => $list->count(), 'pageSize' => $limit]);

        return $this->render('list', [
            'pages' => $pages,
            'model' => $model
        ]);
    }
}