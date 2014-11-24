<?php

/**
 * This is the model class for table "{{friend}}".
 *
 * The followings are the available columns in table '{{friend}}':
 * @property string $id
 * @property string $user1
 * @property string $user2
 * @property string $relation
 */
class Friend extends CActiveRecord
{
    const FRIEND = 2;
    const SUBSCRIBER = 0;
    const FOLLOWED=1;

    const ISREAD = 1;
    const ISNOTREAD =0;

    public $friend_index;
    public $userModel;
    public $countFollowers;
    public $countFriends;
    public $countFollowed;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{friend}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user1, user2, relation', 'required'),
			array('user1, user2, relation', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user1, user2, relation', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
        $module = Yii::app()->getModule('friend');

        return array(
            //'friend1' => array(CActiveRecord::BELONGS_TO, $module->userModel, 'user1'),
            'friend' => array(CActiveRecord::BELONGS_TO, $module->userModel, 'user2'),
        );
	}


    public function getFriendName() {
        if ($this->friend) {
            return call_user_func(array($this->friend, Yii::app()->getModule('friend')->getNameMethod));
        }
    }



    public static function getAdapterForFollowers($userId) {
        $user_id= Yii::app()->user->getId();
        $c = new CDbCriteria();
        $c->addCondition('t.relation = 1');
        $c->addCondition('t.user1 = :user_id');
        $c->params = array(
            'user_id' => $user_id,
        );

        $followersProvider = new CActiveDataProvider('Friend', array('criteria' => $c));
        return $followersProvider;
    }


    public static function getAdapterForMyFriends($userId) {
        $user_id= Yii::app()->user->getId();
        $c = new CDbCriteria();
        $c->addCondition('t.relation = 2');
        $c->addCondition('t.user1 = :user_id');
        $c->params = array(
            'user_id' => $user_id,
        );

        //$c->addCondition('t.receiver_id = :receiverId');
        //$c->addCondition('t.deleted_by <> :deleted_by_receiver OR t.deleted_by IS NULL');
        //$c->order = 't.created_at DESC';
        /*$c->params = array(
            'receiverId' => $userId,
            'deleted_by_receiver' => Message::DELETED_BY_RECEIVER,
        );*/
        $friendsProvider = new CActiveDataProvider('Friend', array('criteria' => $c));
        return $friendsProvider;
    }


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user1' => 'User1',
			'user2' => 'User2',
			'relation' => 'Relation',
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
		$criteria->compare('user1',$this->user1,true);
		$criteria->compare('user2',$this->user2,true);
		$criteria->compare('relation',$this->relation,true);
        $criteria->compare('isread',$this->isread,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Friend the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function __construct($scenario = 'insert') {
        $this->userModel = Yii::app()->getModule('friend')->userModel;
        return parent::__construct($scenario);
    }



    public function checkFollower($u1,$u2) {
        $c = new CDbCriteria();
        $c->addCondition('t.user1 = :u1');
        $c->addCondition('t.user2 = :u2');
        $c->addCondition('t.relation = :type');
        $c->params = array(
            'u1' => $u1,
            'u2' => $u2,
            'type' => Friend::SUBSCRIBER,
        );
        $count = self::model()->count($c);
        if($count==0) return false;
        return true;
    }

    public function checkUnread($u1,$u2) {
        $c = new CDbCriteria();
        $c->addCondition('t.user1 = :u1');
        $c->addCondition('t.user2 = :u2');
        $c->addCondition('t.relation = :type');
        $c->addCondition('t.isread = :isread');
        $c->params = array(
            'u1' => $u1,
            'u2' => $u2,
            'type' => Friend::FOLLOWED,
            'isread' => Friend::ISNOTREAD,
        );
        $count = self::model()->count($c);
        if($count==0) return false;
        return true;

    }


    public function checkFriends($u1,$u2) {
        $c = new CDbCriteria();
        $c->addCondition('t.user1 = :u1');
        $c->addCondition('t.user2 = :u2');
        $c->addCondition('t.relation = :type');
        $c->params = array(
            'u1' => $u1,
            'u2' => $u2,
            'type' => Friend::FRIEND,
        );
        $count = self::model()->count($c);
        //$this->unreadMessagesCount = $count;
        if($count==0) return false;
        return true;

    }

    public function getCountFriends($userId) {
        if (!$this->countFriends) {

            $c = new CDbCriteria();
            $c->addCondition('t.user1 = :u1');
            $c->addCondition('t.relation = :type');
            $c->params = array(
                'u1' => $userId,
                'type' => Friend::FRIEND,
            );
            $count = self::model()->count($c);
            $this->countFriends = $count;
        }

        return $this->countFriends;
    }

    public function getCountUnfriends($userId) {
        if (!$this->countFollowers) {

            $c = new CDbCriteria();
            $c->addCondition('t.user1 = :u1');
            $c->addCondition('t.relation = :type');
            $c->params = array(
                'u1' => $userId,
                'type' => Friend::SUBSCRIBER,
            );
            $count = self::model()->count($c);
            $this->countFollowers = $count;
        }

        return $this->countFollowers;
    }

    public function getCountFollowed($userId) {
        if (!$this->countFollowed) {

            $c = new CDbCriteria();
            $c->addCondition('t.user1 = :u1');
            $c->addCondition('t.relation = :type');
            $c->params = array(
                'u1' => $userId,
                'type' => Friend::FOLLOWED,
            );
            $count = self::model()->count($c);
            $this->countFollowed = $count;
        }

        return $this->countFollowed;
    }

    public function getCountNewFollowed($userId) {
        $c = new CDbCriteria();
        $c->addCondition('t.user1 = :u1');
        $c->addCondition('t.relation = :type');
        $c->addCondition('t.isread = :isread');
        $c->params = array(
            'u1' => $userId,
            'type' => Friend::FOLLOWED,
            'isread' => Friend::ISNOTREAD,
        );
        return self::model()->count($c);
    }

}
