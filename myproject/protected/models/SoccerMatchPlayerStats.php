<?php

/**
 * This is the model class for table "{{soccer_match_player_stats}}".
 *
 * The followings are the available columns in table '{{soccer_match_player_stats}}':
 * @property integer $id
 * @property integer $match_id
 * @property integer $player_id
 * @property string $pos
 * @property integer $shot_total
 * @property integer $shots_on_goal
 * @property integer $goals
 * @property integer $assists
 * @property integer $offsides
 * @property integer $fouls_drawn
 * @property integer $fouls_commited
 * @property integer $saves
 * @property integer $yellowcards
 * @property integer $redcards
 * @property integer $pen_score
 * @property integer $pen_miss
 * @property integer $team
 */
class SoccerMatchPlayerStats extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{soccer_match_player_stats}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('match_id, player_id, team', 'required'),
			array('match_id, player_id, shot_total, shots_on_goal, goals, assists, offsides, fouls_drawn, fouls_commited, saves, yellowcards, redcards, pen_score, pen_miss, team', 'numerical', 'integerOnly'=>true),
			array('pos', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, match_id, player_id, pos, shot_total, shots_on_goal, goals, assists, offsides, fouls_drawn, fouls_commited, saves, yellowcards, redcards, pen_score, pen_miss, team', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'match_id' => 'Match',
			'player_id' => 'Player',
			'pos' => 'Pos',
			'shot_total' => 'Shot Total',
			'shots_on_goal' => 'Shots On Goal',
			'goals' => 'Goals',
			'assists' => 'Assists',
			'offsides' => 'Offsides',
			'fouls_drawn' => 'Fouls Drawn',
			'fouls_commited' => 'Fouls Commited',
			'saves' => 'Saves',
			'yellowcards' => 'Yellowcards',
			'redcards' => 'Redcards',
			'pen_score' => 'Pen Score',
			'pen_miss' => 'Pen Miss',
			'team' => 'Team',
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
		$criteria->compare('match_id',$this->match_id);
		$criteria->compare('player_id',$this->player_id);
		$criteria->compare('pos',$this->pos,true);
		$criteria->compare('shot_total',$this->shot_total);
		$criteria->compare('shots_on_goal',$this->shots_on_goal);
		$criteria->compare('goals',$this->goals);
		$criteria->compare('assists',$this->assists);
		$criteria->compare('offsides',$this->offsides);
		$criteria->compare('fouls_drawn',$this->fouls_drawn);
		$criteria->compare('fouls_commited',$this->fouls_commited);
		$criteria->compare('saves',$this->saves);
		$criteria->compare('yellowcards',$this->yellowcards);
		$criteria->compare('redcards',$this->redcards);
		$criteria->compare('pen_score',$this->pen_score);
		$criteria->compare('pen_miss',$this->pen_miss);
		$criteria->compare('team',$this->team);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SoccerMatchPlayerStats the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
