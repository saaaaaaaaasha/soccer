<div class="post mainnews">
      
        <div class="layer_main">
            <div class="layer1_pic">
                 <?php echo CHtml::image(Yii::app()->request->baseUrl."/upload/".CHtml::encode($model->image)); ?>
                
            </div>
                
            <div class="layer2_title">
            
                <h1>                
                    <?php echo CHtml::link(CHtml::encode($model->title), $model->url); ?>
                </h1>
            </div>
        
        
        </div>
    
       
    
	<div class="author">           
     		Написал <?php echo $model->author->username . ', ' .  Yii::app()->dateFormatter->format("dd MMMM y", $model->create_time) ?>
	</div>
    
	<div class="content">
		<?php
			$this->beginWidget('CMarkdown', array('purifyOutput'=>true));
			echo $model->preview;                        
                        echo CHtml::link(' читать далее ...', $model->url);
			$this->endWidget();
		?>
	</div>
    
	<div class="nav">
		
		
		<span class="pic_comments"><?php echo $model->commentCount; ?></span> | 
                
                <?php
                    $this->widget('likes.widgets.LikeWidget', array('model'=>$model, ));                    
                ?>
                 
                |
                
                
                <b>Теги:</b>
		<?php echo implode(', ', $model->tagLinks); ?>
		<br/>
		
	</div>
      <br /> <hr />
</div>
