<?php

/**
 * This is the model class for table "{{soccer_player}}".
 *
 * The followings are the available columns in table '{{soccer_player}}':
 * @property integer $id
 * @property string $name
 * @property string $rusname
 * @property integer $country_id
 * @property string $city
 * @property string $photo_img
 * @property string $birth_day
 * @property string $wiki
 * @property integer $number
 * @property string $pos
 * @property string $posmarket
 * @property string $workingleg
 * @property integer $growth
 * @property integer $weight
 * @property integer $price
 * @property integer $f_api_id
 */
class SoccerPlayer extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{soccer_player}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, rusname, country_id, birth_day, number, pos', 'required'),
			array('country_id, number, growth, weight, price, f_api_id', 'numerical', 'integerOnly'=>true),
			array('name, rusname, city, photo_img, pos, posmarket, workingleg', 'length', 'max'=>255),
			array('wiki', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, rusname, country_id, city, photo_img, birth_day, wiki, number, pos, posmarket, workingleg, growth, weight, price, f_api_id', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'rusname' => 'Rusname',
			'country_id' => 'Country',
			'city' => 'City',
			'photo_img' => 'Photo Img',
			'birth_day' => 'Birth Day',
			'wiki' => 'Wiki',
			'number' => 'Number',
			'pos' => 'Pos',
			'posmarket' => 'Posmarket',
			'workingleg' => 'Workingleg',
			'growth' => 'Growth',
			'weight' => 'Weight',
			'price' => 'Price',
			'f_api_id' => 'F Api',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('rusname',$this->rusname,true);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('photo_img',$this->photo_img,true);
		$criteria->compare('birth_day',$this->birth_day,true);
		$criteria->compare('wiki',$this->wiki,true);
		$criteria->compare('number',$this->number);
		$criteria->compare('pos',$this->pos,true);
		$criteria->compare('posmarket',$this->posmarket,true);
		$criteria->compare('workingleg',$this->workingleg,true);
		$criteria->compare('growth',$this->growth);
		$criteria->compare('weight',$this->weight);
		$criteria->compare('price',$this->price);
		$criteria->compare('f_api_id',$this->f_api_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SoccerPlayer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
