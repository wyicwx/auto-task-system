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
    static function getSandBox() {
        $sandbox = new PHPSandbox();
        $sandbox->setValidationErrorHandler(function($error) {
            return $error->getMessage();
        });
        $sandbox->whitelistFunc(static::WHITE_LIST_FUNC);
        $sandbox->whitelistClass([
            'Requests'
        ]);

        return $sandbox;
    }

    static function checkSyntax($code) {
        $sandbox = static::getSandBox();

        $sandbox->validate($code);

        $error = $sandbox->getLastValidationError();

        if($error) {
            if($error->getMessage() == 'Could not parse sandboxed code!') {
                return '语法错误！';
            }
            return $error->getMessage();
        }
    }

    static function execute($code) {
        $sandbox = static::getSandBox();

        ob_start();

        try {
            $result = $sandbox->execute($code);
        } catch(Exception $e) {
            $result = [
                'code' => -2,
                'msg' => '执行报错！'
            ];
        }

        ob_end_clean();

        return $result;
    }
}