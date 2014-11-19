

<?php

class DeleteController extends Controller
{
    public $defaultAction = 'index';

    public function actionIndex() {
        if(isset($_POST['deletefriend']))
        {
            $user1=Yii::app()->user->id;
            $user2=$_POST['deletefriend'];

            $criteria=new CDbCriteria;
            $criteria->condition='user1=:u1 AND user2=:u2';
            $criteria->params=array(
                ':u1'=>$user1,
                ':u2'=>$user2,
            );

            $model=Friend::model()->find($criteria);
            $model->relation=Friend::FOLLOWED;
            if($model->validate())
                $model->save();



            $criteria=new CDbCriteria;
            $criteria->condition='user1=:u2 AND user2=:u1';
            $criteria->params=array(
                ':u1'=>$user1,
                ':u2'=>$user2,
            );

            $model=Friend::model()->find($criteria);
            $model->relation=Friend::SUBSCRIBER;
            if($model->validate())
                $model->save();

            echo "I delete you!";
            Yii::app()->end();


        }


    }

}