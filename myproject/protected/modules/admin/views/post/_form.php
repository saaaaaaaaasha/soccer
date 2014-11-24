<div class="form">

<?php $form=$this->beginWidget('CActiveForm'); ?>

	<p class="note">Поля, отмеченные<span class="required">*</span> обязательны для заполнения.</p>

	<?php echo CHtml::errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>80,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

               
	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>			
               
               <?php $this->widget('application.extensions.ckeditor.CKEditor', 
                       array( 
                           'model'=>$model, 
                           'attribute'=>'content', 
                           'language'=>'ru', 
                           'editorTemplate'=>'advanced',
                           'plugins' => array('pagecut'),
                           'toolbar'=>array(
                                        array( 'Source','-', 'Pagecut'),
                                        array( 'Image', 'Link', 'Unlink', 'Anchor' ),
                                        array( 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'),
                                        array( 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt'),
                                        array( 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat'),
                                        array( 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ),
                                        array( 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ),    
                                        array( 'Styles', 'Format', 'Font', 'FontSize'), 
                                        array( 'TextColor', 'BGColor' ),
                                        array( 'Maximize', 'ShowBlocks' ),
                                            ),
                           )); ?> 
           
        </div>
        

	<div class="row">
		<?php echo $form->labelEx($model,'tags'); ?>
		<?php $this->widget('CAutoComplete', array(
			'model'=>$model,
			'attribute'=>'tags',
			'url'=>array('suggestTags'),
			'multiple'=>true,
			'htmlOptions'=>array('size'=>50),
		)); ?>
		<p class="hint">Пожалуйста, разделяйте различные теги запятыми.</p>
		<?php echo $form->error($model,'tags'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',Lookup::items('PostStatus')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->