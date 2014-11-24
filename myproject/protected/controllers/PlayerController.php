<?php

class PlayerController extends Controller
{
    private $_model;
    public function loadModel()
    {
        if($this->_model===null)
        {
            if(isset($_GET['id']))
                $this->_model=SoccerPlayer::model()->findbyPk($_GET['id']);
            if($this->_model===null)
                throw new CHttpException(404,'The requested page does not exist.');
        }
        return $this->_model;
    }

    public function actionView(){
        $model = $this->loadModel();
        $team = SoccerPlayerTeam::model()->find('pid=:team',array('team'=>$model->id));

        $this->render('view',array(
            'model'=>$model,
            'team'=>$team,
        ));
    }

}