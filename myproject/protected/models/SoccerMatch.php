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
}
