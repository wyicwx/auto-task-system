<?php 

use yii\widgets\LinkPager;
use common\models\Task;
// var_dump($pages);

?>
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>id</th>
                    <th>模板id</th> 
                    <th>备注</th> 
                    <th>状态</th>
                    <th>运行次数</th>
                    <th>操作</th> 
                </tr>
            </thead> 
            <tbody> 
                <?php foreach ($model as $item) { ?>
                <tr>
                    <th scope="row"><?= $item['id']; ?></th> 
                    <td>
                        <a href="/model/view?id=<?= $item['mid']; ?>" target="_blank"><?= $taskModels[$item['mid']]['name']; ?></a>
                    </td> 
                    <td><?= $item['remark'] ? $item['remark'] : '--'; ?></td>
                    <td><?= $item['status'] == Task::STATUS_RUN ? '<span class="label label-success">运行中</span>' : '<span class="label label-default">已暂停</span>' ?></td>
                    <td>0</td>
                    <td>
                        <?php if($item['status'] == Task::STATUS_RUN) { ?>
                        <a href="javascript:void(0)">暂停</a>
                        <?php } else { ?>
                        <a href="javascript:void(0)">恢复</a>
                        <?php } ?>
                        <a href="/task/update?id=<?= $item['id']; ?>">编辑</a>
                        <a href="javascript:void(0)">删除</a>
                        <a href="/schedule/all?tid=<?= $item['id']; ?>">运行状态</a>
                    </td> 
                </tr> 
                <?php } ?>
            </tbody> 
        </table>
    </div>
    <div class="col-md-12">
        <?= LinkPager::widget(['pagination' => $pages]); ?>
    </div>
</div>