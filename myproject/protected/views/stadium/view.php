<?php
$this->breadcrumbs=array(
    "Стадионы"=>array('index'),
	$model->name,
);
$this->layout='//layouts/column1';
/*
$this->menu=array(
    array('label'=>UserModule::t('List User'), 'url'=>array('index')),
);*/
?>

<h1 class="title"><?php echo 'Стадион <strong>«'.$model->name.'» </strong>'; ?></h1>


<div class="left_soccer_content">
    <div class="south" title="Фото стадиона" style="margin-bottom:5px">
        <span class="photo3">
                <?php echo ($model->photo_img)?CHtml::image('images/soccer/stadium/'.$model->photo_img):CHtml::image('images/noavatar.gif'); ?>
        </span>
    </div>
</div>
<div class="right_soccer_content">
    <div class="info_stadium">
        <?php if($model->country): ?><div class="info_stadium_field"><div class="spanup width100">Страна</div> <div style="background: url('<?php echo 'images/soccer/country/'.$model->country->image; ?>') no-repeat 0 0; padding-left:20px;" class="spanup"><?php echo ' '.$model->country->name; ?></div></div><?php endif; ?>
        <?php if($model->city): ?><div class="info_stadium_field"><div class="spanup width100">Город</div> <div class="info_stadium_value spanup"><?php echo $model->city; ?></div></div><?php endif; ?>
        <?php if($model->field_size): ?><div class="info_stadium_field"><div class="spanup width100">Размеры поля</div> <div class="info_stadium_value spanup"><?php echo $model->field_size; ?></div></div><?php endif; ?>
        <?php if($model->capacity): ?><div class="info_stadium_field"><div class="spanup width100">Вместительность</div> <div class="info_stadium_value spanup"><?php echo $model->capacity; ?></div></div><?php endif; ?>
        <?php if($model->founded): ?><div class="info_stadium_field"><div class="spanup width100">Год открытия</div> <div class="info_stadium_value spanup"><?php echo $model->founded; ?></div></div><?php endif; ?>
        <?php if($team): ?><div class="info_stadium_field"><div class="spanup width100">Команды</div> <div class="info_stadium_value spanup">
                <span style="background-image:url('<?php echo "images/soccer/team/".$team->logo_img; ?>'); background-size: 16px 16px;"  class="flag16">
                    <?php echo CHtml::link($team->rusname,array("/team/view","id"=>$team->id)); ?>
                </span>
            </div>
        </div><?php endif; ?>
    </div>
</div>

<button class="button15">Посмотреть карту</button> <button class="button15">Неточные данные</button>
<div style="margin-top:15px; overflow: hidden;height:200px;">
    <div style="margin-top:-100px; ">
    <iframe width="500" height="400" frameborder="0" src="http://www.bing.com/maps/embed/viewer.aspx?v=3&cp=51.481667~-0.191111&lvl=16&w=500&h=400&sty=h&typ=d&pp=&ps=&dir=0&mkt=ru-ru&src=SHELL&form=BMEMJS"></iframe>
    </div>
</div>