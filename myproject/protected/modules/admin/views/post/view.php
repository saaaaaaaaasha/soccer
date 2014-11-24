<?php

$this->menu=array(
    array('label'=>'Управление сообщениями','url'=>array('index')),
);

$this->pageTitle=$model->title;
?>

<?php $this->renderPartial('_view', array(
	'data'=>$model,
)); ?>

<?php
    $this->widget('comments.widgets.ECommentsListWidget', array(
       'model' => $model,
     ));
?>