<?php ?>
<div class="friends_nav">
<a href="<?php echo Yii::app()->baseUrl."/friend/my"?>" class="<?php echo $friend; ?>">Мои друзья</a>
<a href="<?php echo Yii::app()->baseUrl."/friend/my/followed"?>" class="<?php echo $fol; ?>">Мои подписчики</a>
<a href="<?php echo Yii::app()->baseUrl."/friend/my/followers"?>" class="<?php echo $sub; ?>">Ваши подписки</a>
</div>

<style>
    a.active{font-weight: bold;}
    .friends_nav {margin:12px 8px;}
</style>