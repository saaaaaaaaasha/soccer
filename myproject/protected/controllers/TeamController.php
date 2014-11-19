<?php

class TeamController extends Controller
{
    private $_model;
    public function loadModel()
    {
        if($this->_model===null)
        {
            if(isset($_GET['id']))
                $this->_model=SoccerTeam::model()->findbyPk($_GET['id']);
            if($this->_model===null)
                throw new CHttpException(404,'The requested page does not exist.');
        }
        return $this->_model;
    }

    public function actionView(){
        $model = $this->loadModel();

        $players = SoccerPlayerTeam::model()->findAll('tid=:team',array('team'=>$model->id));
        $this->render('view',array(
            'model'=>$model,
            'players'=>$players,
        ));
    }

}