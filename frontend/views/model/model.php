<?php 
use yii\helpers\Html;
?>

<ol class="breadcrumb">
    <li><a href="/model/list">我的模板</a></li>
    <?php if($model->id) { ?>
    <li class="active">编辑模板</li>
    <?php } else { ?>
    <li class="active">创建模板</li>
    <?php } ?>
</ol>

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
        <form action="/model/update?id=<?= $model->id; ?>" method="post">
        <?php } else { ?>
        <form action="/model/create" method="post">
        <?php } ?>
            <input type="hidden" name="<?=Yii::$app->request->csrfParam; ?>" value="<?=Yii::$app->request->getCsrfToken() ?>">

            <div class="row form-group">
                <div class="col-md-1">
                    <label>任务名</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="name" class="form-control" value="<?php echo $model->name; ?>">
                </div>
            </div>

            <div class="row form-group">
                <div class="col-md-1">
                    <label>描述</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="description" class="form-control" value="<?php echo $model->description; ?>">
                </div>
            </div>

            <div class="row form-group">
                <div class="col-md-1">                
                    <label>
                        代码
                    </label>
                </div>
                <div class="col-md-8">
                    <textarea class="form-control" name="code" rows="4" cols="100"><?php echo $model->code; ?></textarea>
                </div>
                <div class="col-md-3">
                    <div>
                        1、执行上下文提供 <a href="https://github.com/rmccue/Requests" target="_blank">Requests</a> 对象，用来发起http请求！文档地址 <a href="http://requests.ryanmccue.info/api/class-Requests.html">这里</a>
                    </div><br>
                    <div>
                        2、数据类型可以直接作为变量使用，如定义了名为cookie的数据类型，可直接在代码中使用$cookie
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-1">
                    数据类型
                </div>
                <div class="col-md-8">
                    <?php foreach ($model->datatype_name as $key => $name) { ?>
                    <div class="row j_datatype_template form-group">
                        <div class="col-md-4">
                            <input name="datatype_name[]" type="text" class="form-control" value="<?php echo $name; ?>" <?php if($model->id) { ?>disabled="disabled"<?php } ?>>
                        </div>

                        <div class="col-md-2">
                            <select name="datatype_type[]" class="form-control" <?php if($model->id) { ?>disabled="disabled"<?php } ?> >
                                <option value="string" <?php if($model->datatype_type[$key] == 'string') { ?>selected="selected"<?php } ?> >String</option>
                                <option value="number" <?php if($model->datatype_type[$key] == 'number') { ?>selected="selected"<?php } ?> >Number</option>
                            </select>
                        </div>
                        <?php if(!$model->id) { ?>
                        <div class="col-md-3">
                            <a href="javascript:void(0)" class="j_plus btn btn-info">增加</a>
                            <a href="javascript:void(0)" class="j_minus btn btn-danger">删除</a>
                        </div>
                        <?php } ?>
                    </div>
                    <?php } ?>
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

<?php
$this->registerJs("
    $('body').delegate('.j_plus', 'click', function(e) {
        var target = $(e.currentTarget);
        var template = $('.j_datatype_template').prop('outerHTML');
        var dom = $(template);

        dom.find('input').val('');

        target.closest('.j_datatype_template').after(dom);        
    });

    $('body').delegate('.j_minus', 'click', function(e) {
        var target = $(e.currentTarget);

        if($('.j_datatype_template').length > 1) {
            target.closest('.j_datatype_template').remove();
        } else {
            alert('再删就没了！');
        }
    });

    $('textarea[name=\"code\"]').on('input', function() {
        var code = this.value;
        var matches = code.match(/\\n/g);
        var times = 3;

        if(matches && matches.length > 3) {
            times = matches.length;
        }

        $(this).prop('rows', times+1);
    });
");
?>
</script>