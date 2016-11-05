<?php

namespace common\components;

use PHPSandbox\PHPSandbox;
use Requests;

class SandBox {
    const WHITE_LIST_FUNC = [
        'rand',
        'json_decode',
        'json_encode'
    ];
    static function checkSyntax($code) {
        $sandbox = new PHPSandbox();
        $sandbox->setValidationErrorHandler(function($error) {
            return $error->getMessage();
        });
        $sandbox->whitelistFunc(static::WHITE_LIST_FUNC);
        $sandbox->whitelistClass([
            'Requests'
        ]);

        $sandbox->validate($code);

        $error = $sandbox->getLastValidationError();

        if($error) {
            if($error->getMessage() == 'Could not parse sandboxed code!') {
                return '语法错误！';
            }
            return $error->getMessage();
        }
    }
}