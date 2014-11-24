<?php



$this->pageTitle=$model->title;
?>

<?php $this->renderPartial('_view_', array(
	'data'=>$model,
)); ?>

<?php
    $this->widget('comments.widgets.ECommentsListWidget', array(
       'model' => $model,
     ));
?>