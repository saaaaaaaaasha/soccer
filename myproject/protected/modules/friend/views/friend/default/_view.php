
<li class="user">
    <!--<img src="<?php //echo $data->profile->avatar; ?>">-->
    <div class="useravatar"><?php echo CHtml::link(($data->profile->avatar)?CHtml::image(Yii::app()->baseUrl.'/'.$data->profile->avatar):CHtml::image(Yii::app()->baseUrl.'/images/noavatar.gif'),array("/user/user/view","id"=>$data->id)); ?></div>
    <div class="userlogin"><?php echo CHtml::link("@".CHtml::encode($data->username),array("/user/user/view","id"=>$data->id)) ?></div>
    <div class="username">
        <?php
        echo CHtml::encode(Text::cutText($data->profile->firstname." ".$data->profile->lastname,23));?>
    </div>
    <div class="buttonsrelationship">

        <?php if($data->id!=Yii::app()->user->getId() && !Yii::app()->user->isGuest){
            if (Yii::app()->getModule('friend')->isFriend($data->id,Yii::app()->user->getId(),true)){
                echo "<a href=\"\" data-user-id=".$data->id." class=\"delete_user\">Удалить из друзей</a>";
            }
            elseif (Yii::app()->getModule('friend')->isFollower($data->id,Yii::app()->user->getId(),true)){
                echo "<a href=\"\" data-user-id=".$data->id." class=\"unsub_user\">Отписаться</a>";
            } else {
                echo "<a href=\"\" data-user-id=".$data->id." class=\"add_user\">Добавить в друзья</a>";
            }

            echo "<a href=\"\" data-user-id=".$data->id." class=\"send_mail\"></a>";
            //Yii::app()->request->baseUrl.'/images/buttonsend.gif'

        } ?>

    </div>
    <?php echo ''; ?>
</li>