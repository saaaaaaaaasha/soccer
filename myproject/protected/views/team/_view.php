<li class="game" data-match-id="<?php echo $model->id; ?>">
    <div class="item width30">
        <div class="line-th"><span><?php echo Date::getDayMonth($model->date);?></span></div>
    </div>
    <div class="item width70">
        <div class="line-th"><span><?php echo SoccerMatch::getStatusMatch($model->status);?></span></div>
    </div>
    <div class="item teamhome">
        <div class="line-td"><?php echo Text::GetShotName2($model->hometeam->rusname); ?></div>
    </div>
    <div class="score">
        <div class="line-td south"  title="Обзор матча"><a href="<?php echo Yii::app()->baseUrl."/games/".$model->id; ?>"><?php echo SoccerMatch::getResultMatch($model->homegoals,$model->awaygoals); ?></a></div>
    </div>
    <div class="item teamaway">
        <div class="line-td"><?php echo Text::GetShotName2($model->awayteam->rusname); ?></div>
    </div>
    <div class="item srght">
        <div class="line-th"><span>Тур <?php echo $model->matchday; ?></span></div>
    </div>
</li>