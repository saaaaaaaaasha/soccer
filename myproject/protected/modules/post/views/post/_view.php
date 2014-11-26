<div class="post newsline">
	<?php echo CHtml::image(Yii::app()->request->baseUrl."/upload/".CHtml::encode($data->image)); ?>       
        <div class="title">
            
            <h3>                
		<?php echo CHtml::link(CHtml::encode($data->title), $data->url); ?>
            </h3>
	</div>
	<div class="author">
           
     		Написал <?php echo $data->author->username . ', ' .  Yii::app()->dateFormatter->format("dd MMMM y", $data->create_time) ?>
	</div>
	<div class="content">
		<?php
                $this->beginWidget('CMarkdown', array('purifyOutput'=>true));
		    echo $data->preview;
                    echo CHtml::link(' читать далее ...', $data->url);
                $this->endWidget();
		?>
        </div>
	<div class="nav">
            <span class="pic_comments"><?php echo $data->commentCount; ?></span> | 
                
                <?php
                    $this->widget('likes.widgets.LikeWidget', array('model'=>$data, ));                    
                ?>
                 
                |
                
                
                <b>Теги:</b>
		<?php echo implode(', ', $data->tagLinks); ?>
		<br/>
	</div>
        <div class="clear"></div>
        <br /> <hr />

</div>
