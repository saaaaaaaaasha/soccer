<?php

/**
 * This is the model class for table "{{soccer_match}}".
 *
 * The followings are the available columns in table '{{soccer_match}}':
 * @property integer $id
 * @property string $date
 * @property integer $hometeam_id
 * @property integer $awayteam_id
 * @property integer $homegoals
 * @property integer $awaygoals
 * @property integer $competition_id
 * @property integer $stadium_id
 * @property integer $f_api_id
 * @property integer $matchday
 * @property string $text
 * @property string $status
 */
class SoccerMatch extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{soccer_match}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date, hometeam_id, awayteam_id, homegoals, awaygoals, competition_id', 'required'),
			array('hometeam_id, awayteam_id, homegoals, awaygoals, competition_id, stadium_id, f_api_id, matchday', 'numerical', 'integerOnly'=>true),
			array('text, status', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, date, hometeam_id, awayteam_id, homegoals, awaygoals, competition_id, stadium_id, f_api_id, matchday, text, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'hometeam' => array(self::BELONGS_TO, 'SoccerTeam', 'hometeam_id'),
            'awayteam' => array(self::BELONGS_TO, 'SoccerTeam', 'awayteam_id'),
            'stadium' => array(self::BELONGS_TO, 'SoccerStadium', 'stadium_id'),
            //'stadium' => array(self::BELONGS_TO, 'SoccerStadium', 'competition_id'),
            //       * @property integer $competition_id
    //* @property integer $stadium_id
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'date' => 'Date',
			'hometeam_id' => 'Hometeam',
			'awayteam_id' => 'Awayteam',
			'homegoals' => 'Homegoals',
			'awaygoals' => 'Awaygoals',
			'competition_id' => 'Competition',
			'stadium_id' => 'Stadium',
			'f_api_id' => 'F Api',
			'matchday' => 'Matchday',
			'text' => 'Text',
			'status' => 'Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('hometeam_id',$this->hometeam_id);
		$criteria->compare('awayteam_id',$this->awayteam_id);
		$criteria->compare('homegoals',$this->homegoals);
		$criteria->compare('awaygoals',$this->awaygoals);
		$criteria->compare('competition_id',$this->competition_id);
		$criteria->compare('stadium_id',$this->stadium_id);
		$criteria->compare('f_api_id',$this->f_api_id);
		$criteria->compare('matchday',$this->matchday);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SoccerMatch the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function getStatusMatch($str){
        //echo $str;
        if (!$str) return "Не начался";
        elseif ($str=="FT") return "Закончен";
        elseif ($str=="HT") return "Перерыв";
        elseif (strlen($str)==5) return "Не начался";
        //$str=substr($str,0,strlen($str)-1);
        if ($str>=0 && $str<=90 && $str!="NULL" && $str) return"Идет ".$str."'";


        return "Не начался";
    }


    public static function getIconClassEvent($type){

        if ($type==1) return "live_goal";
        elseif ($type==2) return "live_owngoal";
        elseif ($type==3) return "live_pengoal";
        elseif ($type==4) return "live_yellowcard";
        elseif ($type==5) return "live_redcard";
        elseif ($type==6) return "live_mispen";

        return "";
    }
    public static function getResultMatch($g1,$g2){
        if ($g1=="?" || $g1=="-1") return "- : -";
        return $g1." : ".$g2;
    }


    public static function getPlayer($p){
        $number=$p["number"];
        $content="<div style=\"height:15px;\" data-number=\"".$number."\" class=\"event_at\">";
        $content.= "<span class=\"event_time\">".$number."</span>";
        $content.= "<span class=\"flag16\" style=\"background-image:url('".Yii::app()->baseUrl.'/images/soccer/player/'.$p->player->photo_img."')\"><a href=\"".Yii::app()->baseUrl."/player/".$p->player->id."\">".$p->player->rusname."</a></span>";

        //echo "Тип: ".$event["type"]." | ";
        //echo "Команда: ".$event["team"]." | ";
        //echo "Игрок: ".$event["player_id"]."";

        return $content."</div>";
    }

    public static function getLineEvent($event){

        //print_r($event);
        //print_r($event->player);

        $type=$event["type"];
        $minute=$event["minute"];

        if (!(strpos($minute, "og") === false)) {
            preg_match_all('|\d+|', $minute, $matches);
            //print_r($matches[0]);
            $minute=$matches[0][0]."";
            $type=2;
        }

        $content="<div data-minute=\"".$minute."\" class=\"event_at\">";

        $content.= "<span class=\"event_time\">".$minute."'</span>";
        $content.= "<div class=\"event_at_icon ".self::getIconClassEvent($type)."\"></div>";
        $content.= "<span class=\"flag16\" style=\"background-image:url('".Yii::app()->baseUrl.'/images/soccer/player/'.$event->player->photo_img."')\"><a href=\"".Yii::app()->baseUrl."/player/".$event->player->id."\">".$event->player->rusname."</a></span>";

        //echo "Тип: ".$event["type"]." | ";
        //echo "Команда: ".$event["team"]." | ";
        //echo "Игрок: ".$event["player_id"]."";

        return $content."</div>";
    }

    public static function getCommentaries($comment){

        $minute=$comment["minute"];

        $content="<div data-minute=\"".$minute."\">";

        //* @property integer $important
        //* @property integer $isgoal
        //* @property string $comment
        $content.= "<span class=\"event_time\">".$minute."'</span>";
        if ($comment["isgoal"]=="1"){
            $content.= "<div class=\"event_at_icon live_goal\"></div>";
        }
        $imp="";
        if ($comment["important"]==1) $imp="style=\"font-weight:bold;\"";
        $content.= "<span ".$imp.">".$comment["comment"]."</span>";

        //echo "Тип: ".$event["type"]." | ";
        //echo "Команда: ".$event["team"]." | ";
        //echo "Игрок: ".$event["player_id"]."";

        return $content."</div><div class=\"clear\"></div>";
    }

    public static function getPlace($id) {
        return 5;
    }

    public static function getCurrentMatchDay() {
        $date=date("Y-m-d H:i:s",strtotime("now"));
        $matches=SoccerMatch::model()->Find('date>:date',array('date'=>$date));
        return $matches['matchday'];

    }

    public static function getStatsForChars($id) {
        $N=self::getCurrentMatchDay();
        for($i=1;$i<$N;$i++){
            $result['place'][$i]=self::getTable($id,$i,true);
            $result['res'][$i]=self::getResultMatchJS($id,$i);
        }
        return $result;
    }

    public static function getResultMatchJS($id,$matchday) {
        $match=SoccerMatch::model()->Find('(hometeam_id=:hid OR awayteam_id=:hid) AND matchday=:mday',array('hid'=>$id,'mday'=>$matchday));
        $result=0;
        if ($id==$match->hometeam_id){
            if ($match->homegoals>$match->awaygoals) $result=1;
            elseif ($match->homegoals<$match->awaygoals) $result=-1;
        } else {
            if ($match->homegoals>$match->awaygoals) $result=-1;
            elseif ($match->homegoals<$match->awaygoals) $result=1;
        }
        return $result;
    }

    public static function getTable($id,$matchday=38,$count=false){
        $teams=SoccerTeam::model()->FindAll(); // find team in tournament (current season)
        for($i=0;$i<count($teams);$i++) {
            $stats[$i]=self::getTeamStats($teams[$i]->id,$matchday);
        }

        for($i=0;$i<count($teams);$i++)
            for($j=$i+1;$j<count($teams);$j++)
            {
                if ($stats[$i]["score"]<$stats[$j]["score"] || ($stats[$i]["score"]==$stats[$j]["score"] && $stats[$i]["goal1"]<$stats[$j]["goal2"] )) {
                    $temp=$teams[$i]; $teams[$i]=$teams[$j]; $teams[$j]=$temp;
                    $temp=$stats[$i]; $stats[$i]=$stats[$j]; $stats[$j]=$temp;
                }
            }
        if ($count==true) {
            for($i=0;$i<count($teams);$i++) {
                if ($id==$teams[$i]->id) return ($i+1);
            }
        }

        $matches=SoccerMatch::model()->FindAll('status = "FT"');
        //print_r($matches);

        $result['teams']=$teams;
        $result['stats']=$stats;
        $result['current']=$matches[count($matches)-1]->matchday;
        return $result;
    }

    public static function getLastMatch($id,$count=5,$matchday=38,$stadium=false){
        if (!$stadium) {
        $matches=SoccerMatch::model()->FindAll('(hometeam_id=:hid OR awayteam_id=:hid) AND status="FT"',array('hid'=>$id));
        } else {
            $matches=SoccerMatch::model()->FindAll('(hometeam_id=:hid OR awayteam_id=:hid) AND status="FT" AND stadium_id=:st',array('hid'=>$id,'st'=>$stadium));
        }
        //print_r($matches);
        $games=array(); $k=$count-1;
        for ($i=count($matches)-1;$i>=0;$i--) {
            if ($k==-1) break;
            $games[$k--]=$matches[$i];
        }
        $games=array_reverse($games);
        return $games;
    }

    public static function getNextMatch($id,$count=5,$matchday=38){
        $date=date("Y-m-d 00:00:00",strtotime("now"));
        $matches=SoccerMatch::model()->FindAll('(hometeam_id=:hid OR awayteam_id=:hid) AND date>:date',array('hid'=>$id,'date'=>$date));
        //print_r($matches);
        $games=array(); $k=0;
        for ($i=0;$i<count($matches);$i++) {
            if ($k==$count) break;
            $games[$k++]=$matches[$i];
        }

        /*$games=array(); $k=$count-1;
        for ($i=count($matches)-1;$i>=0;$i--) {
            if ($k==-1) break;
            $games[$k--]=$matches[$i];
        }*/
        return $games;
    }


    public static function getTeamStats($id,$matchday=38){
        //$teams=SoccerTeam::model()->FindAll();//'',array(''=>''));
        //$matchday++;
        //$matchday=38;
        //echo $matchday." ";
        $stats['score']=0;
        $stats['game']=0;
        $stats['goal1']=0;
        $stats['goal2']=0;
        $stats['wins']=0;
        $stats['loses']=0;
        $stats['draws']=0;

        $matches=SoccerMatch::model()->FindAll('hometeam_id=:hid AND status="FT" AND matchday<=:matchday',array('hid'=>$id,'matchday'=>$matchday));
        for($i=0;$i<count($matches);$i++) {
            $stats['goal1']+=$matches[$i]->homegoals;
            $stats['goal2']+=$matches[$i]->awaygoals;
            $stats['game']++;

            if($matches[$i]->homegoals>$matches[$i]->awaygoals) {
                $stats['score']+=3;
                $stats['wins']++;
            }
            elseif($matches[$i]->homegoals==$matches[$i]->awaygoals) {
                $stats['score']+=1;
                $stats['draws']++;
            }
            elseif($matches[$i]->homegoals<$matches[$i]->awaygoals) {
                $stats['loses']++;
            }
        }
        $matches=SoccerMatch::model()->FindAll('awayteam_id=:aid AND status="FT" AND matchday<=:matchday',array('aid'=>$id,'matchday'=>$matchday));

        for($i=0;$i<count($matches);$i++) {
            $stats['goal2']+=$matches[$i]->homegoals;
            $stats['goal1']+=$matches[$i]->awaygoals;
            $stats['game']++;

            if($matches[$i]->homegoals<$matches[$i]->awaygoals) {
                $stats['score']+=3;
                $stats['wins']++;
            }
            elseif($matches[$i]->homegoals==$matches[$i]->awaygoals) {
                $stats['score']+=1;
                $stats['draws']++;
            }
            elseif($matches[$i]->homegoals>$matches[$i]->awaygoals) {
                $stats['loses']++;
            }
        }
        //for($i=0;$i<count($teams);$i++) {
        return $stats;
    }



}
