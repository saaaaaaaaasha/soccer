<ul class="userlist_mini">
<?php foreach($teams as $team): ?>
    <div class="team" id="tid<?php echo $team->id; ?>">


        <li class="user">
            <div class="useravatar">
                <?php echo CHtml::link(CHtml::image(Yii::app()->BaseUrl."/images/soccer/team/".$team->logo_img,$team->name,array('width'=>'32px','height'=>'32px')),array("//team/view","id"=>$team->id)); ?>
            </div>
            <div class="userlogin">
                <?php echo CHtml::link(Text::GetShotName(CHtml::encode($team->name),true),array("//team/view","id"=>$team->id)) ?>
            </div>
        </li>


    </div><!-- comment -->
<?php endforeach; ?>
</ul>

