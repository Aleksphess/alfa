<?php

namespace app\controllers;

use app\models\Trainers;

class TrainersController extends \app\extentions\BaseController
{
    public function actionIndex()
    {
        return $this->render('index',[
            'trainers' => Trainers::find()->active()->orderBy('sort ASC')->joinWith('info')->all()
        ]);
    }

}
