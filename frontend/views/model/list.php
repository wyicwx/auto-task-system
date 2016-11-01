<?php 

use yii\widgets\LinkPager;
// var_dump($pages);

?>
<div class="row">
    <div class="col-md-12" style="margin-bottom: 10px;">
        <a href="/model/create" class="btn btn-primary">创建模板</a>
    </div>
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>id</th> 
                    <th>名称</th> 
                    <th>描述</th> 
                    <th>状态</th>
                    <th>使用人数</th>
                    <th>操作</th> 
                </tr> 
            </thead> 
            <tbody> 
                <?php foreach ($model as $item) { ?>
                <tr>
                    <th scope="row"><?= $item['id']; ?></th> 
                    <td><?= $item['name']; ?></td> 
                    <td><?= $item['description'] ? $item['description'] : '--'; ?></td>
                    <td><?= $item['status'] === 0 ? '下架' : '上架'; ?></td>
                    <td>--</td>
                    <td>
                        <a href="/task/create?mid=<?= $item['id']; ?>">创建任务</a>
                        <a href="/model/view?id=<?= $item['id']; ?>">查看</a>
                        <a href="/model/update?id=<?= $item['id']; ?>">编辑</a>
                        <a href="javascript:void(0)">删除</a>
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