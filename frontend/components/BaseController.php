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
            echo $this->renderAjaxError(-1);
            exit;
        }
    }

    public function renderAjax($params = [], $code = 0, $message = '') {
        return parent::renderAjax('@app/views/layouts/ajax', [
            'code' => $code,
            'data' => $params,
            'msg' => $message
        ]);
    }

    public function renderAjaxError($code = -2, $message = '') {
        return $this->renderAjax([], $code, $message);
    }

    public function renderAjaxFormError($model) {
        return $this->renderAjax($model->getErrors(), 2);
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