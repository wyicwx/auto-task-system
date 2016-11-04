<?php
?>
<ol class="breadcrumb">
    <li>个人中心</li>
</ol>

<div class="row">
    <div class="col-md-2">
        昵称
    </div>
    <div class="col-10">
        <?= $model->nickname; ?>
    </div>

    <div class="col-md-2">
        邮箱
    </div>
    <div class="col-10">
        <?= $model->email; ?>
    </div>

</div>