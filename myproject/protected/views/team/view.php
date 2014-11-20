<?php
$this->breadcrumbs=array(
	//UserModule::t('Users')
    "Информация о команде"=>array('index'),
	$model->rusname,
);
$this->layout='//layouts/column2';
?>





<style>
    h1:after {
        content: '';
        display: block;
        /*clear: both;*/
        height: 1px;
        margin: 10px 0px;
        background: #eee;
    }


</style>

<h1><?php echo 'Клуб <strong>«'.$model->rusname.'» </strong>'; ?></h1>



<div style="float:right;">
    <div class="myfriends" style="margin-bottom:20px; font-family: 'Tahoma'; color: #777; min-height:90px; font-size:14px;padding:10px; width:210px; background: #f5f5f5;">
        <div class="myfriends_title" style="text-align:center;"><strong>Друзья</strong> пользователя</div>
    </div>
</div>


<div style="width: 500px;">
<div class="userspage">
    <div style="text-align: center;" class="right_userspage">
        <div class="south" title="Аватарка пользователя" style="margin-bottom:5px"><span class="photo2"><span class="user_avatar">
                    <?php echo ($model->logo_img)?CHtml::image(Yii::app()->baseUrl.'/images/soccer/team/'.$model->logo_img):CHtml::image(Yii::app()->baseUrl.'/images/noavatar.gif'); ?>
                </span>
            </span>
        </div>


    </div>
    <div class="left_userspage">

        <div class="nameblock_userspage">

            <div class="name_userspage">
                <?php echo $model->name." ".$model->rusname; ?>
            </div>
        </div>
        <div class="spanup"><span id="country"><?php //echo $model->profile->country; ?></span><span id="city"><?php// echo $model->profile->city; ?></span></div>




        <div class="information_userspage">
            <div style="padding-bottom:11px;"><div style="width: 100px;" class="spanup">Заходил</div> <div style="color #737c93 !important; font-weight: bold !important;" class="spanup"><span id="regtime"><?php //echo Date::timeElapsedString(strtotime($model->lastvisit_at)); ?></span></div></div>
            <div style="padding-bottom:11px;"><div style="width: 100px;" class="spanup">Зарегистирован</div> <div style="color #737c93 !important; font-weight: bold !important;" class="spanup"><span id="regtime"><?php //echo Date::timeElapsedString(strtotime($model->create_at)); ?></span></div></div>
            <?php //if($model->profile->date_birth!="0000-00-00"): ?><div style="padding-bottom:11px;"><div style="width: 100px;" class="spanup">Дата рождения</div> <div style="color #737c93 !important; font-weight: bold !important;" class="spanup"><?php //echo Date::getRussianDate($model->profile->date_birth); ?> [ <b><?php //echo Date::getAge($model->profile->date_birth); ?></b> ]</div></div><?php //endif; ?>
            <div style="padding-bottom:11px;"><div style="width: 100px;" class="spanup">Email</div> <div style="color #737c93 !important; font-weight: bold !important;" class="spanup">
                    Адрес скрыт </div></div>

            <?php //if($model->profile->site): ?><div style="padding-bottom:11px;"><div style="width: 100px;" class="spanup">Сайт</div> <div style="color #737c93 !important; font-weight: bold !important;" class="spanup"><noindex><a href="<?php //echo $model->profile->site; ?>" target="_blank" rel="nofollow"><?php //echo $model->profile->site; ?>/</a></noindex></div></div><?php //endif; ?>
            <?php //if($model->profile->vk_id): ?><div style="padding-bottom:11px;"><div style="width: 100px;" class="spanup">Вконтакте</div> <div style="color #737c93 !important; font-weight: bold !important;" class="spanup"><noindex><a href="http://vk.com/<?php //echo $model->profile->vk_id; ?>" target="_blank" rel="nofollow"><?php //echo $model->profile->vk_id; ?></a></noindex></div></div><?php //endif; ?>
            <?php //if($model->profile->twitter_id): ?><div style="padding-bottom:11px;"><div style="width: 100px;" class="spanup">Твиттер</div> <div style="color #737c93 !important; font-weight: bold !important;" class="spanup"><noindex><a href="http://twitter.com/<?php //echo $model->profile->twitter_id; ?>" target="_blank" rel="nofollow"><?php //echo $model->profile->twitter_id; ?></a></noindex></div></div><?php //endif; ?>

        </div>
    </div>



</div>
</div>

<?php foreach($players as $player): ?>
    <div class="player" id="c<?php echo $player->player->id; ?>">

        <div class="author">
            <?php echo CHtml::image(Yii::app()->baseUrl.'/images/soccer/player/'.$player->player->photo_img,'',array('height'=>'20px')); echo "  ".$player->player->rusname; ?> says:
        </div>
    </div><!-- comment -->
<?php endforeach; ?>

