<?php

namespace common\components;

use PHPSandbox\PHPSandbox;
use Requests;

class SandBox {
    const WHITE_LIST_FUNC = [
        'rand',
        'json_decode',
        'json_encode',
        'preg_match',
        'urlencode',
        'urldecode'
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
        $sandbox->setErrorHandler(function($error) {
            var_dump($error);
        });
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

        if(!is_array($result)) {
            $result = [
                'code' => -3,
                'msg' => '无返回结果！'
            ];
        } else {
            if(!array_key_exists('code', $result)) {
                $result = [
                    'code' => -3,
                    'msg' => '无返回结果！'
                ];
            }

            if(!array_key_exists('msg', $result)) {
                $result['msg'] = '';
            }
        }


        return $result;
    }

    static function generateCode($code, $data) {
        if(!is_array($data)) {
            $data = json_decode($data, true);
        }

        ob_start();
        echo 'try {';

        foreach ($data as $key => $value) {
            echo '$'.$key.' = \''.$value.'\';';
        }

        echo $code;

        echo '} catch(Exception $error) {
                return [
                    "code" => -3,
                    "msg" => "执行报错：".$error->getMessage()
                ];
            }';

        $taskCode = ob_get_contents();
        ob_end_clean();

        return $taskCode;
    }
}