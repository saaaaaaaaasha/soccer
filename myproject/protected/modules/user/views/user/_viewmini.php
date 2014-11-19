
<li class="user">
<div class="useravatar">
    <?php echo CHtml::link(($data->profile->avatar)?CHtml::image(Yii::app()->baseUrl."/".$data->profile->avatar):CHtml::image(Yii::app()->baseUrl."/".'images/noavatar.gif'),array("user/view","id"=>$data->id)); ?>
</div>
<div class="userlogin">
    <?php echo CHtml::link(CHtml::encode(Yii::app()->getModule('user')->getName($data->id)),array("user/view","id"=>$data->id)) ?>
</div>
</li>