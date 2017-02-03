<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\Task;
use common\components\SandBox;
use common\models\Schedule;
use common\models\LogCrontab;

class TaskController extends Controller {
    // 根据当前时间获取可用频率范围
    private function getFrequencyByHour() {
        $hour = intval(date('H'));

        $frequency = Task::FREQUENCY;
        $result = [];

        foreach ($frequency as $times) {
            if($hour % $times == 0) {
                array_push($result, Task::FREQUENCY_INTERVAL[$times]);
            }
        }

        return $result;
    }
    // 每小时执行一次，排出需要执行的任务
    public function actionSchedule() {
        $frequency = $this->getFrequencyByHour();

        $all = Task::find()
            ->where([
                'status' => Task::STATUS_RUN,
                'frequency' => $frequency
            ])
            ->asArray()
            ->all();

        foreach ($all as $task) {
            $schedule = new Schedule();

            $schedule->uid = $task['uid'];
            $schedule->tid = $task['id'];
            $schedule->mid = $task['mid'];
            $schedule->status = Schedule::STATUS_UNRUN;
            $schedule->schedule_time = date('Y-m-d H:i:s');
            $schedule->result = '';

            $schedule->save();
        }
    }
    // 每5分钟执行一次
    public function actionRun() {
        $all = Schedule::find()
                ->where([
                    'status' => [Schedule::STATUS_UNRUN, Schedule::STATUS_RETRY_UNRUN]
                ])
                ->andWhere([
                    '<=', 'schedule_time', date('Y-m-d H:i:s')
                ])
                ->with(['task', 'model'])
                ->limit(100)
                ->all();

        $failTimes = 0;

        foreach ($all as $schedule) {
            $task = $schedule->task;
            $model = $schedule->model;
            $code = $model->code;

            $taskCode = SandBox::generateCode($code, $task->data);
            $result = SandBox::execute($taskCode);

            if($result['code'] == 0) {
                $correct = true;
                $msg = '';
            } else {
                $correct = false;
                $msg = $result['msg'] ? $result['msg'] : '';
            }

            if(!$correct) {
                $failTimes++;
            }

            if($schedule['times'] < $task['retry']) {
                $schedule->status = Schedule::STATUS_RETRY_UNRUN;
                $schedule->schedule_time = date('Y-m-d H:i:s',strtotime("+30 minute"));
                $schedule->times += 1;
            } else {
                $schedule->status = $correct ? Schedule::STATUS_SUCCESS : Schedule::STATUS_FAIL;
            }
            $schedule->result = $msg;
            $schedule->save();
        }

        if(count($all) > 0) {
            $log = new LogCrontab();
            $log->times = count($all);
            $log->fail_times = $failTimes;
            $log->save();
        }
    }
    // 邮件汇总通知，每日9，18点通知一次
    public function actionNotice($during) {

        $yesterday = date('Y-m-d 18:00:00', strtotime('-1 day'));
        $todayAM = date('Y-m-d 9:00:00');
        $todayPM = date('Y-m-d 18:00:00');

        if($during == 'am') {
            $startTime = $yesterday;
            $endTime = $todayAM;
        } else if($during == 'pm') {
            $startTime = $todayAM;
            $endTime = $todayPM;
        } else {
            return;
        }

        $failSchedule = Schedule::find()
            ->where([
                'status' => Schedule::STATUS_FAIL
            ])
            ->andWhere(['>', 'create_time', $startTime])
            ->andWhere(['<=', 'create_time', $endTime])
            ->with('user')
            ->with('model')
            ->orderBy('create_time desc');

        $result = $failSchedule->asArray()->all();

        $info = [];

        foreach ($result as $item) {
            if(!array_key_exists($item['uid'], $info)) {
                $info[$item['uid']] = [
                    'user' => $item['user'],
                    'result' => []
                ];
            }

            $info[$item['uid']]['result'][] = [
                'mid' => $item['model']['id'],
                'tid' => $item['tid'],
                'mname' => $item['model']['name'],
                'create_time' => $item['create_time'],
                'result' => $item['result']
            ];
        }

        foreach ($info as $item) {
            $result = Yii::$app->mailer->compose('summary', $item)
                ->setFrom(['task_auto@163.com' => '自动任务系统'])
                ->setTo($item['user']['email'])
                ->setSubject('失败任务汇总')
                ->send();

            if($result) {
                Yii::error('send mail:'.$result);
            }
        }

        return 0;
    }
}