<?php 
namespace frontend\controllers;

use yii;
use frontend\components\BaseController;
use common\models\TaskModel;
use yii\data\Pagination;

class MainController extends BaseController {
    public $defaultAction = 'home';
    public $authorize = false;

    public function actionHome() {
        if(!Yii::$app->user->isGuest) {
            $user = Yii::$app->user->identity->attributes;

            unset($user['password']);
            unset($user['auth_key']);

            return $this->renderPartial('home', [
                'user' => $user
            ]);
        } else {
            $this->redirect('/site/login');
        }
    }
}