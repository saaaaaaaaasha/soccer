<?php
/* @var $this UserController */
/* @var $model User */



$this->menu=array(
	array('label'=>'Управление пользователями', 'url'=>array('index')),
	array('label'=>'Изменить пользователя', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить пользователя', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Вы уверены что хотите удалить пользователя?')),

);
?>

<h1>Пользователь <?php echo $model->username; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'username',
		'email',
		'profile',
		'registration_time',
		'ban',
		'role',
	),
)); ?>
