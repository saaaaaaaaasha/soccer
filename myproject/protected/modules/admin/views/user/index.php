<?php
/* @var $this UserController */
/* @var $model User */


$this->menu=array(
	array('label'=>'Список пользователей', 'url'=>array('index')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#user-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление пользователями</h1>


<?php echo CHtml::link('Расширенны поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'username',		
		'email',
		'profile',
                
		'registration_time' => array(
                    'name'=> 'registration_time',
                    'value'=> 'Yii::app()->dateFormatter->format("dd.MM.y", $data->registration_time)',
                    'filter'=>false,),
                'role'=> array(
                    'name'=>'role',
                    'value'=>'($data->role==0)?"user":"admin"',
                    'filter'=>array(0=>'user',1=>'admin'),
                ),
		'ban' => array(
                    'name'=> 'ban',
                    'value'=>'($data->ban==1)?"бан":""',                    
                    'filter'=>array(0=>'нет', 1=>'да'),
                ),
			
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
