<?php

class StadiumController extends Controller
{

    private $_model;
    public function loadModel()
    {
        if($this->_model===null)
        {
            if(isset($_GET['id']))
                $this->_model=SoccerStadium::model()->findbyPk($_GET['id']);
            if($this->_model===null)
                throw new CHttpException(404,'The requested page does not exist.');
        }
        return $this->_model;
    }


    public function actionView(){
        $model = $this->loadModel();

        $teams = SoccerStadiumTeam::model()->find('sid=:stadium',array('stadium'=>$model->id));
        $team = SoccerTeam::model()->find('id=:id',array('id'=>$teams->tid));
        $lastgames = SoccerMatch::getLastMatch($model->id,10,38,$model->id);


        $this->render('view',array(
            'model'=>$model,
            'team'=>$team,
            'lastgames'=>$lastgames,
        ));
    }
}