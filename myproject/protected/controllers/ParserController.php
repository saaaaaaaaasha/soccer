<?php

class ParserController extends Controller
{

    private $key = '81ff7420-f592-b39e-ed4f909fcc11';

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */

    protected function getCountryID(){
       // return
    }



    /**
     * @property integer $id
     * @property string $name +
     * @property string $rusname +
     * @property integer $country_id +
     * @property string $city +
     *
     * @property string $photo_img +
     * @property string $birth_day +
     * @property string $wiki
     * @property integer $number+
     * @property integer $pos+
     * @property string $posmarket
     * @property string $workingleg
     * @property integer $growth
     * @property integer $weight
     * @property integer $price
     */


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

    public function actionGetMatchInformation($api_match_id,$home_team,$away_team){

        $json = "http://football-api.com/api/?Action=commentaries&APIKey=".$this->key."&match_id=".$api_match_id;
        $info = json_decode(file_get_contents($json),true);
        //echo "<pre>"; print_r($info); echo "</pre>"; exit();
        if (!isset($info["commentaries"][0])) return false;
        $result=$info["commentaries"][0];

        //echo $result["comm_match_id"];
        //$api_match_id=1788007;
        //$home_team=3;
        //$away_team=17;

        $match= SoccerMatch::model()->find('f_api_id=:id',array(':id'=>$api_match_id));
        // print_r($match);
        $match_id=$match->id;
        //echo $match_id;
        //exit();

// ----------------------------------------------------------------------------------------------------
// (3) match team -------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------
        //$i=1;
        if (isset($result["comm_match_teams"]["localteam"]))
        foreach($result["comm_match_teams"]["localteam"] as $key=>$event) {
            $team=$home_team;
            for($i=1; $i<=count($event);$i++){

                $number=$event[$i]['number'];
                $api_name=$event[$i]['name'];
                $pos=$event[$i]['pos'];
                $api_id=$event[$i]['id'];

                $player_id=$this->findPlayerByApiID($api_id);
                if (!$player_id) {
                    $player_id=$this->findPlayerByName($api_name,$api_id,$number,$team);
                }

                if (!$player_id) {
                    $player_id=$this->addNewPlayer($api_id,$number,$pos,$api_name,$team);
                }

                $this->actionAddPlayerOnField($player_id,$number,$pos,$match_id,1);
                //print_r($event[$i]);
            }


            //echo "$i<br><br><br>";
            //exit();

            //if ($key=="shots") $this->actionAddStats($key,$event["ongoal"], $away_team, $match_id);//echo $key."=>".$event["ongoal"]."<br>";
            //if ($key=="possestiontime") {$str=$event["total"]; $event["total"]=substr($str, 0, strlen($str)-1);}
            //echo $key."=>".$event["total"]."<br>";
            //$this->actionAddStats($key,$event["total"], $away_team, $match_id);

            //echo $key."=>".$event."<br>";
        }

        if (isset($result["comm_match_teams"]["visitorteam"]))
        foreach($result["comm_match_teams"]["visitorteam"] as $key=>$event) {
            $team=$away_team;
            for($i=1; $i<=count($event);$i++){

                $number=$event[$i]['number'];
                $api_name=$event[$i]['name'];
                $pos=$event[$i]['pos'];
                $api_id=$event[$i]['id'];

                $player_id=$this->findPlayerByApiID($api_id);
                if (!$player_id) {
                    $player_id=$this->findPlayerByName($api_name,$api_id,$number,$team);
                }

                if (!$player_id) {
                    $player_id=$this->addNewPlayer($api_id,$number,$pos,$api_name,$team);
                }

                $this->actionAddPlayerOnField($player_id,$number,$pos,$match_id,2);
                //print_r($event[$i]);
            }
        }

// ----------------------------------------------------------------------------------------------------
// (4) match subs -------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------
        //$i=1;
        if (isset($result["comm_match_subs"]["localteam"]))
        foreach($result["comm_match_subs"]["localteam"] as $key=>$event) {
            $team=$home_team;
            for($i=1; $i<=count($event);$i++){

                $number=$event[$i]['number'];
                $api_name=$event[$i]['name'];
                $pos=$event[$i]['pos'];
                $api_id=$event[$i]['id'];

                $player_id=$this->findPlayerByApiID($api_id);
                if (!$player_id) {
                    $player_id=$this->findPlayerByName($api_name,$api_id,$number,$team);
                }

                if (!$player_id) {
                    $player_id=$this->addNewPlayer($api_id,$number,$pos,$api_name,$team);
                }

                $this->actionAddPlayerOnSubs($player_id,$number,$pos,$match_id,1);
                //print_r($event[$i]);
            }
        }
        if (isset($result["comm_match_subs"]["visitorteam"]))
        foreach($result["comm_match_subs"]["visitorteam"] as $key=>$event) {
            $team=$away_team;
            for($i=1; $i<=count($event);$i++){

                $number=$event[$i]['number'];
                $api_name=$event[$i]['name'];
                $pos=$event[$i]['pos'];
                $api_id=$event[$i]['id'];

                $player_id=$this->findPlayerByApiID($api_id);
                if (!$player_id) {
                    $player_id=$this->findPlayerByName($api_name,$api_id,$number,$team);
                }

                if (!$player_id) {
                    $player_id=$this->addNewPlayer($api_id,$number,$pos,$api_name,$team);
                }

                $this->actionAddPlayerOnSubs($player_id,$number,$pos,$match_id,2);
                //print_r($event[$i]);
            }
        }

// ----------------------------------------------------------------------------------------------------
// (5) match substitutions  ---------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------
        //$i=1;
        if (isset($result["comm_match_substitutions"]["localteam"]))
        foreach($result["comm_match_substitutions"]["localteam"] as $key=>$event) {

            //$team=$home_team;

            if (!isset($event[1]['on_id'])) {

                $on_id=$event['on_id'];
                $off_id=$event['off_id'];
                $minute=$event['minute'];
                $on_id=$this->findPlayerByApiID($on_id);
                $off_id=$this->findPlayerByApiID($off_id);

                $this->actionAddSubstitutions($on_id,$off_id,$minute,$match_id,1);
                //echo "<br>yesssssssssssss ".count($event);
            }
            else
            for($i=1; $i<=count($event);$i++){
                $on_id=$event[$i]['on_id'];
                $off_id=$event[$i]['off_id'];
                $minute=$event[$i]['minute'];
                $on_id=$this->findPlayerByApiID($on_id);
                $off_id=$this->findPlayerByApiID($off_id);

                $this->actionAddSubstitutions($on_id,$off_id,$minute,$match_id,1);
            }
        }

        if (isset($result["comm_match_substitutions"]["visitorteam"]))
            foreach($result["comm_match_substitutions"]["visitorteam"] as $key=>$event) {

            //$team=$home_team;
            //print_r($event);

            if (!isset($event[1]['on_id'])) {

                $on_id=$event['on_id'];
                $off_id=$event['off_id'];
                $minute=$event['minute'];
                $on_id=$this->findPlayerByApiID($on_id);
                $off_id=$this->findPlayerByApiID($off_id);

                $this->actionAddSubstitutions($on_id,$off_id,$minute,$match_id,2);
                //echo "<br>yesssssssssssss ".count($event);
            }
            else
            for($i=1; $i<=count($event);$i++){

                //print_r($event);
                //echo $event[$i]['on_id']."<br>";
                $on_id=$event[$i]['on_id'];
                $off_id=$event[$i]['off_id'];
                $minute=$event[$i]['minute'];
                $on_id=$this->findPlayerByApiID($on_id);
                $off_id=$this->findPlayerByApiID($off_id);

                $this->actionAddSubstitutions($on_id,$off_id,$minute,$match_id,2);
            }
        }


// ----------------------------------------------------------------------------------------------------
// (6) match commentaries  ----------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------
        if (isset($result["comm_commentaries"]))
        foreach($result["comm_commentaries"] as $key=>$event) {
            //print_r($event); exit();
            //$team=$home_team;
            for($i=1; $i<=count($event);$i++){
                $minute=$event[$i]['minute'];
                $important=$event[$i]['important'];
                $isgoal=$event[$i]['isgoal'];
                $comment=$event[$i]['comment'];
                $this->actionAddCommentaries($minute,$important,$isgoal,$match_id,$comment);
            }
        }


// ----------------------------------------------------------------------------------------------------
// (7) match players stats  ---------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------
        //$i=1;
        if (isset($result["comm_match_player_stats"]["localteam"]))
        foreach($result["comm_match_player_stats"]["localteam"] as $key=>$event) {
            //print_r($event); exit();

            $team=$home_team;
            for($i=1; $i<=count($event);$i++){
                $player_id=$event[$i]['id'];
                $player_id=$this->findPlayerByApiID($player_id);

                $pos=$event[$i]['pos'];
                $shot_total=$event[$i]['shots_total'];
                $shots_on_goal=$event[$i]['shots_on_goal'];
                $goals=$event[$i]['goals'];
                $assists=$event[$i]['assists'];
                $offsides=$event[$i]['offsides'];
                $fouls_drawn=$event[$i]['fouls_drawn'];
                $fouls_commited=$event[$i]['fouls_commited'];
                $saves=$event[$i]['saves'];
                $yellowcards=$event[$i]['yellowcards'];
                $redcards=$event[$i]['redcards'];
                $pen_score=$event[$i]['pen_score'];
                $pen_miss=$event[$i]['pen_miss'];

                $this->actionAddPlayerStats($match_id,$player_id,$pos,$shot_total,$shots_on_goal,$goals,$assists,$offsides,$fouls_drawn,$fouls_commited,$saves,$yellowcards,$redcards,$pen_score,$pen_miss,1);
            }
        }
        if (isset($result["comm_match_player_stats"]["visitorteam"]))
        foreach($result["comm_match_player_stats"]["visitorteam"] as $key=>$event) {
            //print_r($event); exit();

            $team=$home_team;
            for($i=1; $i<=count($event);$i++){
                $player_id=$event[$i]['id'];
                $player_id=$this->findPlayerByApiID($player_id);

                $pos=$event[$i]['pos'];
                $shot_total=$event[$i]['shots_total'];
                $shots_on_goal=$event[$i]['shots_on_goal'];
                $goals=$event[$i]['goals'];
                $assists=$event[$i]['assists'];
                $offsides=$event[$i]['offsides'];
                $fouls_drawn=$event[$i]['fouls_drawn'];
                $fouls_commited=$event[$i]['fouls_commited'];
                $saves=$event[$i]['saves'];
                $yellowcards=$event[$i]['yellowcards'];
                $redcards=$event[$i]['redcards'];
                $pen_score=$event[$i]['pen_score'];
                $pen_miss=$event[$i]['pen_miss'];

                $this->actionAddPlayerStats($match_id,$player_id,$pos,$shot_total,$shots_on_goal,$goals,$assists,$offsides,$fouls_drawn,$fouls_commited,$saves,$yellowcards,$redcards,$pen_score,$pen_miss,2);
            }
        }



// ----------------------------------------------------------------------------------------------------
// (1) match event ------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------
        if (isset($result["comm_match_summary"]["localteam"])) {
            foreach($result["comm_match_summary"]["localteam"]["goals"] as $event) {
                if (isset($event[1])) {
                    for($i=1;$i<=count($event);$i++){
                        $this->actionAddEvent($event[$i], "goals", $home_team, $match_id,1);
                    }
                    //echo "not one<br>";
                }
                else  {
                    $this->actionAddEvent($event, "goals", $home_team, $match_id,1);
                    //echo "ONE<br>";
                }
                //echo count($event)."<br>";
                //print_r($event);//exit();

            }

            foreach($result["comm_match_summary"]["localteam"]["yellowcards"] as $event) {
                if (isset($event[1])) {
                    for($i=1;$i<=count($event);$i++){
                        $this->actionAddEvent($event[$i], "yellowcards", $home_team, $match_id,1);
                    }
                }
                else  {
                    $this->actionAddEvent($event, "yellowcards", $home_team, $match_id,1);
                }
            }

            foreach($result["comm_match_summary"]["localteam"]["redcards"] as $event) {
                if (isset($event[1])) {
                    for($i=1;$i<=count($event);$i++){
                        $this->actionAddEvent($event[$i], "redcards", $home_team, $match_id,1);
                    }
                }
                else  {
                    $this->actionAddEvent($event, "redcards", $home_team, $match_id,1);
                }
            }
        }
//-----------------------------------------------------------
        if (isset($result["comm_match_summary"]["visitorteam"])) {
            foreach($result["comm_match_summary"]["visitorteam"]["goals"] as $event) {
                if (isset($event[1])) {
                    for($i=1;$i<=count($event);$i++){
                        $this->actionAddEvent($event[$i], "goals", $away_team, $match_id,2);
                    }
                    //echo "not one<br>";
                }
                else  {
                    $this->actionAddEvent($event, "goals", $away_team, $match_id,2);
                    //echo "ONE<br>";
                }
                //echo count($event)."<br>";
                //print_r($event);//exit();

            }

            foreach($result["comm_match_summary"]["visitorteam"]["yellowcards"] as $event) {
                if (isset($event[1])) {
                    for($i=1;$i<=count($event);$i++){
                        $this->actionAddEvent($event[$i], "yellowcards", $away_team, $match_id,2);
                    }
                }
                else  {
                    $this->actionAddEvent($event, "yellowcards", $away_team, $match_id,2);
                }
            }

            foreach($result["comm_match_summary"]["visitorteam"]["redcards"] as $event) {
                if (isset($event[1])) {
                    for($i=1;$i<=count($event);$i++){
                        $this->actionAddEvent($event[$i], "redcards", $away_team, $match_id,2);
                    }
                }
                else  {
                    $this->actionAddEvent($event, "redcards", $away_team, $match_id,2);
                }
            }
        }

// ----------------------------------------------------------------------------------------------------
// (2) match stats ------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------
        if (isset($result["comm_match_stats"]["localteam"]))
        foreach($result["comm_match_stats"]["localteam"] as $key=>$event) {
            //print_r($event["total"]);
            if ($key=="shots") $this->actionAddStats("ongoal",$event["ongoal"], $home_team, $match_id,1);//echo $key."=>".$event["ongoal"]."<br>";
            if ($key=="possestiontime") {$str=$event["total"]; $event["total"]=substr($str, 0, strlen($str)-1);}
            //echo $key."=>".$event["total"]."<br>";
            $this->actionAddStats($key,$event["total"], $home_team, $match_id,1);
            //echo $key."=>".$event."<br>";
        }

        if (isset($result["comm_match_stats"]["visitorteam"]))
        foreach($result["comm_match_stats"]["visitorteam"] as $key=>$event) {
            //print_r($event["total"]);
            if ($key=="shots") { $this->actionAddStats("ongoal",$event["ongoal"], $away_team, $match_id,2);}//echo $key."=>".$event["ongoal"]."<br>";
            if ($key=="possestiontime") {$str=$event["total"]; $event["total"]=substr($str, 0, strlen($str)-1);}
            //echo $key."=>".$event["total"]."<br>";
            $this->actionAddStats($key,$event["total"], $away_team, $match_id,2);

            //echo $key."=>".$event."<br>";
        }



        //echo "<pre>"; print_r($info); echo "</pre>"; exit();

        /*$i=0;

        $tid1=$info['matches'][$i]['match_localteam_id'];
        $tid2=$info['matches'][$i]['match_visitorteam_id'];

        $team1= SoccerTeam::model()->find('f_api_id=:id',array(':id'=>$tid1));
        $team2= SoccerTeam::model()->find('f_api_id=:id',array(':id'=>$tid2));

        $team1=$team1->id;
        $team2=$team2->id;

        $matchid=$info['matches'][$i]['match_id'];

        $match_id= SoccerMatch::model()->count('f_api_id=:matchid',array(':matchid'=>$matchid));
        if ($match_id==0) {
            $model=  SoccerMatch::model()->find('hometeam_id=:hid AND awayteam_id=:aid',array(':hid'=>$team1,':aid'=>$team2));
            print_r($model);
            $model->f_api_id=$matchid;
            $model->save();
        }*/

        //$match_id= SoccerMatch::model()->find('f_api_id=:matchid',array(':matchid'=>$matchid));


        //echo $player->team->name."<br>";


    }





    public function actionGetMatchs(){

        //$res=Text::findMatches("Angel Rangel","Àngel Rangel Zaragoza",2); echo $res; exit();

        //$id_match=1788007;
        //$home_team=3;
        //$away_team=17;

        $json = "http://football-api.com/api/?Action=fixtures&APIKey=".$this->key."&comp_id=1204&&from_date=22.11.2014&&to_date=22.11.2014";
        $info = json_decode(file_get_contents($json),true);
        if (!isset($info["matches"])) {
            echo "No match today..";
            Yii::app()->end();
        }
        $result=$info["matches"];//[0];

        //print_r($result[0]); exit();


        $N=count($result);
        //$N=3;
        for($i=0;$i<$N;$i++){

            $api_match_id=$result[$i]['match_id'];
            $team1=$result[$i]['match_localteam_name'];
            $team2=$result[$i]['match_visitorteam_name'];
            $team1_id=$result[$i]['match_localteam_id'];
            $team2_id=$result[$i]['match_visitorteam_id'];

            $home_team=null;
            $away_team=null;
            $match_id=null;

            $match= SoccerMatch::model()->find('f_api_id=:id',array(
                ':id'=>$api_match_id,
            ));

            if ($match) {
                $match_id=$match->id;
                $home_team=$match->hometeam_id;
                $away_team=$match->awayteam_id;
            } else {

                $home_team=SoccerTeam::model()->find('f_api_id=:id',array(':id'=>$team1_id,));
                $away_team=SoccerTeam::model()->find('f_api_id=:id',array(':id'=>$team2_id,));

                $home_team=$home_team->id;
                $away_team=$away_team->id;

                /*
                  $teams=SoccerTeam::model()->findAll();
                  for($j=0;$j<count($teams);$j++) {
                    $res=Text::findMatches($team1,$teams[$j]->name,2);
                    if ($res>80) { $home_team=$teams[$j]->id; break;}
                }

                for($j=0;$j<count($teams);$j++) {
                    $res=Text::findMatches($team2,$teams[$j]->name,2);
                    if ($res>80) { $away_team=$teams[$j]->id; break;}
                }*/

                $match = SoccerMatch::model()->find('hometeam_id=:hid AND awayteam_id=:aid',array(
                    ':hid'=>$home_team,
                    ':aid'=>$away_team,
                ));

                //print_r($match);

                $match->f_api_id=$api_match_id;
                $match->save();
                $match_id=$match->id;
            }

            $match->homegoals=$result[$i]['match_localteam_score'];
            $match->awaygoals=$result[$i]['match_visitorteam_score'];
            $match->status=$result[$i]['match_status'];
            $match->save();

            //echo $api_match_id." -- ".$home_team." -- ".$away_team."<br>";
            $response=$this->actionGetMatchInformation($api_match_id,$home_team,$away_team);
            if ($response){
                echo "Succes parsing information about game: ".$api_match_id."<br>";
            }
            else {
                echo "There aren't information about match: ".$api_match_id."<br>";
            }

        }








        //exit();
       // $json = "http://football-api.com/api/?Action=commentaries&APIKey=".$this->key."&match_id=".$id;

        /*$json = "http://football-api.com/api/?Action=commentaries&APIKey=".$key."&match_id=1952160";
        $json = "http://football-api.com/api/?Action=fixtures&APIKey=".$key."&comp_id=1204&&from_date=13.08.2014&&to_date=25.08.2014";
        $json = "http://football-api.com/api/?Action=commentaries&APIKey=".$key."&match_id=1788007";
        $info = json_decode(file_get_contents($json),true);
        //echo "<pre>"; print_r($info); echo "</pre>"; exit();
        $result=$info["commentaries"][0];*/

        Yii::app()->end();

    }




    public function actionGetPlayers(){



        //get all matches!
/*
        $json = "http://www.football-data.org/soccerseasons/354/fixtures";
        $info = json_decode(file_get_contents($json),true);

        for($i=0;$i<count($info);$i++){
            $model=new SoccerMatch();
            $model->date=$info[$i]['date'];

            $team1=$info[$i]['homeTeam'];
            $team2=$info[$i]['awayTeam'];

            $teams=SoccerTeam::model()->findAll();

            for($j=0;$j<count($teams);$j++) {
                $res=Text::findMatches($team1,$teams[$j]->name,2);
                if ($res>80) { $model->hometeam_id=$teams[$j]->id; break;}
            }

            for($j=0;$j<count($teams);$j++) {
                $res=Text::findMatches($team2,$teams[$j]->name,2);
                if ($res>80) { $model->awayteam_id=$teams[$j]->id; break;}
            }

            //$model->awayteam_id=$info[$i]['homeTeam'];

            $stadium = SoccerStadiumTeam::model()->find('tid=:team',array('team'=>$model->hometeam_id));
            $model->stadium_id=$stadium->sid;

            $model->homegoals=$info[$i]['goalsHomeTeam'];
            $model->awaygoals=$info[$i]['goalsAwayTeam'];
            $model->competition_id=1;

            $model->f_api_id=-1;
            $model->matchday=$info[$i]['matchday'];
            $model->text="";



            if(!$model->save())
                print_r($model->getErrors());

        }
        //{"id":137031,"date":"2014-08-16T11:45:00Z","matchday":1,
        //"homeTeam":"Manchester United FC","awayTeam":"Swansea City","goalsHomeTeam":1,"goalsAwayTeam":2}
*/




        //$key = '81ff7420-f592-b39e-ed4f909fcc11';
        //$json = "http://football-api.com/api/?Action=commentaries&APIKey=".$key."&match_id=1952160";
        //$info = json_decode(file_get_contents($json),true);





        //print_r($info['commentaries'][0]['comm_match_teams']['localteam']['player']);


        //$player= SoccerPlayerTeam::model()->find('id=:id',array(':id'=>100));
        //echo $player->team->name."<br>";
        //$team= SoccerPlayerTeam::model()->find('id=:id',array(':id'=>100));
        //echo $player->player->rusname;


/*

        for($i=1;$i<=count($info['commentaries'][0]['comm_match_teams']['visitorteam']['player']);$i++){
            $player=$info['commentaries'][0]['comm_match_teams']['visitorteam']['player'][$i];

                        /*$players = SoccerPlayer::model()->with(array('profile'/*=>array('first_name'=>'julia')*//*))->FindAll(
                array('condition'=>"last_activity>:time", 'params'=>array(":time"=>$time),'limit'=>30)
            );*//*

            $players=SoccerPlayer::model()->findAll();
            //print_r($players);
            //echo $players[0]->name;

            for($j=0;$j<count($players);$j++) {
                $res=Text::findMatches($player['name'],$players[$j]->name,2);
                if ($res>80) { echo $player['name']." == ".$players[$j]->name." -> ".$res."<br>"; break;}
            }




            //print_r($player);
        }
*/

        //echo Text::findMatches("GaГ>1 Clichy","Gaёl Clichy",2);


        echo "<pre>";
       // print_r($info);
        echo "</pre>";

    }



    public function actionAdd7(){

        //echo Image::SaveImage("http://st1.soccer365.ru/s1/players/14_255_17/2147809.png",Yii::app()->basePath . '/../images/soccer/coach/');///*Yii::app()->basePath.*/"\images\soccer\coach");
        //echo SoccerCountry::getIdbyName("Португалия");
        //echo Image::SaveImage("http://st1.soccer365.ru/s1/logo/aJDhP_184.png",Yii::app()->basePath.'/../images/soccer/team/');

        if(isset($_POST['action']) && $_POST['action']="7"){
            $N=$_POST['count'];
            //echo $N;
            $team=$_POST['team'];
            //echo "<B>TEAM: <B>".$_POST['team'];
            $player=0;
            //$N=7;
            //if (isset($_POST['growth'])) print_r($_POST['growth']); else echo "false....<br>";
            //if (isset($_POST['weight'])) print_r($_POST['weight']); else echo "false....<br>";
            //echo "<br><br>";
            //echo "N=".$_POST['count']." or ".count($_POST['name']);
            for($i=1;$i<=$N/*count($_POST['name'])*/;$i++){

                if (!isset($_POST['name'][$i]) && !isset($_POST['rusname'][$i])) continue;
                //echo "every player...<br>";
                //echo ($_POST['rusname'][$i]);
                $birthday=(isset($_POST['birth_day'][$i]))?date("Y/m/d",strtotime($_POST['birth_day'][$i])):"0000/00/00";//date("Y/m/d",strtotime($_POST['birth_day'][$i]));
                $contract=(isset($_POST['contract'][$i]))?date("Y/m/d",strtotime($_POST['contract'][$i])):"0000/00/00";

                $criteria=new CDbCriteria;
                if (isset($_POST['name'][$i])){
                    $criteria->condition='name=:name';// AND lastname=:ln';
                    $criteria->params=array(
                        ':name'=>$_POST['name'][$i],
                    );
                } else {
                    $criteria->condition='rusname=:rusname';// AND lastname=:ln';
                    $criteria->params=array(
                        ':rusname'=>$_POST['rusname'][$i],
                    );
                }
                $count=SoccerPlayer::model()->count($criteria);
                //echo $count."<br><br>";


                if ($count>0) {
                    $model=SoccerPlayer::model()->find($criteria);
                    $player=$model->id;


                    $model->rusname=$_POST['rusname'][$i];
                    //$model->name=$_POST['name'][$i];
                    if (isset($_POST['city'][$i])) $model->city=$_POST['city'][$i];
                    $model->country_id=(isset($_POST['country'][$i]))?SoccerCountry::getIdbyName($_POST['country'][$i]):"0";
                    $model->birth_day=$birthday;
                    //$model->number=$_POST['number'][$i];
                    if (isset($_POST['number'][$i])) $model->number=$_POST['number'][$i];

                    //$model->pos=$_POST['pos'][$i];
                    if (isset($_POST['pos'][$i])) $model->pos=$_POST['pos'][$i];
                    //$model->workingleg=$_POST['workingleg'][$i];
                    //$model->growth=$_POST['growth'][$i];
                    //$model->weight=$_POST['weight'][$i];
                    if (isset($_POST['name'][$i])) $model->name=$_POST['name'][$i];
                    if (isset($_POST['growth'][$i])) $model->growth=$_POST['growth'][$i];
                    if (isset($_POST['weight'][$i])) $model->weight=$_POST['weight'][$i];
                    if (isset($_POST['workingleg'][$i])) $model->workingleg=$_POST['workingleg'][$i];
                    if (isset($_POST['price'][$i])) $model->price=$_POST['price'][$i];


                    $old="";
                    if($model->photo_img) $old=$model->photo_img;
                    $model->photo_img=Image::SaveImage($_POST['photo'][$i],Yii::app()->basePath . '/../images/soccer/player/');
                    $urloldimage=Yii::app()->basePath . '/../images/soccer/player/'.$old;
                    if ($old) if (file_exists($urloldimage)) unlink($urloldimage);

                    if($model->validate())
                        $model->save();
                    //echo $model->id;//." (save)";
                    //$model->photo_img=Image::SaveImage($_POST['photo'][$i],Yii::app()->basePath.'/../images/soccer/player/');

                    //$player=$model->id;
                } else {
                    $model=new SoccerPlayer;
                    $model->rusname=$_POST['rusname'][$i];
                    $model->name=(isset($_POST['name'][$i]))?$_POST['name'][$i]:"";
                    $model->city=(isset($_POST['city'][$i]))?$_POST['city'][$i]:"";
                    $model->country_id=(isset($_POST['country'][$i]))?SoccerCountry::getIdbyName($_POST['country'][$i]):"0";
                    $model->birth_day=$birthday;
                    $model->number=(isset($_POST['number'][$i]))?$_POST['number'][$i]:0;
                    $model->pos=(isset($_POST['pos'][$i]))?$_POST['pos'][$i]:0;

                    //$model->pos=$_POST['pos'][$i];
                    $model->workingleg=(isset($_POST['workingleg'][$i]))?$_POST['workingleg'][$i]:0;
                    $model->growth=(isset($_POST['growth'][$i]))?$_POST['growth'][$i]:0;
                    $model->weight=(isset($_POST['weight'][$i]))?$_POST['weight'][$i]:0;
                    $model->price=(isset($_POST['price'][$i]))?$_POST['price'][$i]:"";

                    $model->photo_img=Image::SaveImage($_POST['photo'][$i],Yii::app()->basePath.'/../images/soccer/player/');
                    //$model->name=$_POST['rusname'];
                    //$model->site=$_POST['site'];

                    if(!$model->save())
                        print_r($model->getErrors());

                    echo $model->id.", ";
                    $player=$model->id;
                }



                $criteria=new CDbCriteria;
                $criteria->condition='tid=:tid AND pid=:pid';
                $criteria->params=array(
                    ':tid'=>$team,
                    ':pid'=>$player,
                );
                $count=SoccerPlayerTeam::model()->count($criteria);


                echo $player."--".$team."--".$contract."";
                if ($count>0) {
                    $model=SoccerPlayerTeam::model()->find($criteria);
                    $model->tid=$team;
                    $model->pid=$player;
                    $model->date_to=$contract;
                    if($model->validate())
                        $model->save();
                }
                else {
                    $model=new SoccerPlayerTeam;
                    $model->tid=$team;
                    $model->pid=$player;
                    $model->date_to=$contract;

                    if(!$model->save())
                        print_r($model->getErrors());
                }

            }

            //

            //echo $_POST['name'];
/*
            $criteria=new CDbCriteria;
            $criteria->condition='name=:name';// AND lastname=:ln';
            $criteria->params=array(
                ':name'=>$_POST['name'],
            );
            $count=SoccerStadium::model()->count($criteria);
            //echo $count;
            //echo "!1";
            if ($count>0) {
                //echo "1";
                $model=SoccerStadium::model()->find($criteria);

                $model->founded=$_POST['founded'];
                $model->country_id=SoccerCountry::getIdbyName($_POST['country']);
                $model->name=$_POST['name'];
                $model->city=$_POST['city'];
                $model->capacity=$_POST['capacity'];
                $model->field_size=$_POST['field_size'];

                $old="";
                if($model->photo_img) $old=$model->photo_img;
                $model->photo_img=Image::SaveImage($_POST['photo'],Yii::app()->basePath . '/../images/soccer/stadium/');
                $urloldimage=Yii::app()->basePath . '/../images/soccer/stadium/'.$old;
                if ($old) if (file_exists($urloldimage)) unlink($urloldimage);

                if($model->validate())
                    $model->save();
                echo $model->id;//." (save)";
            }
            else {
                $model=new SoccerStadium;
                $model->founded=$_POST['founded'];
                $model->name=$_POST['name'];
                $model->city=$_POST['city'];
                $model->country_id=SoccerCountry::getIdbyName($_POST['country']);
                $model->capacity=$_POST['capacity'];
                $model->field_size=$_POST['field_size'];


                //print_r($_POST);

                //$model->lastname=$_POST['lastname'];
                $model->photo_img=Image::SaveImage($_POST['photo'],Yii::app()->basePath.'/../images/soccer/stadium/');
                //$model->name=$_POST['rusname'];
                //$model->site=$_POST['site'];

                if(!$model->save())
                    print_r($model->getErrors());

                echo $model->id;//." (add)";
            }
*/
            //echo "<pre>"; print_r($_POST); echo "</pre>";
            //echo "yo nigga!";
            Yii::app()->end();
        }
    }






    public function actionAdd4(){

        //echo Image::SaveImage("http://st1.soccer365.ru/s1/players/14_255_17/2147809.png",Yii::app()->basePath . '/../images/soccer/coach/');///*Yii::app()->basePath.*/"\images\soccer\coach");
        //echo SoccerCountry::getIdbyName("Португалия");
        //echo Image::SaveImage("http://st1.soccer365.ru/s1/logo/aJDhP_184.png",Yii::app()->basePath.'/../images/soccer/team/');

        if(isset($_POST['action']) && $_POST['action']="6"){

            $criteria=new CDbCriteria;
            $criteria->condition='tid=:tid AND cid=:cid';
            $criteria->params=array(
                ':tid'=>$_POST['team'],
                ':cid'=>$_POST['coach'],
            );
            $count=SoccerCoachTeam::model()->count($criteria);


            echo $count;
            if ($count>0) {
                $model=SoccerCoachTeam::model()->find($criteria);
                $model->tid=$_POST['team'];
                $model->cid=$_POST['coach'];
                if($model->validate())
                    $model->save();
            }
            else {
                $model=new SoccerCoachTeam;
                $model->tid=$_POST['team'];
                $model->cid=$_POST['coach'];
                $model->date_to=date("Y/m/d",strtotime("now"));

                if(!$model->save())
                    print_r($model->getErrors());
            }

            $criteria=new CDbCriteria;
            $criteria->condition='tid=:tid AND sid=:sid';
            $criteria->params=array(
                ':tid'=>$_POST['team'],
                ':sid'=>$_POST['stadium'],
            );
            $count=SoccerStadiumTeam::model()->count($criteria);
            if ($count>0) {
                $model=SoccerStadiumTeam::model()->find($criteria);
                $model->tid=$_POST['team'];
                $model->sid=$_POST['stadium'];
                if($model->validate())
                    $model->save();
            }
            else {
                $model=new SoccerStadiumTeam;
                $model->tid=$_POST['team'];
                $model->sid=$_POST['stadium'];
                //$model->date_to=date("Y/m/d",strtotime("now"));

                if(!$model->save())
                    print_r($model->getErrors());
            }

            Yii::app()->end();
        }
    }


    public function actionAdd3(){

        //echo Image::SaveImage("http://st1.soccer365.ru/s1/players/14_255_17/2147809.png",Yii::app()->basePath . '/../images/soccer/coach/');///*Yii::app()->basePath.*/"\images\soccer\coach");
        //echo SoccerCountry::getIdbyName("Португалия");
        //echo Image::SaveImage("http://st1.soccer365.ru/s1/logo/aJDhP_184.png",Yii::app()->basePath.'/../images/soccer/team/');

        if(isset($_POST['action']) && $_POST['action']="4"){

            //$founded=date("Y/m/d",strtotime($_POST['founded']));

            //echo $_POST['name'];

            $criteria=new CDbCriteria;
            $criteria->condition='name=:name';// AND lastname=:ln';
            $criteria->params=array(
                ':name'=>$_POST['name'],
            );
            $count=SoccerStadium::model()->count($criteria);
            //echo $count;
            //echo "!1";
            if ($count>0) {
                //echo "1";
                $model=SoccerStadium::model()->find($criteria);

                $model->founded=$_POST['founded'];
                $model->country_id=SoccerCountry::getIdbyName($_POST['country']);
                $model->name=$_POST['name'];
                $model->city=$_POST['city'];
                $model->capacity=$_POST['capacity'];
                $model->field_size=$_POST['field_size'];

                $old="";
                if($model->photo_img) $old=$model->photo_img;
                $model->photo_img=Image::SaveImage($_POST['photo'],Yii::app()->basePath . '/../images/soccer/stadium/');
                $urloldimage=Yii::app()->basePath . '/../images/soccer/stadium/'.$old;
                if ($old) if (file_exists($urloldimage)) unlink($urloldimage);

                if($model->validate())
                    $model->save();
                echo $model->id;//." (save)";/**/
            }
            else {
                $model=new SoccerStadium;
               $model->founded=$_POST['founded'];
                $model->name=$_POST['name'];
                $model->city=$_POST['city'];
                $model->country_id=SoccerCountry::getIdbyName($_POST['country']);
                $model->capacity=$_POST['capacity'];
                $model->field_size=$_POST['field_size'];


                //print_r($_POST);

                //$model->lastname=$_POST['lastname'];
                $model->photo_img=Image::SaveImage($_POST['photo'],Yii::app()->basePath.'/../images/soccer/stadium/');
                //$model->name=$_POST['rusname'];
                //$model->site=$_POST['site'];

                if(!$model->save())
                    print_r($model->getErrors()); /**/

                echo $model->id;//." (add)";
            }

            Yii::app()->end();
        }
    }



    public function actionAdd2(){
        if(isset($_POST['action']) && $_POST['action']="2"){
            //echo "1111";
            //Yii:app()->end();
            $birthday=(isset($_POST['birth_day']))?date("Y/m/d",strtotime($_POST['birth_day'])):"0000/00/00";


            $criteria=new CDbCriteria;
            $criteria->condition='rusname=:rn';
            $criteria->params=array(
                ':rn'=>$_POST['rusname'],
            );
            /*$criteria->condition='firstname=:fn AND lastname=:ln';
            $criteria->params=array(
                ':fn'=>$_POST['firstname'],
                ':ln'=>$_POST['lastname'],
            );*/
            $count=SoccerCoach::model()->count($criteria);
            //echo $count;
            if ($count>0) {
                //echo "1";
                $model=SoccerCoach::model()->find($criteria);

                 $model->birth_day=$birthday;
                 if (isset($_POST['country'])) $model->country_id=SoccerCountry::getIdbyName($_POST['country']);
                 if (isset($_POST['firstname'])) $model->firstname=$_POST['firstname'];
                 if (isset($_POST['lastname'])) $model->lastname=$_POST['lastname'];
                 //if (photo_img) DELETE!
                 //$model->image=$_POST['photo'];
                 $old="";
                 if($model->photo_img) $old=$model->photo_img;
                 $model->photo_img=Image::SaveImage($_POST['photo'],Yii::app()->basePath . '/../images/soccer/coach/');
                 $urloldimage=Yii::app()->basePath . '/../images/soccer/coach/'.$old;
                 if ($old) if (file_exists($urloldimage)) unlink($urloldimage);

                 //$model->photo_img=Image::SaveImage($_POST['photo'],Yii::app()->basePath.'../images/soccer/coach/');
                 $model->rusname=$_POST['rusname'];
                 //$model->wiki="1";

                 if($model->validate())
                     $model->save();
                 echo $model->id;//." (save)";
            }
            else {
                $model=new SoccerCoach;
                $model->birth_day=$birthday;
                if (isset($_POST['country'])) $model->country_id=SoccerCountry::getIdbyName($_POST['country']);
                if (isset($_POST['firstname']))$model->firstname=$_POST['firstname'];
                if (isset($_POST['lastname']))$model->lastname=$_POST['lastname'];
                $model->photo_img=Image::SaveImage($_POST['photo'],Yii::app()->basePath.'/../images/soccer/coach/');
                $model->rusname=$_POST['rusname'];
                //$model->wiki="";

                if(!$model->save())
                    print_r($model->getErrors());

                echo $model->id;//." (add)";
            }
            //print_r($_POST);
            Yii::app()->end();
        }

    }

    public function actionAdd(){

        //echo Image::SaveImage("http://st1.soccer365.ru/s1/players/14_255_17/2147809.png",Yii::app()->basePath . '/../images/soccer/coach/');///*Yii::app()->basePath.*/"\images\soccer\coach");
        //echo SoccerCountry::getIdbyName("Португалия");
        //echo Image::SaveImage("http://st1.soccer365.ru/s1/logo/aJDhP_184.png",Yii::app()->basePath.'/../images/soccer/team/');

        if(isset($_POST['action']) && $_POST['action']="3"){

            //$founded=date("Y/m/d",strtotime($_POST['founded']));


            $criteria=new CDbCriteria;
            $criteria->condition='name=:n';// AND lastname=:ln';
            $criteria->params=array(
                ':n'=>$_POST['name'],
            );
            $count=SoccerTeam::model()->count($criteria);
            //echo $count;
            if ($count>0) {
                //echo "1";
                $model=SoccerTeam::model()->find($criteria);

                $model->founded=$_POST['founded'];
                //$model->country_id=SoccerCountry::getIdbyName($_POST['country']);
                $model->name=$_POST['name'];
                $model->rusname=$_POST['rusname'];
                //if (photo_img) DELETE!
                //$model->image=$_POST['photo'];
                $old="";
                if($model->logo_img) $old=$model->logo_img;
                $model->logo_img=Image::SaveImage($_POST['photo'],Yii::app()->basePath . '/../images/soccer/team/');
                $urloldimage=Yii::app()->basePath . '/../images/soccer/team/'.$old;
                if ($old) if (file_exists($urloldimage)) unlink($urloldimage);
                $model->site=$_POST['site'];
                $model->phone=$_POST['phone'];

                if($model->validate())
                    $model->save();
                echo $model->id;//." (save)";
            }
            else {
                $model=new SoccerTeam;
                $model->founded=$_POST['founded'];
                $model->name=$_POST['name'];
                $model->phone=$_POST['phone'];

                //print_r($_POST);

                //$model->lastname=$_POST['lastname'];
                $model->logo_img=Image::SaveImage($_POST['photo'],Yii::app()->basePath.'/../images/soccer/team/');
                $model->rusname=$_POST['rusname'];
                $model->site=$_POST['site'];

                if(!$model->save())
                    print_r($model->getErrors());

                echo $model->id;//." (add)";
            }

            Yii::app()->end();
        }
    }


    public function actionUrl2()
    {
        if(isset($_POST['action']))
        {
            echo file_get_contents($_POST['url']);
            Yii::app()->end();
        }


        $this->render('index');
    }

    public function actionUrl()
    {

        //$model=new SoccerTeam();
        if(isset($_POST['action']))
        {
            //echo "xuy";
            //$ru_url = urlencode ('Челси_(футбольный_клуб)');
            //echo $ru_url;
            $url=$_POST['url'];
           // echo $url;
            $html = file_get_contents($url);
            echo $html;
            Yii::app()->end();
        }


        $this->render('index');
    }


	public function actionIndex()
	{

        //$model=new SoccerTeam();
        if(isset($_POST['action']))
        {
            echo "xuy";
            //$ru_url = urlencode ('Челси_(футбольный_клуб)');
            //echo $ru_url;
            $url='http://www.soccer365.ru/clubs/'.$_POST['uid'].'/';
            echo $url;
            $html = file_get_contents($url);
            echo $html;
            Yii::app()->end();
        }


		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}
}