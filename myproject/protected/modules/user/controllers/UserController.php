<?php

class UserController extends Controller
{
	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;
    public $layout='//layouts/column2';
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return CMap::mergeArray(parent::filters(),array(
			'accessControl', // perform access control for CRUD operations
		));
	}
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','online'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}	

	/**
	 * Displays a particular model.
	 */

    public function actionOnline(){

        //$profile->last_activity=strtotime("now");
        //$criteria=New CDbCritieria;
        //$criteria->condition='status=1';

        $time=strtotime('-15 minutes');//-3600;
        if (isset($_GET['action']) && $_GET['action']=="count"){

            $listing = User::model()->with(array('profile'/*=>array('first_name'=>'julia')*/))->FindAll(
                array('condition'=>"last_activity>:time", 'params'=>array(":time"=>$time),'limit'=>16)
            );
            if (count($listing)==0) {
                echo "0";
            }
            else {
            echo "<span>Онлайн ".count($listing)." ". Yii::t('yii','пользователь|пользователя|пользователей',count($listing)).":</span>";
            echo "<ul class=\"userlist_mini\">";
            foreach($listing as $user){
                //echo $user->profile->firstname."**<br>";
                $this->renderPartial("/user/_viewmini",array('data'=>$user));
            }
            echo "</ul>";
            }
            Yii::app()->end();
        }
        else {
            $dataProvider=new CActiveDataProvider('User',
                array(
                    'pagination'=>array('pageSize'=>12),
                    'criteria'=>array(
                        'with'=>array(
                            'profile' => array('alias' => 'pu')
                        ),
                        'condition' => ' profile.last_activity>'.$time,
                        //'distinct'=>true,
                        'together'=>true,
                    ),
                )
            );

            $this->render('online',array(
            'model'=>$dataProvider,
            'count'=>count($dataProvider),
            ));
        }

        //echo $listing;

        /*$this->render('online',array(
            'model'=>$listing,
            'count'=>count($listing),
        ));*/

         /*ByAttributes(
            array(
                'condition' =>'id > :id',
                'params'=>array(':id'=> 5),
            )
        );*/

    //print_r($listing);


       // $user_online = User::model()->findByAttributes(
            //array('first_name'=>$firstName,'last_name'=>$lastName),
        //    $criteria
        //);
        //$model = $this->loadModel();
        //$model->profile->last_activity=strtotime("now");
        //$model->save();
        //echo

    }

	public function actionView()
	{
		$model = $this->loadModel();

		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('User', array(
			'criteria'=>array(
		        'condition'=>'status>'.User::STATUS_BANNED,
		    ),
				
			'pagination'=>array(
				'pageSize'=>Yii::app()->controller->module->user_page_size,
			),
		));

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=User::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadUser($id=null)
	{
		if($this->_model===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_model=User::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
}
