<?php
/* @var $this VideoController */
/* @var $model Video */

$this->breadcrumbs=array(
	'Videos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Управление видtо', 'url'=>array('index')),
);
?>

<h1>Добавить видео</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>