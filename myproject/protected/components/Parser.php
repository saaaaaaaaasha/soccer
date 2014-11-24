<?php


class Parser
{
    public static $key = '81ff7420-f592-b39e-ed4f909fcc11';
    public static $comp='1204';


    static function Today($str=false,$russian=false){

        $format = 'Y-m-d H:i:s';
        $date=date("d.m.Y",strtotime(gmdate($format)));//20.11.2014


        //$json = "http://football-api.com/api/?Action=fixtures&APIKey=".self::$key."&comp_id=".self::$comp."&&match_date=".$date;

        $json = "http://football-api.com/api/?Action=fixtures&APIKey=".self::$key."&comp_id=".self::$comp."&&match_date=".$date;
        $info = json_decode(file_get_contents($json),true);
        if (!isset($info["matches"])) {
            echo "No match today..";
            Yii::app()->end();
        }
        $result=$info["matches"];//[0];

        $N=count($result);
        echo $N."\n";
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
            $g1=($result[$i]['match_localteam_score']!="?")?$result[$i]['match_localteam_score']:-1;
            $g2=($result[$i]['match_visitorteam_score']!="?")?$result[$i]['match_visitorteam_score']:-1;

            $match->homegoals=$g1;
            $match->awaygoals=$g2;
            $match->status=$result[$i]['match_status'];
            if (!$match->save()){
                print_r($match->getErrors());
            };

            //echo $api_match_id." -- ".$home_team." -- ".$away_team."<br>";
            //$response=$this->actionGetMatchInformation($api_match_id,$home_team,$away_team);


            $model= SoccerMatchOnline::model()->find('match_id=:id',array(
                ':id'=>$match_id,
            ));

            if (!$model) {
                echo "new model\n";
                $model=new SoccerMatchOnline;
                $model->match_id=$match_id;
                $model->hid=$home_team;
                $model->aid=$away_team;
            }

            $model->status=$match->status;
            if (!$model->save())
                print_r($model->getErrors());


            /*if ($response){
                echo "Succes parsing information about game: ".$api_match_id."<br>";
            }
            else {
                echo "There aren't information about match: ".$api_match_id."<br>";
            }*/

        }


        self::Logging("--- updating list of today matchs (".$N.")",false);
    }

//$json = "http://football-api.com/api/?Action=commentaries&APIKey=81ff7420-f592-b39e-ed4f909fcc11&match_id=1933858";
//$json = "http://football-api.com/api/?Action=fixtures&APIKey=".$key."&comp_id=1204&&match_date=22.11.2014";

    static function Update(){
        $model= SoccerMatchOnline::model()->findAll('status<>:id',array(
            ':id'=>"FT",
        ));
        //print_r($model);
        $N=count($model);
        //echo $N."\n";
        //$N=1;
        for($i=0;$i<$N;$i++){
            $match= SoccerMatch::model()->find('id=:id',array(
                ':id'=>$model[$i]->match_id,
            ));
            //echo $match->f_api_id."\n";
            //self::Logging("--- updating match with id: ".$match->id." (".$match->f_api_id.")",false,"start");
            self::UpdateMatch($match->f_api_id,$match->hometeam_id,$match->awayteam_id);
            self::Logging("--- updating match with id: ".$match->id." (".$match->f_api_id.")",false,"end");
        }
        self::Logging("");
    }

    static function Logging($text,$encode=false,$action=""){
        $file= Yii::app()->baseUrl."/logs/parser.log";
        $time = ($text=="")?"":date("d.m.Y H:i:s",strtotime("now")).": ";
        if ($encode) $text=json_encode($text);
        //$current = file_get_contents($file);
        //$current .= "John Smith\n";
        //file_put_contents($file, $current);
        file_put_contents($file, $time." ".$action." ".$text."\n", FILE_APPEND | LOCK_EX);
        //
    }


    static function UpdateMatch($api_match_id,$home_team,$away_team){
        //echo $api_match_id." ".$home_team." ".$away_team;

        $json = "http://football-api.com/api/?Action=commentaries&APIKey=".self::$key."&match_id=".$api_match_id;
        $info = json_decode(file_get_contents($json),true);
        //echo "<pre>"; print_r($info); echo "</pre>"; exit();
        if (!isset($info["commentaries"][0]))
        {
            //self::Logging(" no information of match (".$api_match_id.")",false);
            return false;
        }
        $result=$info["commentaries"][0];
        //self::Logging("parsing inf. about match (".$api_match_id.")",false," start");
        $parser=new ParserFunction();


        //echo $result["comm_match_id"];
        //$api_match_id=1788007;
        //$home_team=3;
        //$away_team=17;

        $match= SoccerMatch::model()->find('f_api_id=:id',array(':id'=>$api_match_id));
        // print_r($match);
        $match_id=$match->id;
        //echo $match_id;
        //exit();
        self::Today();
        /*$g1=($result[$i]['match_localteam_score']!="?")?$result[$i]['match_localteam_score']:-1;
        $g2=($result[$i]['match_visitorteam_score']!="?")?$result[$i]['match_visitorteam_score']:-1;

        $match->homegoals=$g1;
        $match->awaygoals=$g2;
        $match->status=$result[$i]['match_status'];
        if (!$match->save()){
            print_r($match->getErrors());
        };*/



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

                    $player_id=$parser->findPlayerByApiID($api_id);
                    if (!$player_id) {
                        $player_id=$parser->findPlayerByName($api_name,$api_id,$number,$team);
                    }

                    if (!$player_id) {
                        $player_id=$parser->addNewPlayer($api_id,$number,$pos,$api_name,$team);
                    }

                    $parser->actionAddPlayerOnField($player_id,$number,$pos,$match_id,1);
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

                    $player_id=$parser->findPlayerByApiID($api_id);
                    if (!$player_id) {
                        $player_id=$parser->findPlayerByName($api_name,$api_id,$number,$team);
                    }

                    if (!$player_id) {
                        $player_id=$parser->addNewPlayer($api_id,$number,$pos,$api_name,$team);
                    }

                    $parser->actionAddPlayerOnField($player_id,$number,$pos,$match_id,2);
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

                    $player_id=$parser->findPlayerByApiID($api_id);
                    if (!$player_id) {
                        $player_id=$parser->findPlayerByName($api_name,$api_id,$number,$team);
                    }

                    if (!$player_id) {
                        $player_id=$parser->addNewPlayer($api_id,$number,$pos,$api_name,$team);
                    }

                    $parser->actionAddPlayerOnSubs($player_id,$number,$pos,$match_id,1);
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

                    $player_id=$parser->findPlayerByApiID($api_id);
                    if (!$player_id) {
                        $player_id=$parser->findPlayerByName($api_name,$api_id,$number,$team);
                    }

                    if (!$player_id) {
                        $player_id=$parser->addNewPlayer($api_id,$number,$pos,$api_name,$team);
                    }

                    $parser->actionAddPlayerOnSubs($player_id,$number,$pos,$match_id,2);
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
                    $on_id=$parser->findPlayerByApiID($on_id);
                    $off_id=$parser->findPlayerByApiID($off_id);

                    $parser->actionAddSubstitutions($on_id,$off_id,$minute,$match_id,1);
                    //echo "<br>yesssssssssssss ".count($event);
                }
                else
                    for($i=1; $i<=count($event);$i++){
                        $on_id=$event[$i]['on_id'];
                        $off_id=$event[$i]['off_id'];
                        $minute=$event[$i]['minute'];
                        $on_id=$parser->findPlayerByApiID($on_id);
                        $off_id=$parser->findPlayerByApiID($off_id);

                        $parser->actionAddSubstitutions($on_id,$off_id,$minute,$match_id,1);
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
                    $on_id=$parser->findPlayerByApiID($on_id);
                    $off_id=$parser->findPlayerByApiID($off_id);

                    $parser->actionAddSubstitutions($on_id,$off_id,$minute,$match_id,2);
                    //echo "<br>yesssssssssssss ".count($event);
                }
                else
                    for($i=1; $i<=count($event);$i++){

                        //print_r($event);
                        //echo $event[$i]['on_id']."<br>";
                        $on_id=$event[$i]['on_id'];
                        $off_id=$event[$i]['off_id'];
                        $minute=$event[$i]['minute'];
                        $on_id=$parser->findPlayerByApiID($on_id);
                        $off_id=$parser->findPlayerByApiID($off_id);

                        $parser->actionAddSubstitutions($on_id,$off_id,$minute,$match_id,2);
                    }
            }


// ----------------------------------------------------------------------------------------------------
// (6) match commentaries  ----------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------
        if (isset($result["comm_commentaries"]))
            foreach($result["comm_commentaries"] as $key=>$event) {
                if (isset($event['comment']) && $event['comment']=="Commentary Not Available") {break;}//break;
                if (isset($event['comment'])) {
                    $minute=$event['minute'];
                    $important=$event['important'];
                    $isgoal=$event['isgoal'];
                    $comment=$event['comment'];
                    $parser->actionAddCommentaries($minute,$important,$isgoal,$match_id,$comment);
                    break;
                }
                //print_r($event); exit();
                //$team=$home_team;
                for($i=1; $i<=count($event);$i++){
                    $minute=$event[$i]['minute'];
                    $important=$event[$i]['important'];
                    $isgoal=$event[$i]['isgoal'];
                    $comment=$event[$i]['comment'];
                    $parser->actionAddCommentaries($minute,$important,$isgoal,$match_id,$comment);
                }
            }

        //echo "ho ho ho"; exit();
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
                    $player_id=$parser->findPlayerByApiID($player_id);

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

                    $parser->actionAddPlayerStats($match_id,$player_id,$pos,$shot_total,$shots_on_goal,$goals,$assists,$offsides,$fouls_drawn,$fouls_commited,$saves,$yellowcards,$redcards,$pen_score,$pen_miss,1);
                }
            }
        if (isset($result["comm_match_player_stats"]["visitorteam"]))
            foreach($result["comm_match_player_stats"]["visitorteam"] as $key=>$event) {
                //print_r($event); exit();

                $team=$home_team;
                for($i=1; $i<=count($event);$i++){
                    $player_id=$event[$i]['id'];
                    $player_id=$parser->findPlayerByApiID($player_id);

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

                    $parser->actionAddPlayerStats($match_id,$player_id,$pos,$shot_total,$shots_on_goal,$goals,$assists,$offsides,$fouls_drawn,$fouls_commited,$saves,$yellowcards,$redcards,$pen_score,$pen_miss,2);
                }
            }



// ----------------------------------------------------------------------------------------------------
// (1) match event ------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------
        if (isset($result["comm_match_summary"]["localteam"])) {
            foreach($result["comm_match_summary"]["localteam"]["goals"] as $event) {
                if (isset($event[1])) {
                    for($i=1;$i<=count($event);$i++){
                        $parser->actionAddEvent($event[$i], "goals", $home_team, $match_id,1);
                    }
                    //echo "not one<br>";
                }
                else  {
                    $parser->actionAddEvent($event, "goals", $home_team, $match_id,1);
                    //echo "ONE<br>";
                }
                //echo count($event)."<br>";
                //print_r($event);//exit();

            }

            foreach($result["comm_match_summary"]["localteam"]["yellowcards"] as $event) {
                if (isset($event[1])) {
                    for($i=1;$i<=count($event);$i++){
                        $parser->actionAddEvent($event[$i], "yellowcards", $home_team, $match_id,1);
                    }
                }
                else  {
                    $parser->actionAddEvent($event, "yellowcards", $home_team, $match_id,1);
                }
            }

            foreach($result["comm_match_summary"]["localteam"]["redcards"] as $event) {
                if (isset($event[1])) {
                    for($i=1;$i<=count($event);$i++){
                        $parser->actionAddEvent($event[$i], "redcards", $home_team, $match_id,1);
                    }
                }
                else  {
                    $parser->actionAddEvent($event, "redcards", $home_team, $match_id,1);
                }
            }
        }
//-----------------------------------------------------------
        if (isset($result["comm_match_summary"]["visitorteam"])) {
            foreach($result["comm_match_summary"]["visitorteam"]["goals"] as $event) {
                if (isset($event[1])) {
                    for($i=1;$i<=count($event);$i++){
                        $parser->actionAddEvent($event[$i], "goals", $away_team, $match_id,2);
                    }
                    //echo "not one<br>";
                }
                else  {
                    $parser->actionAddEvent($event, "goals", $away_team, $match_id,2);
                    //echo "ONE<br>";
                }
                //echo count($event)."<br>";
                //print_r($event);//exit();

            }

            foreach($result["comm_match_summary"]["visitorteam"]["yellowcards"] as $event) {
                if (isset($event[1])) {
                    for($i=1;$i<=count($event);$i++){
                        $parser->actionAddEvent($event[$i], "yellowcards", $away_team, $match_id,2);
                    }
                }
                else  {
                    $parser->actionAddEvent($event, "yellowcards", $away_team, $match_id,2);
                }
            }

            foreach($result["comm_match_summary"]["visitorteam"]["redcards"] as $event) {
                if (isset($event[1])) {
                    for($i=1;$i<=count($event);$i++){
                        $parser->actionAddEvent($event[$i], "redcards", $away_team, $match_id,2);
                    }
                }
                else  {
                    $parser->actionAddEvent($event, "redcards", $away_team, $match_id,2);
                }
            }
        }

// ----------------------------------------------------------------------------------------------------
// (2) match stats ------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------
        if (isset($result["comm_match_stats"]["localteam"]))
            foreach($result["comm_match_stats"]["localteam"] as $key=>$event) {
                //print_r($event["total"]);
                if ($key=="shots") $parser->actionAddStats("ongoal",$event["ongoal"], $home_team, $match_id,1);//echo $key."=>".$event["ongoal"]."<br>";
                if ($key=="possestiontime") {$str=$event["total"]; $event["total"]=substr($str, 0, strlen($str)-1);}
                //echo $key."=>".$event["total"]."<br>";
                $parser->actionAddStats($key,$event["total"], $home_team, $match_id,1);
                //echo $key."=>".$event."<br>";
            }

        if (isset($result["comm_match_stats"]["visitorteam"]))
            foreach($result["comm_match_stats"]["visitorteam"] as $key=>$event) {
                //print_r($event["total"]);
                if ($key=="shots") { $parser->actionAddStats("ongoal",$event["ongoal"], $away_team, $match_id,2);}//echo $key."=>".$event["ongoal"]."<br>";
                if ($key=="possestiontime") {$str=$event["total"]; $event["total"]=substr($str, 0, strlen($str)-1);}
                //echo $key."=>".$event["total"]."<br>";
                $parser->actionAddStats($key,$event["total"], $away_team, $match_id,2);

                //echo $key."=>".$event."<br>";
            }

        //self::Logging(" parsing inf. about match (".$api_match_id.")",false," end");

    }

}
