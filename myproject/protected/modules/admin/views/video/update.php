<?php
/* @var $this VideoController */
/* @var $model Video */

$this->breadcrumbs=array(
	'Videos'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Управление видео', 'url'=>array('index')),
	
);
?>

<h1>Изменить видео <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form_update', array('model'=>$model)); ?>