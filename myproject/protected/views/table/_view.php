<?php if($head && $number==1): ?><li class="table t-th">
    <div class="item number">
        <div class="line-th table-th">#</div>
    </div>
    <div class="item teamhome">
        <div class="line-th table-th">Команда</div>
    </div>
    <div class="item width30">
        <div class="line-th table-th">И</div>
    </div>
    <div class="item width30">
        <div class="line-th table-th">О</div>
    </div>
    <div class="item width30">
        <div class="line-th table-th">Пб</div>
    </div>
    <div class="item width30">
        <div class="line-th table-th">Н</div>
    </div>
    <div class="item width30">
        <div class="line-th table-th">Пр</div>
    </div>
    <div class="item width50">
        <div class="line-th table-th">ЗП</div>
    </div>
    <div class="item width30">
        <div class="line-th table-th">Р</div>
    </div>

</li>
<?php endif; ?>

<li class="table" id="tbl-<?php echo $team->id; ?>" data-team-id="<?php echo $team->id; ?>" data-nubmer="<?php echo $number; ?>">
    <div class="item number">
        <div class="line-th">
            <span><?php echo $number; ?></span>
        </div>
    </div>
    <div class="item teamhome">
        <div class="line-td">
            <?php echo CHtml::link($team->rusname,array('//team/'.$team->id),array('style'=>'background-image: url('.Yii::app()->baseUrl."/images/soccer/team/".$team->logo_img.'); padding-left:18px; background-position: top left; "')); ?>
        </div>
    </div>
    <div class="item width30">
        <div class="line-th"><?php echo $stats['game'];?></div>
    </div>
    <div class="item width30">
        <div class="line-th"><strong><?php echo $stats['score'];?></strong></div>
    </div>

    <div class="item width30">
        <div class="line-th"><?php echo $stats['wins'];?></div>
    </div>
    <div class="item width30">
        <div class="line-th"><?php echo $stats['draws'];?></div>
    </div>
    <div class="item width30">
        <div class="line-th"><?php echo $stats['loses'];?></div>
    </div>
    <div class="item width50">
        <div class="line-th"><?php echo $stats['goal1']." - ".$stats['goal2'];?></div>
    </div>
    <div class="item width30">
        <div class="line-th"><?php echo ($stats['goal1']>$stats['goal2'])?"+":""; echo ($stats['goal1']-$stats['goal2'])?></div>
    </div>

</li>