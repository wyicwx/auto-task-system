<?php

namespace frontend\controllers;

use yii;
use frontend\components\BaseController;
use frontend\models\PasswordForm;
use frontend\models\ProfileForm;

class UserController extends BaseController {

    public function actionProfile() {
        $form = new ProfileForm();

        if(Yii::$app->request->isPost) {
            $form->load(Yii::$app->request->post(), '');

            if($form->validate()) {
                $identity = Yii::$app->user->identity;

                $identity->nickname = Yii::$app->request->post('nickname');
                $identity->email = Yii::$app->request->post('email');
                $identity->save();

                return 'success';
            }
        } else {
            $form->load(Yii::$app->user->identity->attributes, '');
        }

        return $this->render('profile', [
            'form' => $form
        ]);
    }

    public function actionPassword() {
        $form = new PasswordForm();
        $form->load(Yii::$app->request->post(), '');

        if(Yii::$app->request->isPost) {
            if($form->validate()) {
                Yii::$app->user->identity->setPassword($form->newpassword);
                Yii::$app->user->identity->save();

                return 'success';
            }
        }

        return $this->render('password', [
            'form' => $form
        ]);
    }

    public function actionView() {
        return $this->render('view', [
            'model' => Yii::$app->user->identity
        ]);
    }
}