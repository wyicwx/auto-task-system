<?php

namespace frontend\controllers;

use yii;
use frontend\components\BaseController;
use common\models\Schedule;
use yii\data\Pagination;

class ScheduleController extends BaseController {
    public function actionList() {
        $uid = Yii::$app->user->id;
        $tid = Yii::$app->request->get('tid');

        $where = [
            'uid' => $uid
        ];

        if($tid) {
            $where['tid'] = $tid;
        }

        $scheduleList = Schedule::find()
            ->where($where);

        $pages = new Pagination(['totalCount' => $scheduleList->count()]);

        $list = $scheduleList
            ->with(['model', 'task'])
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy('update_time desc')
            ->asArray()
            ->all();

        return $this->renderAjaxList($list, $pages);
    }
}