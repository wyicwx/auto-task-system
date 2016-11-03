<div>
    <?= $user['nickname']; ?>，你好！<br />
    <table>
        <thead>
            <tr>
                <th>执行时间</th>
                <th>代码模板</th>
                <th>执行结果</th>
                <th>其他</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $item) { ?>
            <tr>
                <td>
                    <?= $item['create_time']; ?>
                </td>
                <td>
                    <?= \yii\helpers\Html::encode($item['mname']); ?>
                </td>
                <td>
                    <?= \yii\helpers\Html::encode($item['result']); ?>
                </td>
                <td>
                    <a href="http://task.hexcoo.com/task/update?id=<?= $item['tid']; ?>">修改任务</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>