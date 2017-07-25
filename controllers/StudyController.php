<?php

namespace app\controllers;

use Yii;
use app\models\Shedule;

class StudyController extends \app\extentions\BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionShedule()
    {
        $event = Shedule::find()->joinWith('info')
                ->orderBy('pub_date ASC')
                ->where(['>','pub_date',date('Y-m-d')])
                ->active()
                ->one();
        
        if (empty($event)) {
            $event = Shedule::find()->joinWith('info')
                ->orderBy('pub_date DESC')
                ->active()
                ->one();
        }
        
        return $this->render('shedule',[
            'event' => $event,
            'year' => '-1',
            'month' => '-1',
            'day' => '-1'
        ]);
    }
    
    public function actionEvent($eId)
    {
        $id = substr($eId, 1);
        $event = Shedule::find()->joinWith('info')
                ->where(['id' => addslashes($id)])
                ->active()
                ->one();
        
        if (empty($event)) {
            $event = Shedule::find()->joinWith('info')
                ->orderBy('pub_date DESC')
                ->active()
                ->one();
        }
        
        return $this->render('shedule',[
            'event' => $event,
            'year' => $event->year,
            'month' => $event->month,
            'day' => $event->day
        ]);
    }
    
}
