<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Dropdown;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>自动任务平台</title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    // NavBar::begin([
    //     'brandLabel' => '自动任务平台',
    //     'brandUrl' => Yii::$app->homeUrl,
    //     'options' => [
    //         'class' => 'navbar-inverse navbar-fixed-top',
    //     ],
    // ]);

    // if(!Yii::$app->user->isGuest) {
    //     $menuItems = [
    //         ['label' => '我的模板', 'url' => ['/model/list']],
    //         ['label' => '我的任务', 'url' => ['/task/list']],
    //         ['label' => '任务状况', 'url' => ['/schedule/all']]
    //     ];
    // }
    // if (Yii::$app->user->isGuest) {
    //     $menuItems[] = ['label' => '登录', 'url' => ['/site/login']];
    // } else {
    //     $menuItems[] = '<li class="dropdown">'
    //         . '<a href="javascript:void(0)" data-toggle="dropdown" class="dropdown-toggle">'.Yii::$app->user->identity->nickname.'<b class="caret"></b></a>'
    //         . Dropdown::widget([
    //             'items' => [
    //                 ['label' => '修改资料', 'url' => '/user/profile'],
    //                 ['label' => '修改密码', 'url' => '/user/password'],
    //                 ['label' => '退出', 'url' => '/site/logout']
    //             ],
    //         ])
    //         . '</li>';
    // }
    // echo Nav::widget([
    //     'options' => ['class' => 'navbar-nav navbar-right'],
    //     'items' => $menuItems,
    // ]);
    // NavBar::end();
    ?>
    <div class="container">    
        <?= $content ?>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>