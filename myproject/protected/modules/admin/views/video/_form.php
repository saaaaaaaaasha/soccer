<?php
/* @var $this VideoController */
/* @var $model Video */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'video-form',
        'htmlOptions'=>array('enctype'=>'multipart/form-data'),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля, отмеченные <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>
 
        
	<div class="row">
		<?php echo $form->labelEx($model,'video'); ?>
                <?php echo $form->fileField($model, 'video');?>
		<?php echo $form->error($model,'video'); ?>
	</div>

        <div class="row">
		<?php echo $form->labelEx($model,'image'); ?>
                <?php echo $form->fileField($model, 'image');?>
		<?php echo $form->error($model,'image'); ?>
	</div>
        
	<div class="row">
		<?php echo $form->labelEx($model,'text'); ?>
		<?php echo $form->textArea($model,'text',array('rows'=>6, 'cols'=>50)); ?>              
		<?php echo $form->error($model,'text'); ?>
	</div>

        
        <?php /*
        echo CHtml::form('','post',array('enctype'=>'multipart/form-data')); 
 echo CHtml::activeFileField($model, 'image'); 
 echo CHtml::endForm();*/ ?>
        
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->