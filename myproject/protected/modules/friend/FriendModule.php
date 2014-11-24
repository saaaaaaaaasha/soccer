<?php

class FriendModule extends CWebModule
{

    public $defaultController = 'my';
    public $userModel = 'User';
    public $viewPath = '/friend/default';
    public $myfriendsUrl = array("/friend/my");
    public $getNameMethod;
    public $getSuggestMethod;
	public function init()
	{

        if (!class_exists($this->userModel)) {
            throw new Exception(MessageModule::t("Class {userModel} not defined", array('{userModel}' => $this->userModel)));
        }

        foreach (array('getNameMethod','getSuggestMethod') as $methodName) {
            if (!$this->$methodName) {
                throw new Exception(MessageModule::t("Property MessageModule::{methodName} not defined", array('{methodName}' => $methodName)));
            }

            if (!method_exists($this->userModel, $this->$methodName)) {
                throw new Exception(MessageModule::t("Method {userModel}::{methodName} not defined", array('{userModel}' => $this->userModel, '{methodName}' => $this->$methodName)));
            }
        }

		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'friend.models.*',
			'friend.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
    public static function t($str='',$params=array(),$dic='friend') {
        return Yii::t("FriendModule.".$dic, $str, $params);
    }
    public function isFriend($friend_id,$user_id,$ajax=false) {
        return Friend::model()->checkFriends($user_id,$friend_id);
    }

    public function isUnread($friend_id,$user_id,$ajax=false) {
        return Friend::model()->checkUnread($user_id,$friend_id);
    }

    public function isFollower($friend_id,$user_id,$ajax=false) {
        return Friend::model()->checkFollower($user_id,$friend_id);
    }

    public function getCountFollowers($userId) {
        return Friend::model()->getCountUnfriends($userId);
    }

    public function getCountFriends($userId) {
        return Friend::model()->getCountFriends($userId);
    }

    public function getCountFollowed($userId) {
        return Friend::model()->getCountFollowed($userId);
    }

    public function getCountNewFollowed($userId) {
        return Friend::model()->getCountNewFollowed($userId);
    }

}
