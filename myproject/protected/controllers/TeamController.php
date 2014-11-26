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
    public function actionIndex(){

        $this->render('index');
    }
    public function actionView(){
        $model = $this->loadModel();

        $players = SoccerPlayerTeam::model()->findAll('tid=:team',array('team'=>$model->id));
        $coach = SoccerCoachTeam::model()->find('tid=:team',array('team'=>$model->id));
        $stadium = SoccerStadiumTeam::model()->find('tid=:team',array('team'=>$model->id));
        $stats = SoccerMatch::getTeamStats($model->id);
        $place = SoccerMatch::getTable($model->id,38,true);
        $lastgames = SoccerMatch::getLastMatch($model->id);
        $nextgames = SoccerMatch::getNextMatch($model->id);

        $statsforchars = SoccerMatch::getStatsForChars($model->id);

        $this->render('view',array(
            'model'=>$model,
            'players'=>$players,
            'coach'=>$coach,
            'stadium'=>$stadium,
            'stats'=>$stats,
            'place'=>$place,
            'lastgames'=>$lastgames,
            'nextgames'=>$nextgames,
            'statsforchars'=>$statsforchars,
        ));
    }

}