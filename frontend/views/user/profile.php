<?php
use yii\helpers\Html;
?>
<ol class="breadcrumb">
    <li><a href="/user/view">个人中心</a></li>
    <li class="active">修改资料</li>
</ol>


<h1>修改资料</h1>
<div class="row">
    <div class="col-md-12">
        <?php if($form->hasErrors()) {
            echo Html::errorSummary($form, [
                'class' => 'error-summary'
            ]);
        } ?>
    </div>
    <div class="col-lg-5">
        <form action="/user/profile" method="post" role="form">
            <input type="hidden" name="<?=Yii::$app->request->csrfParam; ?>" value="<?=Yii::$app->request->getCsrfToken() ?>">
            <div class="form-group">
                <label class="control-label" for="profileform-nickname">昵称</label>
                <input type="text" id="profileform-nickname" class="form-control" name="nickname" value="<?= $form->nickname ?>">
            </div>

            <div class="form-group">
                <label class="control-label" for="profileform-email">邮箱</label>
                <input type="text" id="profileform-email" class="form-control" name="email" value="<?= $form->email ?>">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">保存</button>
            </div>
        </form>        
    </div>
</div>