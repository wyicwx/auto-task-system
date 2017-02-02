<?php

namespace frontend\controllers;

use yii;
use frontend\components\BaseController;
use frontend\models\RegisterForm;
use common\models\User;
use common\models\LogCrontab;
use yii\data\Pagination;

class AdminController extends BaseController {
    public function init() {
        parent::init();

        if(Yii::$app->user->identity->role !== User::ROLE_ADMIN) {
            echo $this->renderAjaxError(-3);
            exit;
        }
    }

    public function actionRegister() {
        if(Yii::$app->request->isPost) {
            $form = new RegisterForm();
            $form->load(Yii::$app->request->post(), '');

            $form->password = (string) time();

            if($form->register()) {
                $result = Yii::$app->mailer->compose('register', [
                        'form' => $form->attributes
                    ])
                    ->setFrom(['task_auto@163.com' => '自动任务系统'])
                    ->setTo($form->email)
                    ->setSubject('欢迎注册')
                    ->send();

                return $this->renderAjax(); 
            } else {
                return $this->renderAjaxFormError($form);
            }
        } else {
            return $this->renderAjaxError(-3);
        }
    }

    public function actionResetpassword() {
        if(Yii::$app->request->isPost) {
            $user = User::find()
                ->where([
                    'email' => Yii::$app->request->post('email')
                ])
                ->one();

            if($user) {
                $password = (string) time();
                $user->password = md5($password);

                if($user->save()) {
                    $result = Yii::$app->mailer->compose('resetpassword', [
                            'nickname' => $user->nickname,
                            'password' => $password
                        ])
                        ->setFrom(['task_auto@163.com' => '自动任务系统'])
                        ->setTo($user->email)
                        ->setSubject('欢迎注册')
                        ->send();

                    return $this->renderAjax();
                }
            }

            return $this->renderAjaxError();
        } else {
            return $this->renderAjaxError(-3);
        }
    }

    public function actionLogcrontab() {
        $listAR = LogCrontab::find();

        $pages = new Pagination(['totalCount' => $listAR->count()]);

        $list = $listAR->limit(50)
                    ->offset($pages->offset)
                    ->asArray()
                    ->orderBy('created_time desc')
                    ->all();

        return $this->renderAjaxList($list, $pages);
    }
}