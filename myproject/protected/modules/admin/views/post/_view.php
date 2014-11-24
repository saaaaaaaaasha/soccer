<div class="post">
	<div class="title">
            <h1>                
		<?php echo CHtml::link(CHtml::encode($data->title), $data->url); ?>
            </h1>
	</div>
	<div class="author">
           
     		Написал <?php echo $data->author->username . ', ' .  Yii::app()->dateFormatter->format("dd MMMM y", $data->create_time) ?>
	</div>
	<div class="content">
		<?php
			$this->beginWidget('CMarkdown', array('purifyOutput'=>true));
			echo $data->content;
			$this->endWidget();
		?>
	</div>
	<div class="nav">
		<b>Теги:</b>
		<?php echo implode(', ', $data->tagLinks); ?>
		<br/>
		<?php echo CHtml::link('Ссылка', $data->url); ?> |
		<?php echo CHtml::link("Комментарии ({$data->commentCount})",$data->url.'#comments'); ?> |
		Последние изменения: <?php echo Yii::app()->dateFormatter->format("dd MMMM y", $data->update_time); ?>
	</div>
    
</div>
