<?php 
namespace frontend\controllers;

use yii;
use frontend\components\BaseController;
use common\models\TaskModel;
use yii\data\Pagination;

class MainController extends BaseController {
    public $defaultAction = 'home';

    public function actionHome() {
        $limit = 10;
        $list = TaskModel::getTaskModelList(null, true);
        $model = $list->limit($limit)->all();
        $pages = new Pagination(['totalCount' => $list->count(), 'pageSize' => $limit]);

        return $this->render('home', [
            'pages' => $pages,
            'model' => $model
        ]);
    }
}