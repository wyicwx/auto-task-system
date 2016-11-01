<?php 

use yii\widgets\LinkPager;
// var_dump($pages);

?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">        
            <div class="panel-heading">
                目前可用任务模板：
            </div>
            <div class="panel-body">            
                <table class="table table-hover table-border">
                    <thead>
                        <tr>
                            <th>模板名称</th>
                            <th>描述</th>
                            <th>使用人数</th>
                            <th>操作</th>
                        </tr> 
                    </thead>
                    <tbody>
                        <?php foreach ($model as $item) { ?>
                        <tr>
                            <td><?= $item['name']; ?></td> 
                            <td><?= $item['description'] ? $item['description'] : '--'; ?></td>
                            <td>--</td>
                            <td>
                                <a href="/model/view?id=<?= $item['id']; ?>">查看</a>
                                <a href="/task/create?mid=<?= $item['id']; ?>">创建任务</a>
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