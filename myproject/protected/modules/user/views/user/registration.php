
<style>
    .form_reg{
        width:100%;
    }
    .form_reg input[type="text"],.form_reg input[type="password"]{
        display: block;
        width: 200px;
        /*height: 34px;*/
        padding: 3px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
        box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
        -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
        -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    }

    .form_reg input[type="submit"],.form_reg input[type="button"] {
        display: inline-block;
        padding: 3px 12px;
        margin-bottom: 0;
        font-size: 14px;
        font-weight: 400;
        line-height: 1.42857143;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        background-image: none;
        border: 1px solid transparent;
        border-radius: 4px;

        text-shadow: 0 1px 0 #fff;
        background-image: -webkit-linear-gradient(top,#fff 0,#e0e0e0 100%);
        background-image: -o-linear-gradient(top,#fff 0,#e0e0e0 100%);
        background-image: -webkit-gradient(linear,left top,left bottom,from(#fff),to(#e0e0e0));
        background-image: linear-gradient(to bottom,#fff 0,#e0e0e0 100%);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffffff', endColorstr='#ffe0e0e0', GradientType=0);
        filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
        background-repeat: repeat-x;
        border-color: #dbdbdb;
        border-color: #ccc;
    }
</style>


<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Registration");
$this->breadcrumbs=array(
	UserModule::t("Registration"),
);
?>

<h1><?php echo UserModule::t("Registration"); ?></h1>

<?php if(Yii::app()->user->hasFlash('registration')): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash('registration'); ?>
</div>
<?php else: ?>

<div class="form">
<?php $form=$this->beginWidget('UActiveForm', array(
	'id'=>'registration-form',
	'enableAjaxValidation'=>true,
	'disableAjaxValidationAttributes'=>array('RegistrationForm_verifyCode'),
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions' => array('enctype'=>'multipart/form-data','class'=>'form_reg'),
)); ?>



	<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>
	
	<?php echo $form->errorSummary(array($model,$profile)); ?>
	
	<div class="row"></div>
    <div class="row"></div>

    <div class="form-group">
        <div style="padding-top: 4px; float: left; width: 100px;"><?php echo $form->labelEx($model,'username'); ?></div>
        <div class="col-sm-10" style="padding-left:120px;">
            <?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>255,'encode'=>false,'value'=>'','placeholder'=>'Введите логин')); ?>
            <?php echo $form->error($model,'username'); ?>
        </div>
    </div>
    <div class="form-group">
        <div style="padding-top: 4px; float: left; width: 100px;">	<?php echo $form->labelEx($model,'password'); ?></div>
        <div class="col-sm-10" style="padding-left:120px;">
            <?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>255,'encode'=>false,'value'=>'','placeholder'=>'Введите пароль')); ?>
            <?php echo $form->error($model,'password'); ?>
            <p class="hint">
                <?php echo UserModule::t("Minimal password length 4 symbols."); ?>
            </p>
        </div>
    </div>
    <div class="form-group">

        <div class="col-sm-10" style="padding-left:120px;">
            <?php echo $form->passwordField($model,'verifyPassword',array('size'=>60,'maxlength'=>255,'encode'=>false,'value'=>'','placeholder'=>'Введите пароль ещё раз')); ?>
            <?php echo $form->error($model,'verifyPassword'); ?>
        </div>
    </div>
    <div class="form-group">
        <div style="padding-top: 4px; float: left; width: 100px;">E-mail</div>
        <div class="col-sm-10" style="padding-left:120px;">
            <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255,'encode'=>false,'value'=>'','placeholder'=>'Введите свой e-mail')); ?>
            <?php echo $form->error($model,'email'); ?>
        </div>
    </div>

	<!--
	<div class="row">
	<?php //echo $form->labelEx($model,'verifyPassword'); ?>
	<?php //echo $form->passwordField($model,'verifyPassword'); ?>
	<?php //echo $form->error($model,'verifyPassword'); ?>
	</div>
	-->
	
<?php 
		$profileFields=Profile::getFields();
		if ($profileFields) {
			foreach($profileFields as $field) {
			?>
	<div class="row">
		<?php echo $form->labelEx($profile,$field->varname); ?>
		<?php 
		if ($widgetEdit = $field->widgetEdit($profile)) {
			echo $widgetEdit;
		} elseif ($field->range) {
			echo $form->dropDownList($profile,$field->varname,Profile::range($field->range));
		} elseif ($field->field_type=="TEXT") {
			echo$form->textArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
		} else {
			echo $form->textField($profile,$field->varname,array('size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255)));
		}
		 ?>
		<?php echo $form->error($profile,$field->varname); ?>
	</div>	
			<?php
			}
		}
?>
	<?php if (UserModule::doCaptcha('registration')): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'verifyCode'); ?>
		
		<?php $this->widget('CCaptcha'); ?>
		<?php echo $form->textField($model,'verifyCode'); ?>
		<?php echo $form->error($model,'verifyCode'); ?>
		
		<p class="hint"><?php echo UserModule::t("Please enter the letters as they are shown in the image above."); ?>
		<br/><?php echo UserModule::t("Letters are not case-sensitive."); ?></p>
	</div>
	<?php endif; ?>
	
	<div class="row submit">
		<?php echo CHtml::submitButton(UserModule::t("Register")); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
<?php endif; ?>

