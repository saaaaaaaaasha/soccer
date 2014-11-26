<?php

/**
 * This is the model class for table "{{forecast}}".
 *
 * The followings are the available columns in table '{{forecast}}':
 * @property integer $id
 * @property integer $user_id
 * @property integer $match_id
 * @property integer $homegoals
 * @property integer $awaygoals
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property SoccerMatch $match
 */
class Forecast extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{forecast}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, match_id, homegoals, awaygoals', 'required'),
			array('user_id, match_id, homegoals, awaygoals', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, match_id, homegoals, awaygoals', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'match' => array(self::BELONGS_TO, 'SoccerMatch', 'match_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'match_id' => 'Match',
			'homegoals' => 'Homegoals',
			'awaygoals' => 'Awaygoals',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('match_id',$this->match_id);
		$criteria->compare('homegoals',$this->homegoals);
		$criteria->compare('awaygoals',$this->awaygoals);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        //статистические данные
        
        public static function matchday(){
            $matchday = Yii::app()->db->createCommand('SELECT matchday FROM tbl_soccer_match WHERE date<= NOW() ORDER BY date DESC LIMIT 1')->queryScalar(); 
            return $matchday;
        }

        public static function count_st($matchday){
            $sqlcommand=  Yii::app()->db->createCommand('SELECT COUNT(*) FROM tbl_soccer_match WHERE matchday>=:matchday');
            $sqlcommand->bindParam(':matchday', $matchday);        
            $count=  $sqlcommand->queryScalar();    
            
            return $count;
        }

        public static function score_turn_pl($user_id){
              //очки игрока в турнире
            $sqlcommand = Yii::app()->db->createCommand('SELECT SUM(scores) FROM tbl_forecast WHERE user_id=:user_id');
            $sqlcommand->bindParam(':user_id', $user_id);        
            $score_turn_pl= $sqlcommand->queryScalar();
            
            return $score_turn_pl;
        }

        public static function score_tur_pl($user_id, $matchday){
            //очки игрока в туре
            $sqlcommand = Yii::app()->db->createCommand(''
                    . 'SELECT '
                    . '     SUM(scores) '
                    . 'FROM '
                    . '     tbl_forecast '
                    . 'WHERE '
                    . '     user_id=:user_id '
                    . 'AND '
                    . '     match_id in '
                    . '             (SELECT id FROM tbl_soccer_match WHERE matchday=:matchday)');

            $sqlcommand->bindParam(':user_id', $user_id);  
            $sqlcommand->bindParam(':matchday', $matchday);  
            $score_tur_pl= $sqlcommand->queryScalar();         
            
            return $score_tur_pl;
        }
        
        public static function success_pl($user_id, $matchday){
                //успех
            $sqlcommand = Yii::app()->db->createCommand(''
                    . 'SELECT '
                    . '     COUNT(scores) '
                    . 'FROM '
                    . '     tbl_forecast '
                    . 'WHERE '
                    . '     user_id=:user_id AND scores>0 '
                    . 'AND '
                    . '     match_id in '
                    . '             (SELECT id FROM tbl_soccer_match WHERE matchday=:matchday)');

            $sqlcommand->bindParam(':user_id', $user_id);  
            $sqlcommand->bindParam(':matchday', $matchday);  
            $success_pl= $sqlcommand->queryScalar();   
            
            return $success_pl;
        }

        public static function players_turn(){
            //усего участников в турнире
            $players_turn = Yii::app()->db->createCommand('SELECT COUNT(*) FROM (SELECT user_id FROM tbl_forecast GROUP BY user_id) AS tb1')->queryScalar();
            return $players_turn;
            
        }

        public static function statistics_turn(){
            //всего прогнозов
            $statistics_turn = Yii::app()->db->createCommand('SELECT COUNT(*) FROM tbl_forecast')->queryScalar();
            
            return $statistics_turn;
        }

        public static function  players_tur($matchday){
            //усего участников в турнире       
            $sqlcommand = Yii::app()->db->createCommand(''
                    . 'SELECT COUNT(*) FROM ('
                    .                           'SELECT '
                    .                           '     user_id '
                    .                           'FROM '
                    .                           '     tbl_forecast '
                    .                           'WHERE '                             
                    .                           '     match_id in '
                    .                           '             (SELECT id FROM tbl_soccer_match WHERE matchday=:matchday) '
                    .                           ' GROUP BY user_id) AS t1');

            $sqlcommand->bindParam(':matchday', $matchday);  
            $players_tur= $sqlcommand->queryScalar();
            
            return $players_tur;
        }
        
        
        public static function statistics_tur($matchday){
             //всего прогнозов в туре
            $sqlcommand = Yii::app()->db->createCommand(''
                    . 'SELECT '
                    . '     COUNT(*) '
                    . 'FROM '
                    . '     tbl_forecast '
                    . 'WHERE '
                    . '     match_id in '
                    . '             (SELECT id FROM tbl_soccer_match WHERE matchday=:matchday)');

            $sqlcommand->bindParam(':matchday', $matchday);  
            $statistics_tur = $sqlcommand->queryScalar();
           
            return $statistics_tur;
        }
        
        public static function best_player()
        {
            $sqlcommand = Yii::app()->db->createCommand(''
                    . 'SELECT '
                    . '     SUM(scores) as scores , '
                    . '     user_id '
                    . 'FROM '
                    . '     tbl_forecast  '
                    . 'GROUP BY '
                    . '     user_id ' 
                    . 'ORDER BY SUM(scores) DESC '
                    . 'LIMIT 3' );     
            $statistics_tur = $sqlcommand->queryAll();
            
            return $statistics_tur;
        }


        //статистические данные
        
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Forecast the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
