<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{

        $criteria=new CDbCriteria(array(
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
        ));


        /*$messageAdapter = MChat::getAdapterForMessage();
        print_r($messageAdapter);*/
        //$this->_model=Friend::model()->findbyPk($id!==null ? $id : $_GET['id']);

        /*$this->render(Yii::app()->getModule('mchat')->viewPath . '/default', array(
            'messageAdapter' => $messageAdapter,
        ));*/
/*
		$this->renderPartial('index', array(
            'messages' => $messageAdapter,
        ));*/
	}

}