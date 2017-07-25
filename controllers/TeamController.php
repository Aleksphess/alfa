<?php

namespace app\controllers;

use app\models\Team;

class TeamController extends \app\extentions\BaseController
{
    public function actionIndex()
    {
        return $this->render('index',[
            'team' => Team::find()->active()->orderBy('sort ASC')->joinWith('info')->all()
        ]);
    }

}
