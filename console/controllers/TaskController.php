<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\Task;
use PHPSandbox\PHPSandbox;
use Requests;
use common\models\Schedule;

class TaskController extends Controller {
    // 根据当前时间获取可用频率范围
    private function getFrequencyByHour() {
        $hour = intval(date('H'));
        $frequency = Task::FREQUENCY;
        $result = [];

        foreach ($frequency as $times) {
            if($hour % $times == 0) {
                array_push($result, $times);
            }
        }

        return $result;
    }
    
    public function actionRun() {
        $frequency = $this->getFrequencyByHour();

        $all = Task::find()->where([
            'status' => 1,
            'frequency' => $frequency
        ])->with('model')->asArray()->all();

        foreach ($all as $task) {
            $code = $task['model']['code'];
            $data = json_decode($task['data'], true);

            ob_start();

            foreach ($data as $key => $value) {
                echo '$'.$key.' = \''.$value.'\';';
            }

            echo $code;

            $taskCode = ob_get_contents();
            ob_end_clean();

            $sandbox = new PHPSandbox();
            $sandbox->whitelistFunc([
                'rand',
                'json_decode',
                'json_encode'
            ]);
            $sandbox->whitelistClass([
                'Requests'
            ]);
            ob_start();

            try {
                $result = $sandbox->execute($taskCode);
            } catch(Exception $e) {
                $result = [
                    'code' => -2,
                    'msg' => '执行报错！'
                ];
            }

            ob_end_clean();

            $correct = false;
            $msg = '';

            if(!is_array($result)) {
                if($result) {
                    $correct = true; 
                }
            } else {
                if(array_key_exists('code', $result)) {
                    if($result['code'] == 0) {
                        $correct = true;
                    }
                }
                if(array_key_exists('msg', $result)) {
                    $msg = $result['msg'];
                }
            }

            $schedule = new Schedule();

            $schedule->uid = $task['uid'];
            $schedule->tid = $task['id'];
            $schedule->mid = $task['model']['id'];
            $schedule->status = $correct ? 0 : 1;
            $schedule->result = $msg;

            $schedule->save();
        }
    }
}