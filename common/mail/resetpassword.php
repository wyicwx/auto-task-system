<div>
    <?= $nickname; ?>，你好！<br />
    <div style="text-indent: 2em">
        您的密码已修改为: <?= $password; ?><br />
        请尽快登录<a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['/']); ?>">自动任务系统</a>修改密码！
    </div>
</div>