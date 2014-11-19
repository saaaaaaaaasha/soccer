<?php

class ParserController extends Controller
{
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

    public function actionGetMatchs(){
        $key = '81ff7420-f592-b39e-ed4f909fcc11';
        $json = "http://football-api.com/api/?Action=commentaries&APIKey=".$key."&match_id=1952160";
        $json = "http://football-api.com/api/?Action=fixtures&APIKey=".$key."&comp_id=1204&&from_date=13.08.2014&&to_date=25.08.2014";
        $info = json_decode(file_get_contents($json),true);
        $i=0;

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
        }

        //$match_id= SoccerMatch::model()->find('f_api_id=:matchid',array(':matchid'=>$matchid));


        //echo $player->team->name."<br>";

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