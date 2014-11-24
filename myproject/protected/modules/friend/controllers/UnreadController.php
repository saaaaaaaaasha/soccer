

<?php

class UnreadController extends Controller
{
    public $defaultAction = 'index';

    public function actionIndex() {
        if(isset($_POST['readfriend']))
        {
            $user1=Yii::app()->user->id;
            $user2=$_POST['readfriend'];

            $criteria=new CDbCriteria;
            $criteria->condition='user1=:u1 AND user2=:u2';
            $criteria->params=array(
                ':u1'=>$user1,
                ':u2'=>$user2,
            );

            $model=Friend::model()->find($criteria);

            $model->isread=Friend::ISREAD;
            if($model->validate())
                $model->save();

            Yii::app()->end();
        }


    }

}