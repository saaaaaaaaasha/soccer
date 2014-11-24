<div class="post newsline">
	<video width="350" height="250" controls="controls">
                 <source src="<?php echo Yii::app()->request->baseUrl; ?>/upload/<?php echo CHtml::encode($data->path); ?>" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
            </video>       
    
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