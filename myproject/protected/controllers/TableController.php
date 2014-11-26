<?php

class TableController extends Controller
{
    public $defaultAction = 'index';

    public function actionIndex($macthday=null){



        if (isset($_POST['matchday'])) {
            //echo $_POST['matchday'];
            $result = SoccerMatch::getTable(0,$_POST['matchday'],true);
            $content="";
            for($i=0;$i<count($result['teams']);$i++){
                $content.=$this->renderPartial('_view',array(
                    'team'=>$result['teams'][$i],
                    'stats'=>$result['stats'][$i],
                    'number'=>($i+1),
                    'head'=>true,
                ));
            }
            echo $content;
            //exit();
            Yii::app()->end();
        }
        //echo Yii::app()->request->getParam('macthday');
        //if (isset($_GET['macthday'])) echo "yeye".$_GET['macthday'];
        $result = SoccerMatch::getTable(0,38,true);
        //if (!$macthday) $macthday=38;
        //model()->findAll('tid=:team',array('team'=>$model->id));
        //print_r($result);
        $arraymatchdays=array();
        for($i=1;$i<=38;$i++){
            $arraymatchdays[$i]=$i;
        }

        for($i=0;$i<20;$i++){
            //$arraymatchdays[$i]=$i;
            $teamname[$i]=$result['teams'][$i]->rusname;
            $teamid[$i]=$result['teams'][$i]->id;
        }


        //$listteam=array(0=>array('team'=>'Ливерпуль','id'=>12));
       // $listteam=array('team'=>array('Ливерпуль','Манчестер Юнайтер'),'id'=>array(12,5));

        $listteam=array('team'=>$teamname,'id'=>$teamid);

        $this->render('index',array(
            'result'=>$result,
            'arraymatchdays'=>$arraymatchdays,
            'cmday'=>$result['current'],
            'listteam'=>$listteam,
            )
        );


        /*
        $model = $this->loadModel();

        $players = SoccerPlayerTeam::model()->findAll('tid=:team',array('team'=>$model->id));
        $coach = SoccerCoachTeam::model()->find('tid=:team',array('team'=>$model->id));
        $stadium = SoccerStadiumTeam::model()->find('tid=:team',array('team'=>$model->id));
        $stats = SoccerMatch::getTeamStats($model->id);
        $place = SoccerMatch::getTable($model->id,38,true);
        $lastgames = SoccerMatch::getLastMatch($model->id);
        $nextgames = SoccerMatch::getNextMatch($model->id);

        $this->render('index',array(
            'model'=>$model,
            'players'=>$players,
            'coach'=>$coach,
            'stadium'=>$stadium,
            'stats'=>$stats,
            'place'=>$place,
            'lastgames'=>$lastgames,
            'nextgames'=>$nextgames,
        ));*/
    }

}