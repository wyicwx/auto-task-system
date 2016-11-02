<?php

use yii\widgets\LinkPager;
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                运行列表
            </div>

            <div class="panel-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>任务id</th> 
                            <th>代码模板</th> 
                            <th>状态</th>
                            <th>执行结果</th>
                            <th>执行时间</th> 
                        </tr> 
                    </thead> 
                    <tbody> 
                        <?php foreach ($list as $item) { ?>
                        <tr>
                            <th scope="row"><?= $item['id']; ?></th> 
                            <td>
                                <?= $item['tid']; ?>
                            </td> 
                            <td>
                                <a href="/model/view?id=<?= $item['mid']; ?>" target="_blank"><?= $item['model']['name']; ?></a>
                            </td>
                            <td>
                                <?= $item['status'] == 0 ? '<span class="label label-success">成功</span>' : '<span class="label label-danger">失败</span>'; ?>
                            </td>
                            <td>
                                <?= $item['status'] == 0 ? '--' : \yii\helpers\HtmlPurifier::process($item['result']) ?>
                            </td>
                            <td>
                                <?= $item['create_time']; ?>
                            </td>
                        </tr> 
                        <?php } ?>
                    </tbody> 
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <?= LinkPager::widget(['pagination' => $pages]); ?>
    </div>
</div>