<?php
$this->breadcrumbs=array(
	//UserModule::t('Users')
    "Информация о команде"=>array('index'),
	$model->rusname,
);
$this->layout='//layouts/column2';
?>

<h1 class="h1content"><?php echo 'Клуб <strong>«'.$model->rusname.'» </strong>'; ?></h1>

<div style="float:right;">
    <div class="teampalyers">
        <div class="teampalyers_title"><strong>Состав команды</strong></div>
        <div class="teampalyers_body">
            <?php foreach($players as $player): ?>

                <div id="p_<?php echo $player->player->id; ?>"style="height:10px; width: 230px;" data-number="<?php echo $player->player->number; ?>" class="event_at">
                    <span class="event_time"><?php echo $player->player->number; ?></span>
                    <span class="flag16" style="background-image:url('<?php echo Yii::app()->baseUrl.'/images/soccer/player/'.$player->player->photo_img; ?>')">
                        <a href="<?php echo Yii::app()->baseUrl."/player/".$player->player->id; ?>"><?php echo $player->player->rusname; ?></a>
                    </span>
                    <?php if ($player->player->country->name!="unknown"): ?> <span title="<?php echo $player->player->country->name; ?>" class="flag16 srght" style="background-image:url('<?php echo Yii::app()->baseUrl.'/images/soccer/country/'.$player->player->country->image; ?>')">

                    </span>
                    <?php endif; ?>
                </div>


            <?php endforeach; ?>
        <div style="clear: both;"></div>
        </div>
    </div>
</div>


<div style="width: 500px;">
<div class="userspage">
    <div style="text-align: center;" class="left_soccer_content">
        <div class="south" title="Эмблема команды" style="margin-bottom:5px"><span class="photo2"><span class="user_avatar">
                    <?php echo ($model->logo_img)?CHtml::image(Yii::app()->baseUrl.'/images/soccer/team/'.$model->logo_img):CHtml::image(Yii::app()->baseUrl.'/images/noavatar.gif'); ?>
                </span>
            </span>
        </div>


    </div>
    <div class="right_soccer_content">

        <div class="nameblock_userspage">
            <div class="name_userspage">
                <?php echo "ФК ".$model->rusname;?>
            </div>
        </div>
        <div class="spanup"><span><?php echo "".$model->name; ?></span></div>

        <div class="info_team">
            <div class="info_team_field"><div class="spanup width100">Стадион</div> <div style="background: url('<?php if (isset($stadium->stadium->country->image))echo Yii::app()->baseUrl.'/images/soccer/country/'.$stadium->stadium->country->image; ?>') no-repeat 0 0; padding-left:20px;" class="info_team_value spanup"> <?php echo CHtml::link($stadium->stadium->name,array("/stadium/view","id"=>$stadium->stadium->id)); // ?></div></div>
            <div class="info_team_field"><div class="spanup width100">Тренер</div> <div style="background: url('<?php if (isset($coach->coach->country->image)) echo Yii::app()->baseUrl.'/images/soccer/country/'.$coach->coach->country->image; ?>') no-repeat 0 0; padding-left:20px;" class="info_team_value spanup">  <?php echo CHtml::link($coach->coach->rusname,array("/coach/view","id"=>$coach->coach->id)); // ?></div></div>
            <!--<div style="background: url('<?php //echo Yii::app()->baseUrl.'/images/soccer/coach/'.$coach->coach->photo_img; ?>') no-repeat 0 0; background-size:14px 14px; padding-left:20px;" class="info_team_value spanup">-->

            <?php if (isset($model->founded)): ?><div class="info_team_field"><div class="spanup width100">Основан</div> <div class="info_team_value spanup"><?php echo "в ".$model->founded." году"; ?></div></div><?php endif; ?>
            <?php if (isset($model->phone)): ?><div class="info_team_field"><div class="spanup width100">Телефон</div> <div class="info_team_value spanup"><?php echo $model->phone; ?></div></div><?php endif; ?>
            <?php if (isset($model->site)): ?><div class="info_team_field"><div class="spanup width100">Сайт</div> <div class="info_team_value spanup"><?php echo $model->site; ?></div></div><?php endif; ?>


        </div>
    </div>



</div>

    <div class="short-stat-container">
        <strong class="short-statistic-descr">Мини-статистика сезона 2014/2015:</strong>
        <div class="short-statistic">
            <div class="item">
                <div class="line-th">Место</div>
                <div class="line-td"><?php echo $place; ?></div>
            </div>
            <div class="item">
                <div class="line-th">Игр</div>
                <div class="line-td"><?php echo $stats['game']; ?></div>
            </div>
            <div class="item">
                <div class="line-th">Побед/Поражений</div>
                <div class="line-td"><?php echo $stats['wins']."<span>/".$stats['loses']."</span>"; ?></div>
            </div>
            <div class="item">
                <div class="line-th">Забито/Пропущено</div>
                <div class="line-td"><?php echo $stats['goal1']."<span>/".$stats['goal2']."</span>"; ?></div>
            </div>
            <div style="clear:both"></div>
        </div>

    </div>

    <div class="game-container">
        <div style="padding-bottom:5px;"><strong class="short-statistic-descr">Последние сыгранные и предстоящие матчи:</strong></div>
        <ul>

        <?php foreach($lastgames as $game): ?>
        <?php $this->renderPartial('_view',array(
            'model'=>$game,
        )); ?>
        <?php endforeach; ?>

        <?php //foreach($nextgames as $game): ?>
            <?php /*$this->renderPartial('_view',array(
                'model'=>$game,
            )); */?>
        <?php //endforeach; ?>
        </ul>
    </div>

    <style>
        .game-container {overflow:hidden; margin:20px 0 12px;}
        .game {width: 100%; float:left; height:20px; line-height:20px; background:#e8e8e0; border-radius:3px; font-size:11px; color:#000; margin:2px 10px 0 0;}
        .game:hover {background: rgba(18, 158, 248, 0.14)
        }
        .game .item {padding:0 6px; float:left; border-left:0px solid #c8c8c3;}
        .game .item:first-child {border-left:0;}
        .game .width50 {width:50px}
        .game .width30 {width:30px}
        .game .width70 {width:70px}
        .game .teamhome {width:130px;}
        .game .teamhome .line-td {float:right;}
        .game .teamhome a, .game .teamaway a{text-decoration: none; color: #222}
        .game .teamhome a:hover, .game .teamaway a:hover{color: #444}
        .game .teamaway {width:130px; text-align:left;}
        .game .score a{text-decoration:none; background: #fe444b; color:white; padding: 0 10px; border-radius: 2px;}
        .game .score a:hover{background: #888}
        .game .line-th {float:left; margin:0px 0px 0 0;}
        .game .line-th span {color: #888;}
        .game .line-td {font-size:13px; font-weight:bold; float:left;}
        .game .line-td span {font-size:17px; color: #555;}
        .short-statistic-descr {color:#a1a1a1; overflow:hidden;margin:5px;}
    </style>

</div>





