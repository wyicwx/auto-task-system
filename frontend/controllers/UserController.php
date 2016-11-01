<?php

namespace frontend\controllers;

use frontend\components\BaseController;
use frontend\models\ResetPasswordForm;

class UserController extends BaseController {

    public function actionProfile() {
        return $this->render('profile');
    }

    public function actionPassword() {
        
        $form = new ResetPasswordForm();



        return $this->render('password', [
            'form' => $form
        ]);
    }
}