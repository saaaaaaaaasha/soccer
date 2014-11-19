<?php

class MyController extends Controller
{
    public $defaultAction = 'index';

    public function actionIndex() {

        //$model= new Friend;

        $friendsAdapter = Friend::getAdapterForMyFriends(Yii::app()->user->getId());
        $pager = new CPagination($friendsAdapter->totalItemCount);
        $pager->pageSize = 10;
        $friendsAdapter->setPagination($pager);

        $followersAdapter = Friend::getAdapterForFollowers(Yii::app()->user->getId());
        $pager = new CPagination($followersAdapter->totalItemCount);
        $pager->pageSize = 10;
        $followersAdapter->setPagination($pager);

        //$this->_model=Friend::model()->findbyPk($id!==null ? $id : $_GET['id']);


        $this->render(Yii::app()->getModule('friend')->viewPath . '/my', array(
            'friendsAdapter' => $friendsAdapter,
            'followersAdapter' => $followersAdapter,
        ));
    }

}