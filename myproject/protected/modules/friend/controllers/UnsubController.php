

<?php

class UnsubController extends Controller
{
    public $defaultAction = 'index';

    public function actionIndex() {
        if(isset($_POST['unsubfriend']))
        {
            $user1=Yii::app()->user->id;
            $user2=$_POST['unsubfriend'];

            $criteria=new CDbCriteria;
            $criteria->condition='(user1=:u1 AND user2=:u2) OR (user1=:u2 AND user2=:u1)';
            $criteria->params=array(
                ':u1'=>$user1,
                ':u2'=>$user2,
            );
            echo Friend::model()->deleteAll($criteria);
            echo "now we are enemies, dog!";
            Yii::app()->end();


        }


    }

}