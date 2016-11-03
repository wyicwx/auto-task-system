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

    public function renderAjax($params = [], $code = 0, $message = '') {
        return parent::renderAjax('@app/views/layouts/ajax', [
            'code' => $code,
            'data' => $params,
            'msg' => $message
        ]);
    }

    public function renderAjaxList($list, $pages, $data = []) {
        $pages = [
            'page' => (int) $pages->page + 1,
            'total' => (int) $pages->totalCount,
            'perpage' => (int) $pages->pageSize,
            'pageCount' => (int) $pages->pageCount
        ];

        return $this->renderAjax([
            'list' => $list,
            'pages' => $pages
        ]);
    }
}