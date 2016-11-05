<?php
namespace frontend\controllers;

use yii;
use frontend\components\BaseController;
use common\models\TaskModel;
use common\models\TaskModelForm;
use yii\data\Pagination;
use common\models\User;
use common\components\SandBox;

class ModelController extends BaseController {
    public function actionCreate() {
        $form = new TaskModelForm();

        if(Yii::$app->request->isPost) {
            $form->load(Yii::$app->request->post(), '');
            $result = $form->add();
            if($result) {
                return $this->renderAjax([
                    'id' => $result->id
                ]);
            } else {
                return $this->renderAjaxFormError($form);
            }
        }
    }

    public function actionView() {
        $id = Yii::$app->request->get('id');

        $model = TaskModel::find()
                    ->where([
                        'id' => $id
                    ])
                    ->with('user')
                    ->asArray()
                    ->one();

        return $this->renderAjax($model);
    }

    public function actionUpdate() {
        if(Yii::$app->request->isPost) {
            $id = Yii::$app->request->post('id');

            $model = TaskModel::find()
                        ->where([
                            'id' => $id,
                            'uid' => Yii::$app->user->id
                        ])
                        ->asArray()
                        ->one();
            
            if(!$model) {
                return $this->renderAjaxError(3);
            }

            $form = new TaskModelForm();
            $form->loadFromDB($model, '');
            $form->load(Yii::$app->request->post(), '');

            if($form->save()) {
                return $this->renderAjax();
            } else {
                return $this->renderAjaxFormError($form);
            }
        }
    }

    public function actionDelete() {
        if(!Yii::$app->request->isPost) {
            return $this->renderAjaxError();
        }

        $id = Yii::$app->request->post('id');

        $taskModelAR = TaskModel::find()
                    ->where([
                        'uid' => Yii::$app->user->id,
                        'id' => $id
                    ])
                    ->one();

        $taskModelAR->status = -1;

        if($taskModelAR->save()) {
            return $this->renderAjax();
        } else {
            return $this->renderAjaxError(1);
        }
    }

    public function actionList() {
        $isMarket = Yii::$app->request->get('market');

        $listAR = TaskModel::find()
                    ->where([
                        'uid' => Yii::$app->user->id
                    ]);

        if($isMarket) {   
            $listAR = $listAR->andWhere([
                'status' => TaskModel::STATUS_PUBLIC
            ])
            ->with('user');
        } else {
            $listAR = $listAR->andWhere(['!=', 'status', TaskModel::STATUS_DELETE]);
        }

        $pages = new Pagination(['totalCount' => $listAR->count()]);

        $list = $listAR->limit($pages->limit)
                    ->offset($pages->offset)
                    ->asArray()
                    ->all();

        return $this->renderAjaxList($list, $pages);
    }

    public function actionPublish() {
        if(Yii::$app->request->isPost) {
            $id = Yii::$app->request->post('id');

            $taskModelAR = TaskModel::find()
                ->where([
                    'id' => $id,
                    'status' => TaskModel::STATUS_PRIVATE,
                    'uid' => Yii::$app->user->id
                ])
                ->one();

            if($taskModelAR) {
                $taskModelAR->status = TaskModel::STATUS_PUBLIC;

                if($taskModelAR->save()) {
                    return $this->renderAjax();
                } else {
                    return $this->renderAjaxError();
                }
            } else {
                return $this->renderAjaxError();
            }
        } else {
            return $this->renderAjaxError();
        }
    }

    public function actionPrivate() {
        if(Yii::$app->request->isPost) {
            $id = Yii::$app->request->post('id');

            $taskModelAR = TaskModel::find()
                ->where([
                    'id' => $id,
                    'status' => TaskModel::STATUS_PUBLIC,
                    'uid' => Yii::$app->user->id
                ])
                ->one();

            if($taskModelAR) {
                $taskModelAR->status = TaskModel::STATUS_PRIVATE;

                if($taskModelAR->save()) {
                    return $this->renderAjax();
                } else {
                    return $this->renderAjaxError();
                }
            } else {
                return $this->renderAjaxError();
            }
        } else {
            return $this->renderAjaxError();
        }
    }

    public function actionChecksyntax() {
        if(Yii::$app->request->isPost) {
            $code = Yii::$app->request->post('code');

            if(SandBox::checkSyntax($code)) {
                return $this->renderAjaxError(4);
            } else {
                return $this->renderAjax();
            }
        }
    }
}
