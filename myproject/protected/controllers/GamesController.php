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
        $commentaries=SoccerMatchCommentaries::model()->findAll(array('order'=>'minute DESC', 'condition'=>'match_id=:id', 'params'=>array(':id'=>$model->id)));

        $players_h=SoccerMatchTeam::model()->findAll(array('order'=>'number', 'condition'=>'match_id=:id AND team=1', 'params'=>array(':id'=>$model->id)));
        $players_a=SoccerMatchTeam::model()->findAll(array(/*'order'=>'number', */'limit'=>'11', 'condition'=>'match_id=:id AND team=2', 'params'=>array(':id'=>$model->id)));


        // ('match_id=:id',array('id'=>$model->id),array('order'=>'somefieldfield'));

        //$players = SoccerPlayerTeam::model()->findAll('tid=:team',array('team'=>$model->id));
        $this->render('view',array(
            'model'=>$model,
            'events'=>$events,
            'commentaries'=>$commentaries,
            'players_h'=>$players_h,
            'players_a'=>$players_a,

            //'players'=>$players,
        ));
    }

}