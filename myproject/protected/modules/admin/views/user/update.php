<?php
/* @var $this UserController */
/* @var $model User */


$this->menu=array(
	array('label'=>'Список пользователей', 'url'=>array('index')),
	array('label'=>'Проспотр пользователя', 'url'=>array('view', 'id'=>$model->id)),
        array('label'=>'Именить пароль', 'url'=>array('password','id'=>$model->id)),
);
?>

<h1>Изменение пользователя <?php echo $model->username; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>