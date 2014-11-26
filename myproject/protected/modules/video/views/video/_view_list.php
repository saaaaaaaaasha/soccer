<div class="post newsline">
	
        <div class="layer_main_video">
            <div class="layer1_video">
               <?php echo CHtml::image(Yii::app()->request->baseUrl."/upload/".CHtml::encode($data->image_name)); ?> 
            </div>            
           <a href="video/view/id/<?php echo $data->id; ?>">  <div class="layer2_video"> </div>    </a>
            
        </div>
      
        <div class="title">
            
            <h3>                
		<?php echo CHtml::link(CHtml::encode($data->title), array('view', 'id'=>$data->id)); ?>
            </h3>
	</div>
    
	<div class="author">
           
     		Добавил <?php echo $data->author->username . ', ' .  Yii::app()->dateFormatter->format("dd MMMM y", $data->create_time) ?>
	</div>
	<div class="content">
        
            <?php echo CHtml::encode($data->text); ?>

        </div>
	    
       
        <div class="clear"></div>
        
         <div class="nav">	
             <span class="pic_comments"><?php echo CHtml::link("{$data->commentCount}",array('view', 'id'=>$data->id)); ?> </span> | 
                
                <?php
                    $this->widget('likes.widgets.LikeWidget', array('model'=>$data, ));                     
                ?>
	</div>
        
        <br /> <hr />
</div>