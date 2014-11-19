<?php

/**
 * This is the model class for table "{{mchat}}".
 *
 * The followings are the available columns in table '{{mchat}}':
 * @property string $id
 * @property string $user
 * @property string $text
 * @property string $date
 */
class MChat2 extends CActiveRecord
{
    public static $N=50; //count of message
    public $userModel;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mchat}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, text, date', 'required'),
			array('user_id', 'length', 'max'=>11),
			array('id, user_id, text, date', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
        $module = Yii::app()->getModule('mchat');
        return array(
            //'friend1' => array(CActiveRecord::BELONGS_TO, $module->userModel, 'user1'),
            'user' => array(CActiveRecord::BELONGS_TO, $module->userModel, 'user_id'),
        );
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'Пользователь',
			'text' => 'Текст',
			'date' => 'Дата',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('date',$this->date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Mchat the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function __construct($scenario = 'insert') {
        $this->userModel = Yii::app()->getModule('mchat')->userModel;
        return parent::__construct($scenario);
    }

    public static function getAdapterForMessage() {
        $c = new CDbCriteria();
        $c->order = "date desc";
        $c->limit = self::$N ;

        $messProvider = new CActiveDataProvider('Mchat', array('criteria' => $c));
        return $messProvider;
    }



}
