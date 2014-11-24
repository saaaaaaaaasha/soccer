<?php

class ParseCommand extends CConsoleCommand
{
    /*public function run($args) {
    //Yii::app()->cache->flush();
    //echo 'The cache is cleared' . PHP_EOL;
        $model = new SoccerCountry;

        $model->name="kakashka";
        $model->image="kakashka";
        if (!$model->save())
            print_r($model->getErrors());
        echo "eeeehy";
    }*/

    public function actionToday($args){
        Parser::Today();
    }

    public function actionUpdate($args){
        Parser::Update();
    }
}