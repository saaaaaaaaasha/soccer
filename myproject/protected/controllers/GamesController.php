<?php

class GamesController extends Controller
{
    private $_model;
    public function loadModel()
    {
        if($this->_model===null)
        {
            if(isset($_GET['id']))
                $this->_model=SoccerMatch::model()->findbyPk($_GET['id']);
            if($this->_model===null)
                throw new CHttpException(404,'The requested page does not exist.');
        }
        return $this->_model;
    }

    public function actionView(){
        $model = $this->loadModel();
        $events=SoccerMatchEvent::model()->findAll(array('order'=>'minute', 'condition'=>'match_id=:id', 'params'=>array(':id'=>$model->id)));

           // ('match_id=:id',array('id'=>$model->id),array('order'=>'somefieldfield'));

        //$players = SoccerPlayerTeam::model()->findAll('tid=:team',array('team'=>$model->id));
        $this->render('view',array(
            'model'=>$model,
            'events'=>$events,
            //'players'=>$players,
        ));
    }

}