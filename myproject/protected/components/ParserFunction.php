<?php

class ParserFunction
{
    public function addNewPlayer($api_id,$api_number,$api_pos,$api_name,$team){

        $model=new SoccerPlayer;
        $model->rusname=$api_name;
        $model->name=$api_name;
        $model->f_api_id=$api_id;
        $model->city="";
        $model->country_id=0;
        $model->birth_day="0000-00-00";
        $model->number=$api_number;
        $model->pos=$api_pos;

        $model->workingleg=0;
        $model->price="";
        $model->photo_img='none.png';

        // print_r($model);

        if(!$model->save())
            print_r($model->getErrors());

        $player=$model->id;

        $model=new SoccerPlayerTeam;
        $model->tid=$team;
        $model->pid=$player;
        $model->date_to="0000-00-00";

        if(!$model->save())
            print_r($model->getErrors());

        return $player;
    }


    public function findPlayerByApiID($id){

        $player= SoccerPlayer::model()->find('f_api_id=:id',array(':id'=>$id));
        if ($player) return $player->id;
        return false;
    }

    public function findPlayerByName($api_name,$api_id,$api_number,$team){
        //$player= SoccerMatch::model()->find('f_api_id=:id',array(':id'=>$api_match_id));
        //$player=$info['commentaries'][0]['comm_match_teams']['visitorteam']['player'][$i];

        $players=SoccerPlayer::model()->findAll();

        for($j=0;$j<count($players);$j++) {
            $res=Text::findMatches($api_name,$players[$j]->name,2);
            if ($api_number===$players[$j]->number) $res+=10;

            //if ($api_id=="57707" && $players[$j]->name=="Gylfi Thór Sigurðsson") echo "RESULT: ".$res;
            //if ($api_id=="209638" && $players[$j]->name=="Michael Keane") echo "RESULT: ".$res;

            if ($res>77) {

                $players[$j]->f_api_id=$api_id;
                $players[$j]->save();
                //if ($api_id=="209638" && $players[$j]->name=="Michael Keane") echo "<br><br><br>YESSSS";
                return $players[$j]->id;

                /*$team=SoccerPlayerTeam::model()->find('pid=:pid AND tid=:tid',array(':pid'=>$players[$j]->id, ':tid'=>$team));
                if ($team) {
                    $players[$j]->f_api_id=$api_id;
                    $players[$j]->save();
                    //if ($api_id=="209638" && $players[$j]->name=="Michael Keane") echo "<br><br><br>YESSSS";
                    return $players[$j]->id;
                }
                else {
                    $otherteam=SoccerPlayerTeam::model()->find('pid=:pid',array(':pid'=>$players[$j]->id));
                    if ($otherteam){

                    }
                    //if ($api_id=="209638" && $players[$j]->name=="Michael Keane") echo "<br><br><br>NOOOO";
                }*/
                //echo $player['name']." == ".$players[$j]->name." -> ".$res."<br>"; break;
            }
        }
        return false;
    }
    public function setTypeOfEvent($api_type,$owngoal,$penalty){

        // echo "-".$api_type."-".$owngoal."-".$penalty;
        if ($api_type=="goals") {
            if ($owngoal=="False" && $penalty=="False") return 1;
            elseif ($owngoal!="False") return 2;
            return 3;
        }
        elseif ($api_type=="yellowcards") {
            return 4;
        }
        elseif ($api_type=="redcards") {
            return 5;
        }
        return -1;
    }

    public function actionAddStats($type,$value, $team, $match_id,$teamI){

        $find= SoccerMatchStats::model()->find('match_id=:match AND team=:team AND type=:type',array(
            ':match'=>$match_id,
            ':team'=>$teamI,
            ':type'=>$type,
        ));

        if(!$find) {
            $model=new SoccerMatchStats();
            $model->match_id=$match_id;
            $model->team=$teamI;
            $model->type=$type;
            $model->valuee=$value;


            if(!$model->save())
                print_r($model->getErrors());

            //print_r($model);
            echo "success adding!<br>";
        }
        else {
            $find->valuee=$value;
            if(!$find->save())
                print_r($find->getErrors());

            //print_r($model);
            //echo "update adding!<br>";
        }
    }

    public function actionAddEvent($event, $api_type, $team, $match_id,$teamI) {


        $api_name=$event['name'];
        $api_id=$event['id'];
        $minute=$event['minute'];
        $owngoal=(isset($event['owngoal']))?$event['owngoal']:"";
        $penalty=(isset($event['penalty']))?$event['penalty']:"";

        $type=$this->setTypeOfEvent($api_type,$owngoal,$penalty);
        //echo "<br><br><br>".$type; exit();
        $player_id=$this->findPlayerByApiID($api_id);
        if (!$player_id) {
            $player_id=$this->findPlayerByName($api_name,$api_id,"",$team);
        }

        //echo "player_id: ".$player_id."<br>";
        //$type="goal";
        //$team=1;

        $find= SoccerMatchEvent::model()->find('match_id=:match AND type=:type AND player_id=:player AND minute=:minute',array(
            ':match'=>$match_id,
            ':type'=>$type,
            ':player'=>$player_id,
            ':minute'=>$minute,
        ));

        if(!$find) {
            $model=new SoccerMatchEvent();
            $model->match_id=$match_id;
            $model->type=$type;
            $model->minute=$minute;
            $model->team=$teamI;
            $model->player_id=$player_id;
            $model->result="";


            if(!$model->save()){
                print_r($model->getErrors()); echo "(event)<br>";
            }

            //print_r($model);
            echo "success adding! (event)";
        }
        //else echo "already exists!";
        //
        //exit();

    }


    public function actionAddPlayerOnField($player_id,$number,$pos,$match_id,$team){

        $find= SoccerMatchTeam::model()->find('match_id=:match AND number=:number AND pos=:pos AND player_id=:player_id',array(
            ':match'=>$match_id,
            ':number'=>$number,
            ':pos'=>$pos,
            ':player_id'=>$player_id,
        ));

        if(!$find) {
            $model=new SoccerMatchTeam();
            $model->match_id=$match_id;
            $model->number=$number;
            $model->pos=$pos;
            $model->player_id=$player_id;
            $model->team=$team;

            if(!$model->save())
            {
                print_r($model->getErrors()); echo "(on field)<br>";
            }

            //print_r($model);
            echo "success adding!<br>";
        }

    }

    public function actionAddPlayerOnSubs($player_id,$number,$pos,$match_id,$team){

        $find= SoccerMatchSub::model()->find('match_id=:match AND number=:number AND pos=:pos AND player_id=:player_id',array(
            ':match'=>$match_id,
            ':number'=>$number,
            ':pos'=>$pos,
            ':player_id'=>$player_id,
        ));

        if(!$find) {
            $model=new SoccerMatchSub();
            $model->match_id=$match_id;
            $model->number=$number;
            $model->pos=$pos;
            $model->player_id=$player_id;
            $model->team=$team;

            if(!$model->save())
            {
                print_r($model->getErrors()); echo "(on subs)<br>";
            }

            //print_r($model);
            echo "success adding!<br>";
        }

    }

    public function actionAddPlayerStats($match_id,$player_id,$pos,$shot_total,$shots_on_goal,$goals,$assists,$offsides,$fouls_drawn,$fouls_commited,$saves,$yellowcards,$redcards,$pen_score,$pen_miss,$team){

        $model= SoccerMatchPlayerStats::model()->find('match_id=:match AND player_id=:player',array(
            ':match'=>$match_id,
            ':player'=>$player_id,
        ));

        if(!$model) {
            $model=new SoccerMatchPlayerStats();
        }

        $model->match_id=$match_id;
        $model->player_id=$player_id;
        $model->pos=$pos;
        $model->shot_total=$shot_total;
        $model->shots_on_goal=$shots_on_goal;
        $model->goals=$goals;
        $model->assists=$assists;
        $model->offsides=$offsides;
        $model->fouls_drawn=$fouls_drawn;
        $model->fouls_commited=$fouls_commited;
        $model->saves=$saves;
        $model->yellowcards=$yellowcards;
        $model->redcards=$redcards;
        $model->pen_score=$pen_score;
        $model->pen_miss=$pen_miss;
        $model->team=$team;


        if(!$model->save())
        {
            print_r($model->getErrors()); echo "(player stats)<br>";
        }

    }



    public function actionAddSubstitutions($on_id,$off_id,$minute,$match_id,$team){

        $find= SoccerMatchSubstitution::model()->find('on_id=:on_id AND off_id=:off_id AND match_id=:match',array(
            ':on_id'=>$on_id,
            ':off_id'=>$off_id,
            ':match'=>$match_id,
        ));

        if(!$find) {
            $model=new SoccerMatchSubstitution();
            $model->match_id=$match_id;
            $model->on_id=$on_id;
            $model->off_id=$off_id;
            $model->minute=$minute;
            $model->team=$team;
            if(!$model->save())
            {
                print_r($model->getErrors()); echo "(substitutions)<br>";
            }

            //print_r($model);
            echo "success adding!<br>";
        }

    }
    public function actionAddCommentaries($minute,$important,$isgoal,$match_id,$comment){
        if ($important=="False") $important=0; else $important=1;
        if ($isgoal=="False") $isgoal=0; else $isgoal=1;
        $minute=substr($minute,0,strlen($minute)-1);
        if ($minute=="") $minute=0;


        $find= SoccerMatchCommentaries::model()->find('minute=:minute AND comment=:comment AND match_id=:match',array(
            ':minute'=>$minute,
            ':comment'=>$comment,
            ':match'=>$match_id,
        ));

        if(!$find) {
            $model=new SoccerMatchCommentaries();
            $model->match_id=$match_id;
            $model->important=$important;
            $model->isgoal=$isgoal;
            $model->comment=$comment;
            $model->minute=$minute;
            //echo $model->minute."<br>";
            if(!$model->save())
                print_r($model->getErrors());

            //print_r($model);
            echo "success adding!<br>";
        }

    }

}