<?php

/**
 * This is the model class for table "{{soccer_coach}}".
 *
 * The followings are the available columns in table '{{soccer_coach}}':
 * @property integer $id
 * @property string $firstname
 * @property string $lastname
 * @property string $rusname
 * @property integer $country_id
 * @property string $photo_img
 * @property string $birth_day
 * @property string $wiki
 */
class SoccerCoach extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{soccer_coach}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rusname', 'required'),
			array('country_id', 'numerical', 'integerOnly'=>true),
			array('firstname, lastname, rusname, photo_img', 'length', 'max'=>255),
			array('wiki', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, firstname, lastname, rusname, country_id, photo_img, birth_day, wiki', 'safe', 'on'=>'search'),
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
            'country' => array(self::BELONGS_TO, 'SoccerCountry', 'country_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'firstname' => 'Firstname',
			'lastname' => 'Lastname',
			'rusname' => 'Rusname',
			'country_id' => 'Country',
			'photo_img' => 'Photo Img',
			'birth_day' => 'Birth Day',
			'wiki' => 'Wiki',
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
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('rusname',$this->rusname,true);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('photo_img',$this->photo_img,true);
		$criteria->compare('birth_day',$this->birth_day,true);
		$criteria->compare('wiki',$this->wiki,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SoccerCoach the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
