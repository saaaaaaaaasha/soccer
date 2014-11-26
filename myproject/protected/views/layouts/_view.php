<li class="game" data-match-id="<?php echo $model->id; ?>">
    <div class="item width30">
        <div class="line-th"><span><?php echo Date::getDayMonth($model->date);?></span></div>
    </div>
    <div class="item width70">
        <div class="line-th"><span><?php echo (SoccerMatch::getStatusMatch($model->status)=="Не начался")?"в ".Date("H:i",strtotime($model->date)+(3*60*60))." МСК":SoccerMatch::getStatusMatch($model->status);?></span></div>
    </div>
    <div class="item teamhome">
        <div class="line-td">
            <?php echo CHtml::link(Text::GetShotName2($model->hometeam->rusname),array('//team/'.$model->hometeam->id),array('style'=>'background-image: url('.Yii::app()->baseUrl."/images/soccer/team/".$model->hometeam->logo_img.'); padding-right:18px; background-position: top right; "')); ?>
            <!--<span style=""></span>-->
        </div>
    </div>
    <div class="score">
        <div class="line-td south"style="width:46px;text-align:center" title="Обзор матча"><a class="<?php echo (SoccerMatch::getStatusMatch($model->status)!="Не начался")?"fulltime":"nulltime";?>" href="<?php echo Yii::app()->baseUrl."/games/".$model->id; ?>"><?php echo SoccerMatch::getResultMatch($model->homegoals,$model->awaygoals); ?></a></div>
    </div>
    <div class="item teamaway">
        <div class="line-td">
            <?php echo CHtml::link(Text::GetShotName2($model->awayteam->rusname),array('//team/'.$model->awayteam->id),array('style'=>'background-image: url('.Yii::app()->baseUrl."/images/soccer/team/".$model->awayteam->logo_img.'); padding-left:18px; background-position: top left; "')); ?>
        </div>
    </div>
    <div class="item srght">
        <div class="line-th"><span>Тур <?php echo $model->matchday; ?></span></div>
    </div>
</li>