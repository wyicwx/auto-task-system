<?php
use yii\helpers\Html;
use common\models\Task;
?>

<div class="row">
    <div class="col-md-12">
        <?php if($model->hasErrors()) {
            echo Html::errorSummary($model, [
                'class' => 'error-summary'
            ]);
        } ?>
    </div>

    <div class="col-md-12">
        <?php if($model->id) { ?>
        <form action="/task/update?id=<?= $model->id; ?>" method="post">
        <?php } else { ?>
        <form action="/task/create?mid=<?= $task->id; ?>" method="post">
        <?php } ?>
            <input type="hidden" name="<?=Yii::$app->request->csrfParam; ?>" value="<?=Yii::$app->request->getCsrfToken() ?>">

            <div class="row form-group">
                <div class="col-md-1">
                    <label>模板名称</label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" value="<?php echo $task->name; ?>" readonly="readonly">
                </div>
            </div>

            <div class="row form-group">
                <div class="col-md-1">
                    <label>模板描述</label>
                </div>
                <div class="col-md-8">
                    <textarea class="form-control" readonly="readonly"><?php echo $task->name; ?></textarea>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-md-1">
                    <label>执行频率</label>
                </div>
                
                <div class="col-md-2">
                    <select name="frequency" class="form-control" value="<?= $model['frequency']; ?>">
                    <?php
                        $options = Task::FREQUENCY;

                        foreach ($options as $value) {
                    ?>
                        <option value="<?= $value; ?>" <?php if($model['frequency'] == $value) { ?>selected="selected"<?php } ?> ><?= $value; ?></option>
                    <?php
                        }
                    ?>
                    </select>
                </div>

                <div class="col-md-2">
                    小时执行一次/天
                </div>
            </div>

            <div class="row form-group">
                <div class="col-md-1">
                    <label>运行数据</label>
                </div>
                <div class="col-md-8">
                    <?php 
                        $datatype = json_decode($task->datatype);

                        foreach ($datatype as $item) {
                    ?>
                    <div class="input-group" style="margin-bottom: 10px;">
                        <span class="input-group-addon" style="min-width: 120px;text-align: left;"><?= $item->name; ?></span>
                        <input name="data[<?= $item->name; ?>]" type="text" class="form-control" value="<?= empty($model['data'][$item->name]) ? '' : $model['data'][$item->name] ?>">
                    </div>
                    <?php
                        }
                    ?>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-md-1">
                    <label>备注</label>
                </div>
                <div class="col-md-8">
                    <textarea name="remark" class="form-control"><?= $model['remark']; ?></textarea>
                </div>
            </div>

            <div class="row">
                <div class="col-md-offset-1">
                    <button type="submit" class="btn btn-primary">保存</button>
                </div>
            </div>
        </form>
    </div>
</div>