

<?php

class AddController extends Controller
{
    public $defaultAction = 'index';

    public function actionIndex() {
        if(isset($_POST['addfriend']))
        {
            $user1=Yii::app()->user->id;
            $user2=$_POST['addfriend'];

            //if ()

            $criteria=new CDbCriteria;
            $criteria->condition='user1=:u1 AND user2=:u2 AND relation=:type';
            $criteria->params=array(
                ':u1'=>$user1,
                ':u2'=>$user2,
                ':type'=>Friend::FOLLOWED,
            );
            $count=Friend::model()->count($criteria);

            if ($count>0){

                $criteria=new CDbCriteria;
                $criteria->condition='user1=:u1 AND user2=:u2';
                $criteria->params=array(
                    ':u1'=>$user1,
                    ':u2'=>$user2,
                );

                $model=Friend::model()->find($criteria);
                $model->relation=Friend::FRIEND;
                if($model->validate())
                    $model->save();



                $criteria=new CDbCriteria;
                $criteria->condition='user1=:u2 AND user2=:u1';
                $criteria->params=array(
                    ':u1'=>$user1,
                    ':u2'=>$user2,
                );

                $model=Friend::model()->find($criteria);
                $model->relation=Friend::FRIEND;
                if($model->validate())
                    $model->save();

                echo "now we are friends!";
                /*$model=new Friend;
                $model->user2=$user2;
                $model->user1=$user1;
                $model->relation=Friend::FRIEND;

                if($model->validate())
                    $model->save();
                echo "yes";
                Yii::app()->end();
                //$this->redirect(Yii::app()->user->returnUrl);*/
            }
            else {

                $model=new Friend;
                $model->user2=$user2;
                $model->user1=$user1;
                $model->relation=Friend::SUBSCRIBER;
                $model->isread=Friend::ISNOTREAD;
                if($model->validate())
                    $model->save();

                $model=new Friend;
                $model->user2=$user1;
                $model->user1=$user2;
                $model->isread=Friend::ISNOTREAD;
                $model->relation=Friend::FOLLOWED;
                if($model->validate())
                    if (!$model->save())
                    { print_r($model->getErrors()); exit();}

                echo "I follower to you!";
            }

            Yii::app()->end();
            /*
             *                $model=new Friend;
                $model->user2=$user2;
                $model->user1=$user1;
                $model->relation=Friend::FRIEND;

                if($model->validate())
                    $model->save();
                echo "yes";
                Yii::app()->end();
             */


        }


    }

}