<?php

/**
 * This is the model class for table "{{video}}".
 *
 * The followings are the available columns in table '{{video}}':
 * @property integer $id
 * @property string $title
 * @property string $text
 * @property string $path
 * @property integer $author_id
 * @property integer $create_time
 *
 * The followings are the available model relations:
 * @property User $author
 */
class Video extends CActiveRecord
{
        public $video;
    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{video}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(                        
                        array('video','file', 'types'=>'mp4','maxSize' => 100000000,'on'=>'create'),
			array('title, text', 'required'),
			array('author_id, create_time', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, text, path, author_id, create_time', 'safe', 'on'=>'search'),
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
			'author' => array(self::BELONGS_TO, 'User', 'author_id'),
                        'comments' => array(self::HAS_MANY, 'Comment', 'owner_id'),
			'commentCount' => array(self::STAT, 'Comment', 'owner_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Заголовок',
			'text' => 'Описание',
			'path' => 'Путь',
			'author_id' => 'Автор',
			'create_time' => 'Создан',
                        'author' => 'Автор',
                        'video' => 'Видео',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('path',$this->path,true);
		$criteria->compare('author_id',$this->author_id);
		$criteria->compare('create_time',$this->create_time);         
                $criteria->with= array('author');
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        public function beforeSave() {
            if(parent::beforeSave()){
                if($this->isNewRecord)
                {
                    $this->create_time= time();
                    $this->author_id = Yii::app()->user->id;  
                }
                    return true;
                }
            else
            { return false;}
         }
        


        /**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Video the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
