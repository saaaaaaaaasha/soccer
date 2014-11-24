<?php

class LikesController extends Controller
{
	public function actionIndex()
	{          
            
                $owner =  Yii::app()->request->getPost('owner'); 
                $owner_name =  Yii::app()->request->getPost('owner_name'); 
                $like_count = Yii::app()->request->getPost('like_count');
                
                
                
                
                if(Yii::app()->user->isGuest)
                {
                    echo CHtml::encode($like_count);
                    Yii::app()->end(); 
                }
                
                if(Yii::app()->request->isAjaxRequest){
                   
                                      
                    
                    $n = Likes::model()->like($owner, $owner_name, Yii::app()->user->id);
                    
                       
                    
                    if($n>0)
                    {
                      
                        $criteria = new CDbCriteria;
                        $criteria->condition = "owner_id = :owner_id AND user_id = :user_id AND owner_name = :owner_name";
                        $criteria->params = array(':owner_id'=> $owner, 
                                                  ':user_id'=> Yii::app()->user->id,
                                                  ':owner_name'=>$owner_name,
                                );
                        Likes::model()->deleteAll($criteria);   
                        $like_count-=1;
                    }
                    else {
                        
                        $modellike = new Likes();
                        $modellike->owner_id = $owner;
                        $modellike->user_id = Yii::app()->user->id;
                        $modellike->owner_name = $owner_name;
                        $modellike->save();    
                        $like_count+=1;
                          /*echo CHtml::encode($owner_name);
                    // Завершаем приложение
                    Yii::app()->end();  */
                             
                    }
                                        
                                        
                    echo CHtml::encode($like_count);
                    // Завершаем приложение
                    Yii::app()->end();            
                }
            
        }
}