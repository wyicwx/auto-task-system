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

                $schedules = Schedule::find()
                    ->where([
                        'mid' => $model->id,
                    ]);

                $successTimes = $schedules->andWhere([
                    'status' => Schedule::STATUS_SUCCESS
                ])->count();

                $failTimes = $schedules->andWhere([
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
                    $times->ratio = $times->positive / $times->negative * 100;
                }

                $times->save();
            } else {
                $times = $model->times;

                $schedules = Schedule::find()
                    ->where([
                        'mid' => $model->id
                    ])
                    ->andWhere([
                        '>', 'update_time', $times->update_time
                    ]);

                $successTimes = $schedules->andWhere([
                    'status' => Schedule::STATUS_SUCCESS
                ])->count();

                $failTimes = $schedules->andWhere([
                    'status' => Schedule::STATUS_FAIL
                ])->count();

                $times->positive += $successTimes;
                $times->negative += $failTimes;

                if($times->negative <= 0 && $times->positive <= 0) {
                    $times->ratio = 0;
                } else if($times->negative <= 0) {
                    $times->ratio = 100;
                } else {
                    $times->ratio = $times->positive / $times->negative * 100;
                }
                $times->save();
            }
        }
    }
}