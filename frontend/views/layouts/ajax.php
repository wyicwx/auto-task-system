<?php
$code_message = [
    '-1' => '未登录',
    '0' => '成功',
    '1' => '数据库保存失败！',
    '2' => '填写的表单项有误',
];

$result = [
    'code' => intval($code),
    'data' => $data,
    'msg' => $msg ? $msg : $code_message[$code]
];

echo json_encode($result);
?>
