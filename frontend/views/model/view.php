<div class="row">
    <div>
        <div class="col-md-2">
            模板名称
        </div>
        <div class="col-md-10">
            <?= $model->name; ?>
        </div>
    </div>

    <div>
        <div class="col-md-2">
            描述
        </div>
        <div class="col-md-10">
            <?= $model->description; ?>
        </div>
    </div>

    <div>
        <div class="col-md-2">
            代码
        </div>
        <div class="col-md-10">
            <?= $model->code; ?>
        </div>
    </div>
    
    <div>
        <div class="col-md-2">
            维护者
        </div>
        <div class="col-md-10">
            <?= $maintainer->nickname; ?>
        </div>
    </div>

    
</div>