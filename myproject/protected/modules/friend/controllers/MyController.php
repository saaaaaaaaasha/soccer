<?php

class MyController extends Controller
{
    public $defaultAction = 'index';
    public $layout= '//layouts/column2';

    public function actionFollowed() {

        if (Yii::app()->user->isGuest) $this->redirect(Yii::app()->homeUrl);
        $id=Yii::app()->user->getId();
        $dataProvider=new CActiveDataProvider('User',
            array(
                'pagination'=>array('pageSize'=>10),
                'criteria'=>array(
                    'with'=>array(
                        'friend' => array('alias' => 'pu')
                    ),
                    'condition' => ' pu.user1='.$id.' AND pu.relation=1',
                    'order' => 'pu.isread ASC',
                    //'distinct'=>true,
                    'together'=>true,
                ),
            )
        );
        $countFolloweds=Yii::app()->getModule('friend')->getCountFollowed($id);
        $this->render('//../modules/friend/views/friend/default/myfollowed',array(
            'dataProvider'=>$dataProvider,
            'countUser'=>$countFolloweds,
        ));
    }

    public function actionFollowers() {

        if (Yii::app()->user->isGuest) $this->redirect(Yii::app()->homeUrl);
        $id=Yii::app()->user->getId();
        $dataProvider=new CActiveDataProvider('User',
            array(
                'pagination'=>array('pageSize'=>10),
                'criteria'=>array(
                    'with'=>array(
                        'friend' => array('alias' => 'pu')
                    ),
                    'condition' => ' pu.user1='.$id.' AND pu.relation=0',
                    //'distinct'=>true,
                    'together'=>true,
                ),
            )
        );
        $countFollowers=Yii::app()->getModule('friend')->getCountFollowers($id);
        $this->render('//../modules/friend/views/friend/default/myfollowers',array(
            'dataProvider'=>$dataProvider,
            'countUser'=>$countFollowers,
        ));
    }

    public function actionIndex() {

        if (Yii::app()->user->isGuest) $this->redirect(Yii::app()->homeUrl);
        $id=Yii::app()->user->getId();
        $dataProvider=new CActiveDataProvider('User',
            array(
                'pagination'=>array('pageSize'=>10),
                'criteria'=>array(
                    'with'=>array(
                        'friend' => array('alias' => 'pu')
                    ),
                    'condition' => ' pu.user1='.$id.' AND pu.relation=2',
                    //'distinct'=>true,
                    'together'=>true,
                ),
            )
        );
        $countFriends=Yii::app()->getModule('friend')->getCountFriends($id);
        //$this->render('//../modules/friend/views/friend/default/my',array(
        $this->render(Yii::app()->getModule('friend')->viewPath . '/my',array(
            'dataProvider'=>$dataProvider,
            'countFriends'=>$countFriends,
        ));


        //$model= new Friend;
        /*$dataProvider=new CActiveDataProvider('User', array(
            'criteria'=>array(
                'condition'=>'status>'.User::STATUS_BANNED,
            ),

            'pagination'=>array(
                'pageSize'=>Yii::app()->controller->module->user_page_size,
            ),
        ));

        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));*/

        /*
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
        ));*/
    }

}