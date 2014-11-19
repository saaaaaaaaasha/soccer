<?php

class AddController extends Controller
{
    public function actionIndex()
    {
        //echo "yes";
        //$input = Yii::app()->request->getPost('input');
        //$output = mb_strtoupper($input, 'utf-8');
        $model=new MChat;
        echo Yii::app()->request->getPost('text')."<br>\n\r ";
        $model->text=Yii::app()->request->getPost('text');
        $model->user_id = Yii::app()->user->getId();
        $model->date = Date('Y-m-d H:i:s');
        if($model->save()){
            echo "yes";
        }
        else
            echo "no";

       // if(!$model->save())
       ///     print_r($model->getErrors());

        Yii::app()->end();
// если запрос асинхронный, то нам нужно отдать только данные
        //if(Yii::app()->request->isAjaxRequest){
            //echo CHtml::encode($output);
            // Завершаем приложение

        //}

       /* $criteria=new CDbCriteria(array(
            //'condition'=>'user_id>0',
            'order'=>'date DESC',
            'with'=>'user',
            'limit'=>50,
        ));

        $dataProvider=new CActiveDataProvider('Mchat', array(
            'criteria'=>$criteria,
        ));

        $this->renderPartial('index',array(
            'dataProvider'=>$dataProvider,
        ));*/
    }

}