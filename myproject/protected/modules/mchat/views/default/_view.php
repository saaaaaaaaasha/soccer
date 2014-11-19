<div class="msg"><div class="block1"><div class="block2">
        <?php echo CHtml::link(($data->user->profile->avatar)?CHtml::image(Yii::app()->BaseUrl."/".$data->user->profile->avatar, '', array('width' => '32px', 'height' => '32px',)):CHtml::image(Yii::app()->BaseUrl.'/images/avatars/no/noavatar1.png', '', array('width' => '32px', 'height' => '32px',)),array("/user/user/view","id"=>$data->user->id)); ?>
        </div>
        <div class="cMessage">
            <div class="cMessage_inner">
                <div><a href="javascript:void('Apply to')" class="mc_usname" onclick="parent.window.document.getElementById('mchatMsgF').focus(); parent.window.document.getElementById('mchatMsgF').value+='[b]<?php echo Yii::app()->getModule('user')->getName($data->user->id);/* echo $data->user->username;*/ ?>[/b], ';return false;"><?php echo Yii::app()->getModule('user')->getName($data->user->id); //echo $data->user->username; ?></a>:
                    <div class="commtime"><span title="<?php echo Date("d.m.Y",strtotime(str_replace('-','/', $data->date))); ?>"> <?php echo Date::timeElapsedString(strtotime(str_replace('-','/', $data->date))); ?></span></div></div>
                <div class="cMessage_body " <?php if ($index==0) echo "id='c_one'"; ?> ><?php echo Text::replaceSmiles(Text::replaceBBCode($data->text)); ?></div>
        </div>
</div></div></div>