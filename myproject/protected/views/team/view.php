<?php
$this->layout='//layouts/column2';
$this->setPageTitle($model->rusname);
?>

<?php $this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Главная', 'url' => array('')),
        array('name' => 'Информация о команде', 'url' => array('/team/')),
        array('name' => $model->rusname),
    )
)); ?>




<h1 class="h1content"><?php echo 'Клуб <strong>«'.$model->rusname.'» </strong>'; ?></h1>

<div style="float:right;">
    <div class="teampalyers">
        <div class="teampalyers_title"><strong>Состав команды</strong></div>
        <div class="teampalyers_body">
            <?php foreach($players as $player): ?>
            <?php if (isset($player->player->id)): ?>
                <div id="p_<?php echo $player->player->id; ?>"style="height:10px; width: 230px;" data-number="<?php echo (isset($player->player->number))?$player->player->number:""; ?>" class="event_at">
                    <span class="event_time"><?php echo (isset($player->player->number))?$player->player->number:""; ?></span>
                    <span class="flag16" style="background-image:url('<?php echo Yii::app()->baseUrl.'/images/soccer/player/'.$player->player->photo_img; ?>')">
                        <a href="<?php echo Yii::app()->baseUrl."/player/".$player->player->id; ?>"><?php echo $player->player->rusname; ?></a>
                    </span>
                    <?php if ($player->player->country->name!="unknown"): ?> <span title="<?php echo $player->player->country->name; ?>" class="flag16 srght" style="background-image:url('<?php echo Yii::app()->baseUrl.'/images/soccer/country/'.$player->player->country->image; ?>')">

                    </span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
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

        <!--<div class="nameblock_userspage">
            <div class="name_userspage">
                <?php //echo "ФК ".$model->rusname;?>
            </div>
        </div>
        <div class="spanup"><span><?php //echo "".$model->name; ?></span></div>-->

        <div class="info_team">
            <?php if (isset($model->name)): ?><div class="info_team_field"><div class="spanup width100">Название</div> <div class="info_team_value spanup"><?php echo $model->name; ?></div></div><?php endif; ?>

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
        <?php foreach($nextgames as $game): ?>
            <?php $this->renderPartial('_view',array(
                'model'=>$game,
            )); ?>
        <?php endforeach; ?>
        </ul>
    </div>



</div>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.sparkline.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.sparkline.css" />

<!--<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>-->

<script type="text/javascript">
    $(function() {
        /** This code runs when everything has been loaded on the page */
        /* Inline sparklines take their values from the contents of the tag */
        $('.inlinesparkline').sparkline();

        /* Sparklines can also take their values from the first argument
         passed to the sparkline() function */
        var myvalues = [8,1,1,3,5,1,4,5,4,6,13,4,1,1,1];
        $('.dynamicsparkline').sparkline(myvalues, {type: 'line',width: '100px',height: '80px',chartRangeMin: '1', chartRangeMax: '20'});
        var myvalues2 = [0,0,1,-1,-1,-1,4,5,4,6,13,4,1,1,1];

        var myvalues = <?php echo json_encode(array_values($statsforchars['place'])); ?>;
        var myvalues2 = <?php echo json_encode(array_values($statsforchars['res'])); ?>;

        $('.dynamictri').sparkline(myvalues2, {type: 'tristate', barWidth: '7',height: '20',posBarColor: '#1294ef'} );


        /* The second argument gives options such as chart type */
        $('.dynamicbar').sparkline(myvalues, {type: 'bar', width: '100',  barWidth: '7', height: '20', barColor: '#1294ef',chartRangeMin: '1', chartRangeMax: '20'} );

        /* Use 'html' instead of an array of values to pass options
         to a sparkline with data in the tag */
        $('.inlinebar').sparkline('html', {type: 'bar', barColor: 'red'} );
    });
</script>




<div class="navig">
    <div class="item">
        <div class="line-th"><div style="margin-bottom: 12px;">Результаты команды:</div><span class="dynamictri">Loading..</span></div>
    </div>
    <div class="item">

        <div class="line-th"><div style="padding-bottom: 12px;">Место после каждого тура:</div><span class="dynamicbar">Loading..</span></div>
    </div>
</div>


