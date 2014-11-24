
<?php 
if(!(Yii::app()->user->isGuest))
{        
echo CHtml::ajaxLink("<span class='pic_like'></span>",Yii::app()->urlManager->createUrl('likes/likes/index'), array(
                                        'type' => 'POST',
                                        'data'=>array('owner'=>$model->id, 'owner_name' => get_class($model), 'like_count'=>'js: document.getElementById("like'.$model->id.'").innerHTML'),
                                        'update' => '#like'.$model->id,)
                        ); 
                
               
}
else
{
?><span class='pic_like'></span><?php
}
?>             
               
<span name='like'<?php echo $model->id ?> id='like<?php echo $model->id ?>'><?php echo $coutnlikes ?></span>