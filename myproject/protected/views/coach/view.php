<?php
$this->layout='//layouts/column1';
$this->setPageTitle($model->rusname);
?>

<?php $this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Главная', 'url' => array('')),
        array('name' => 'Информация о тренере', 'url' => array('/coach/')),
        array('name' => $model->rusname),
    )
)); ?>


<h1 class="h1content"><?php echo 'Тренер <strong>«'.$model->rusname.'» </strong>'; ?></h1>
<div>
    <div class="userspage">
        <div class="left_soccer_content">
            <div class="south" title="Фотография тренера" style="margin-bottom:5px"><span class="photo3"><span class="user_avatar">
                    <?php echo ($model->photo_img)?CHtml::image(Yii::app()->baseUrl.'/images/soccer/coach/'.$model->photo_img):CHtml::image(Yii::app()->baseUrl.'/images/soccer/none.png'); ?>
                </span>
            </span>
            </div>
        </div>
        <div class="right_soccer_content">
            <div class="info_team">
                <?php if (isset($model->firstname) && isset($model->lastname)): ?><div class="info_team_field"><div class="spanup width100">Имя</div> <div class="info_team_value spanup"><?php echo $model->firstname." ".$model->lastname; ?></div></div><?php endif; ?>
                <?php if (isset($model->birth_day)): ?><div class="info_team_field"><div class="spanup width100">Родился</div> <div class="info_team_value spanup"><?php echo "".Date("d.m.Y",strtotime($model->birth_day))." (".Date::getAge($model->birth_day)." ".Yii::t('yii','год|года|лет',Date::getAge($model->birth_day)).")"; ?></div></div><?php endif; ?>
                <?php if (isset($model->country_id) && $model->country_id!=0): ?><div class="info_team_field"><div class="spanup width100">Страна</div> <div style="background: url('<?php if (isset($model->country->image))echo Yii::app()->baseUrl.'/images/soccer/country/'.$model->country->image; ?>') no-repeat 0 0; padding-left:20px;" class="info_team_value spanup"> <?php echo $model->country->name; ?></div></div><?php endif; ?>
                <div class="info_team_field"><div class="spanup width100">Команда</div> <div style="background: url('<?php if (isset($team->team->logo_img)) echo Yii::app()->baseUrl.'/images/soccer/team/'.$team->team->logo_img; ?>') no-repeat 0 0; background-size: 14px 14px; padding-left:20px;" class="info_team_value spanup"> <?php echo CHtml::link($team->team->rusname,array("/team/view","id"=>$team->team->id)); ?></div></div>
            </div>
        </div>
    </div>
</div>