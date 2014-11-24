<?php

class ApiParserController extends Controller
{


    public function actionIndex(){
        $model = new SoccerCountry;

        $model->name="kakashka";
        $model->image="kakashka";
        if (!$model->save())
            print_r($model->getErrors());


        Yii::app()->end();
    }

}