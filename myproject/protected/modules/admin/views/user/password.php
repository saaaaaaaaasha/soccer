<?php

$this->menu = array(
        array('label'=>'Управление пользователями','url'=>array('index')),
);

if(Yii::app()->user->hasFlash('result')){
   ?>
    <div class="flash-success">
      echo Yii::app()->user->getFlash('result');
    <div>
<?php
}
 else {
    

echo CHtml::form();
echo CHtml::textField('password');
echo CHtml::submitButton('Изменить');
echo CHtml::endForm();
 };