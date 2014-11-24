<?php

/**
 * This is the model class for table "{{likes}}".
 *
 * The followings are the available columns in table '{{likes}}':
 * @property integer $id
 * @property integer $post_id
 * @property integer $user_id
 */
class Likes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{likes}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('owner_id, user_id, owner_name', 'required'),
			array('owner_id, user_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, owner_id, user_id , owner_name', 'safe', 'on'=>'search'),
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
			'owner_id' => 'Owner',
			'user_id' => 'User',
                        'owner_name'=>'owner_name',
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
		$criteria->compare('owner_id',$this->owner_id);
		$criteria->compare('user_id',$this->user_id);
                $criteria->compare('owner_name',$this->owner_name);
                

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        public static function like($owner = null,  $owner_name =null, $user_id = null)
        {
            
            
            $criteria = new CDbCriteria;
            
            
           
            if($user_id==null)
            {
                $criteria->condition = "owner_id = :owner_id and owner_name = :owner_name";
                $criteria->params = array(':owner_id'=> $owner, ':owner_name'=>$owner_name);
                
            }
            else{
                $criteria->condition = "owner_id = :owner_id AND user_id = :user_id AND owner_name = :owner_name";
                $criteria->params = array(':owner_id'=> $owner, 
                                          ':user_id'=> $user_id, 
                                          ':owner_name'=>$owner_name);
                
            }
                        
            
           
                        
            $n= self::model()->count($criteria);
                       
            return $n;
                      
            
        }
        
        /**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Likes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
