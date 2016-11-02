<?php
use yii\helpers\Html;
?>
<ol class="breadcrumb">
    <li><a href="/user/view">个人中心</a></li>
    <li class="active">修改密码</li>
</ol>


<h1>修改密码</h1>
<div class="row">
    <div class="col-md-12">
        <?php if($form->hasErrors()) {
            echo Html::errorSummary($form, [
                'class' => 'error-summary'
            ]);
        } ?>
    </div>
    <div class="col-lg-5">
        <form action="/user/password" method="post" role="form">
            <input type="hidden" name="<?=Yii::$app->request->csrfParam; ?>" value="<?=Yii::$app->request->getCsrfToken() ?>">
            <div class="form-group">
                <label class="control-label" for="loginform-password">原密码</label>
                <input type="password" id="loginform-password" class="form-control" name="password" value="<?= $form->password ?>">
            </div>

            <div class="form-group">
                <label class="control-label" for="loginform-newpassword">新密码</label>
                <input type="password" id="loginform-newpassword" class="form-control" name="newpassword" value="<?= $form->newpassword ?>">
            </div>

            <div class="form-group">
                <label class="control-label" for="loginform-repassword">重复密码</label>
                <input type="password" id="loginform-repassword" class="form-control" name="repassword" value="<?= $form->repassword ?>">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">保存</button>
            </div>
        </form>        
    </div>
</div>