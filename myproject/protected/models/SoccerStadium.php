<?php

/**
 * This is the model class for table "{{soccer_stadium}}".
 *
 * The followings are the available columns in table '{{soccer_stadium}}':
 * @property integer $id
 * @property string $name
 * @property integer $country_id
 * @property string $city
 * @property integer $capacity
 * @property string $field_size
 * @property string $photo_img
 * @property string $founded
 * @property string $wiki
 * @property string $map
 */

class SoccerStadium extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{soccer_stadium}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, country_id', 'required'),
			array('country_id, capacity', 'numerical', 'integerOnly'=>true),
			array('name, city, field_size, photo_img', 'length', 'max'=>255),
			array('founded, wiki, map', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, country_id, city, capacity, field_size, photo_img, founded, wiki, map', 'safe', 'on'=>'search'),
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
			'country_id' => 'Country',
			'city' => 'City',
			'capacity' => 'Capacity',
			'field_size' => 'Field Size',
			'photo_img' => 'Photo Img',
			'founded' => 'Founded',
			'wiki' => 'Wiki',
			'map' => 'Map',
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
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('capacity',$this->capacity);
		$criteria->compare('field_size',$this->field_size,true);
		$criteria->compare('photo_img',$this->photo_img,true);
		$criteria->compare('founded',$this->founded,true);
		$criteria->compare('wiki',$this->wiki,true);
		$criteria->compare('map',$this->map,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SoccerStadium the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
