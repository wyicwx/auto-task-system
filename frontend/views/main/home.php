<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>自动任务系统</title>
        <script type="text/javascript">
            window.taskUser = <?= json_encode($user); ?>;
        </script>
    </head>
    <body>
        <div id="app"></div>
        <script type="text/javascript" src="<?php echo Yii::$app->urlManager->getScriptUrl(); ?>/app/app.js"></script>
    </body>
</html>