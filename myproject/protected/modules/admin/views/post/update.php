<?php
$this->breadcrumbs=array(
	$model->title=>$model->url,
	'Изменить',
);

$this->menu=array(
    array('label'=>'Управление сообщениями','url'=>array('index')),
);
        

?>

<h1><i><?php echo CHtml::encode($model->title); ?></i></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>