<?php

namespace frontend\components;

use yii;
use yii\web\Controller;

class BaseController extends Controller {
    public $layout = 'common';
    public $authorize = true;

    public function init() {
        parent::init();

        if($this->authorize) {
            $this->checkLoginStatus();
        }
    }

    protected function checkLoginStatus() {
        if(Yii::$app->user->isGuest) {
             $this->redirect('/site/login');
        }
    }
}