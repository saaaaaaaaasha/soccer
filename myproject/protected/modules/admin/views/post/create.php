<?php
$this->breadcrumbs=array(
	'Новый пост',
);

$this->menu=array(
    array('label'=>'Управление сообщениями','url'=>array('index')),
);
        

?>
<h1>Новый пост</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>