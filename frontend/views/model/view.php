<?php
use yii\helpers\Html;
?>
<div class="row">
    <div class="col-md-12">
        <div class="row form-group">
            <div class="col-md-1">
                <label>模板名称</label>
            </div>
            <div class="col-md-5">
                <input type="text" name="name" class="form-control" value="<?php echo $model->name; ?>" readonly>
            </div>
        </div>
    
        <div class="row form-group">
            <div class="col-md-1">
                <label>描述</label>
            </div>
            <div class="col-md-5">
                <textarea type="text" name="description" class="form-control" style="resize: none;" readonly><?php echo $model->description; ?></textarea>
            </div>
        </div>

        <div class="row">
            <div class="col-md-1">
                <label>                
                    数据类型
                </label>
            </div>
            <div class="col-md-8">
                <?php 
                    $dataType = json_decode($model->datatype, true);

                    foreach ($dataType as $item) {
                ?>
                <div class="row form-group">
                    <div class="col-md-4">
                        <input type="text" class="form-control" readonly value="<?= $item['name']; ?>">
                    </div>
                    <div class="col-md-2">
                        <?= $item['type']; ?>
                    </div>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-1">                
                <label>
                    代码
                </label>
            </div>
            <div class="col-md-11">
                <div style="border: 1px solid #ccc;border-radius: 4px;overflow: hidden;">
                    <textarea id="codeEditor" name="code" rows="4" cols="100" style="border: none;resize: none;"><?php echo Html::encode($model->code); ?></textarea>
                </div>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-1">                
                <label>
                    维护者
                </label>
            </div>
            <div class="col-md-11">
                <?= $maintainer->nickname; ?>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-1">                
                <label>
                    更新日期
                </label>
            </div>
            <div class="col-md-11">
                <?= $maintainer->update_time; ?>
            </div>
        </div>
    </div>    
</div>

<?php
$this->registerCssFile("/codemirror/codemirror.css");
$this->registerCss(".CodeMirror {height: auto}");
$this->registerJsFile("/codemirror/codemirror.js");
$this->registerJsFile("/codemirror/mode/clike/clike.js");
$this->registerJsFile("/codemirror/mode/php/php.js");
$this->registerJsFile("/codemirror/addon/edit/matchbrackets.js");
$this->registerJs("
    var codeMirror = CodeMirror.fromTextArea(document.getElementById('codeEditor'), {
        mode: 'text/x-php',
        lineNumbers: true,
        indentUnit: 4,
        indentWithTabs: false,
        matchBrackets: true,
        viewportMargin: Infinity,
        lineWrapping: true,
        readOnly: true
    });
");
?>