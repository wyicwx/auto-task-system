<?php
$code_message = [
    '-3' => '禁止访问',
    '-2' => '服务器错误，请重试！',
    '-1' => '未登录！',
    '0' => '成功',
    '1' => '数据库保存失败！',
    '2' => '填写的表单项有误！',
    '3' => '无数据！',
    '4' => '语法错误！'
];

$result = [
    'code' => intval($code),
    'data' => $data,
    'msg' => $msg ? $msg : $code_message[$code]
];

echo json_encode($result);
?>
