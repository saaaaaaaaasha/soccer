<?php
$this->layout='//layouts/column1';
$this->setPageTitle($model->name);
?>

<?php $this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Главная', 'url' => array('')),
        array('name' => 'Стадионы', 'url' => array('/stadium/')),
        array('name' => $model->name),
    )
)); ?>


<h1 class="h1content"><?php echo 'Стадион <strong>«'.$model->name.'» </strong>'; ?></h1>


<div class="left_soccer_content">
    <div class="south" title="Фото стадиона" style="margin-bottom:5px">
        <span class="photo3">
                <?php echo ($model->photo_img)?CHtml::image(Yii::app()->baseUrl.'/images/soccer/stadium/'.$model->photo_img):CHtml::image(Yii::app()->baseUrl.'/images/noavatar.gif'); ?>
        </span>
    </div>
</div>
<div class="right_soccer_content">
    <div class="info_stadium">
        <?php if($model->country): ?> <div class="info_team_field"><div class="spanup width100">Страна</div> <div style="background: url('<?php if (isset($model->country->image)) echo Yii::app()->baseUrl.'/images/soccer/country/'.$model->country->image; ?>') no-repeat 0 0; padding-left:20px;" class="info_team_value spanup"> <?php echo $model->country->name; ?></div></div><?php endif; ?>
        <?php if($model->city): ?><div class="info_stadium_field"><div class="spanup width100">Город</div> <div class="info_stadium_value spanup"><?php echo $model->city; ?></div></div><?php endif; ?>
        <?php if($model->field_size): ?><div class="info_stadium_field"><div class="spanup width100">Размеры поля</div> <div class="info_stadium_value spanup"><?php echo $model->field_size; ?></div></div><?php endif; ?>
        <?php if($model->capacity): ?><div class="info_stadium_field"><div class="spanup width100">Вместительность</div> <div class="info_stadium_value spanup"><?php echo $model->capacity; ?></div></div><?php endif; ?>
        <?php if($model->founded): ?><div class="info_stadium_field"><div class="spanup width100">Открыт</div> <div class="info_stadium_value spanup"><?php echo "в ".$model->founded." году"; ?></div></div><?php endif; ?>
        <?php if($team): ?><div class="info_stadium_field"><div class="spanup width100">Команды</div> <div class="info_stadium_value spanup">
                <span style="background-image:url('<?php echo Yii::app()->baseUrl."/images/soccer/team/".$team->logo_img; ?>'); background-size: 16px 16px;"  class="flag16">
                    <?php echo CHtml::link($team->rusname,array("/team/view","id"=>$team->id)); ?>
                </span>
            </div>
        </div><?php endif; ?>
    </div>
</div>

<div class="game-container">
    <div style="padding-bottom:5px;"><strong class="short-statistic-descr">Последние сыгранные игры на стадионе:</strong></div>
    <ul>
        <?php foreach($lastgames as $game): ?>
            <?php $this->renderPartial('application.views.layouts._view',array(
                'model'=>$game,
            )); ?>
        <?php endforeach; ?>
    </ul>
</div>
<?php if($model->map):?>
<div class="game-container">
    <div style="padding-bottom:5px;"><strong class="short-statistic-descr">Стадион с высоты птичьего потела:</strong></div>
    <div style="margin-top:0px; overflow: hidden; height:300px;">
        <div style="margin-top:0px; ">
            <div><iframe width="550" height="300" frameborder="0" src="http://www.bing.com/maps/embed/viewer.aspx?v=3&cp=<?php echo $model->map;?>&lvl=16&w=550&h=300&sty=h&typ=d&pp=&ps=&dir=0&mkt=ru-ru&src=SHELL&form=BMEMJS"></iframe></div>
        </div>
    </div>

</div>
<?php endif;?>