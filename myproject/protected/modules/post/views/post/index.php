<?php if(!empty($_GET['tag'])): ?>
<h1>Сообщения с тегом <i><?php echo CHtml::encode($_GET['tag']); ?></i></h1>
<?php endif; ?>

 <?php
    $this->renderPartial('view_main_news',array(
			'model'=>$model,
		));
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'template'=>"{items}\n{pager}",
)); 