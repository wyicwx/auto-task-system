<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\Times;
use common\models\TaskModel;
use common\models\Schedule;

class TimesController extends Controller {
    public function actionModel() {

        $models = TaskModel::find()
                    ->select([
                        'id'
                    ])
                    ->where([
                        'status' => TaskModel::STATUS_PUBLIC
                    ])
                    ->with('times')
                    ->all();

        foreach ($models as $model) {
            if(!$model->times) {

                $successTimes = Schedule::find()
                    ->where([
                        'mid' => $model->id,
                        'status' => Schedule::STATUS_SUCCESS
                    ])->count();

                $failTimes = Schedule::find()
                    ->where([
                        'mid' => $model->id,
                        'status' => Schedule::STATUS_FAIL
                    ])->count();

                $times = new Times();
                $times->type = Times::TYPE_MODEL;
                $times->type_id = $model->id;
                $times->positive = $successTimes;
                $times->negative = $failTimes;

                if($times->negative <= 0 && $times->positive <= 0) {
                    $times->ratio = 0;
                } else if($times->negative <= 0) {
                    $times->ratio = 100;
                } else {
                    $ratio = $times->positive / ($times->positive + $times->negative) * 100;
                    $times->ratio = number_format($ratio, 2, '.', '');
                }

                $times->save();
            } else {
                $times = $model->times;

                $successTimes = Schedule::find()
                    ->where([
                        'mid' => $model->id,
                        'status' => Schedule::STATUS_SUCCESS
                    ])
                    ->andWhere([
                        '>', 'update_time', $times->update_time
                    ])->count();

                $failTimes = Schedule::find()
                    ->where([
                        'mid' => $model->id,
                        'status' => Schedule::STATUS_FAIL
                    ])
                    ->andWhere([
                        '>', 'update_time', $times->update_time
                    ])->count();

                $times->positive += $successTimes;
                $times->negative += $failTimes;

                if($times->negative <= 0 && $times->positive <= 0) {
                    $times->ratio = 0;
                } else if($times->negative <= 0) {
                    $times->ratio = 100;
                } else {
                    $ratio = $times->positive / ($times->positive + $times->negative) * 100;
                    $times->ratio = number_format($ratio, 2, '.', '');
                }

                $times->save();
            }
        }
    }
}