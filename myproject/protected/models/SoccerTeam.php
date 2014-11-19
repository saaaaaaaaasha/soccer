<?php

/**
 * This is the model class for table "{{soccer_team}}".
 *
 * The followings are the available columns in table '{{soccer_team}}':
 * @property integer $id
 * @property string $name
 * @property string $rusname
 * @property string $logo_img
 * @property string $kits_img
 * @property integer $f_api_id
 * @property string $founded
 * @property string $site
 * @property string $phone
 */
class SoccerTeam extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{soccer_team}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, rusname, logo_img', 'required'),
			array('f_api_id', 'numerical', 'integerOnly'=>true),
			array('name, rusname, logo_img, kits_img, founded, site, phone', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, rusname, logo_img, kits_img, f_api_id, founded, site, phone', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'rusname' => 'Rusname',
			'logo_img' => 'Logo Img',
			'kits_img' => 'Kits Img',
			'f_api_id' => 'F Api',
			'founded' => 'Founded',
			'site' => 'Site',
			'phone' => 'Phone',
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
		$criteria->compare('logo_img',$this->logo_img,true);
		$criteria->compare('kits_img',$this->kits_img,true);
		$criteria->compare('f_api_id',$this->f_api_id);
		$criteria->compare('founded',$this->founded,true);
		$criteria->compare('site',$this->site,true);
		$criteria->compare('phone',$this->phone,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SoccerTeam the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
