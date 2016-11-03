<?php
$code_message = [
    '0' => '成功',
];

$result = [
    'code' => intval($code),
    'data' => $data,
    'msg' => $msg ? $msg : $code_message[$code]
];

echo json_encode($result);
?>
