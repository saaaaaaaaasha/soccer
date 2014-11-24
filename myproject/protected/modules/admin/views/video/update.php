<?php
/* @var $this VideoController */
/* @var $model Video */

$this->breadcrumbs=array(
	'Videos'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Video', 'url'=>array('index')),
	array('label'=>'Create Video', 'url'=>array('create')),
	array('label'=>'View Video', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Video', 'url'=>array('admin')),
);
?>

<h1>Изменить видео <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form_update', array('model'=>$model)); ?>