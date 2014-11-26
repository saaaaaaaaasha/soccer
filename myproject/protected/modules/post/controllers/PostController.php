<?php

class PostController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='/layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
                return array(
                    array('allow',  // позволим всем пользователям выполнять действия 'list' и 'show'
                        'actions'=>array('index', 'view'),
                        'users'=>array('*'),
                    ),
                    array('allow', // позволим аутентифицированным пользователям выполнять любые действия
                        'users'=>array('@'),
                    ),
                    array('deny',  // остальным запретим всё
                        'users'=>array('*'),
                    ),
                );
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
                      
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	
	public function actionIndex()
	{
            
		$criteria = new CDbCriteria(array(
                    'order'=>'update_time DESC',                    
                ));
                
                if(isset($_GET['tag'])){
                    $criteria->addSearchCondition('tags',$_GET['tag']);
                 
                }
                $model = Post::model()->find($criteria);
                               
                $criteria=new CDbCriteria(array(
                    'condition'=>'status='.Post::STATUS_PUBLISHED.' AND id<>:id',
                    'order'=>'update_time DESC',
                    'with'=>'commentCount',
                    'params'=>array(':id'=>$model->id),
                ));
                if(isset($_GET['tag'])){
                    $criteria->addSearchCondition('tags',$_GET['tag']);
                  
                
                }
                
                $dataProvider=new CActiveDataProvider('Post', array(
                    'pagination'=>array(
                        'pageSize'=>4
                    ),
                    'criteria'=>$criteria,
                ));

                $this->render('index',array(
                    'dataProvider'=>$dataProvider,'model'=>$model,
                ));
        }

        
        public function loadModel($id)
	{
		$model=Post::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
        
        public function actionSearch($find){
            
            $find = strip_tags(trim($find));
             $criteria=new CDbCriteria(array(
                    'condition'=>'status='.Post::STATUS_PUBLISHED. " and content LIKE :find",
                    'order'=>'update_time DESC',
                    'with'=>'commentCount',
                    'params'=>array(':find'=>"%$find%"),
                ));
                           
         
                          
                $dataProvider=new CActiveDataProvider('Post', array(
                    'pagination'=>array(
                        'pageSize'=>4
                    ),
                    'criteria'=>$criteria,
                ));

                var_dump($dataProvider->data);
                
                $this->render('search',array(
                    'dataProvider'=>$dataProvider
                ));
            
           // echo $find;
        }

	/**
	 * Performs the AJAX validation.
	 * @param Post $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='post-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
