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
        $id = Yii::$app->request->post('id');

        $taskModelAR = TaskModel::findOne()
                    ->where([
                        'uid' => Yii::$app->user->id,
                        'id' => $id
                    ]);

        $taskModelAR->status = -1;

        if($taskModelAR->save()) {
            $this->renderAjax();
        } else {
            $this->renderAjax(null, 1);
        }
    }

    public function actionList() {
        $listAR = TaskModel::find()
                    ->where(['uid' => Yii::$app->user->id]);

        $pages = new Pagination(['totalCount' => $listAR->count()]);

        $list = $listAR->limit($pages->limit)
                    ->offset($pages->offset)
                    ->asArray()
                    ->all();

        return $this->renderAjaxList($list, $pages);
    }
}