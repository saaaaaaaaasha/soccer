<div class="leftsection">

    <div class="lefttitle"><strong>Мини-чат</strong></div>
    <div id="mchatpage" class="leftbody">

        <div class="chat_over" style="width: 210px;">

            <div id="cht" onclick="show_chat()">
                <div class="ngd"><div id="wrapper"><div id="scroller" class="comm">loading message..</div></div>
                    <div class="chtt">

                        <iframe id="mchatIfm2" style="width:100%;height:300px" frameborder="0" scrolling="auto" hspace="0" vspace="0" allowtransparency="true" src="<?php echo Yii::app()->CreateUrl("/mchat/"); ?>"></iframe>

                    </div></div>
                <div id="c_one_clon">0</div><div id="c_tell"></div>

                <div class="mchat_add">
                    <div class="sound_on"></div><div class="sound_off"></div>
                    <div id="mchatnameuser" style="display:none"><?php echo Yii::app()->user->getId();  ?></div>

                    <?php if(Yii::app()->user->isGuest): ?>
                        <div class="south" title="Зарегистрируйтесь, что-бы писать сообщения в чате">
                            <input id="mchatMsgF" maxlength="500" name="mcmessage" disabled class="mchat_textedit" type="text" placeholder="What's up?" value="">
                        </div>
                    <?php else: ?>
                        <input id="mchatMsgF" maxlength="500" name="mcmessage" class="mchat_textedit" type="text" placeholder="What's up?" value="">
                    <?php endif; ?>

                    <div class="mchat_smilespanel"><div id="triangle-down"></div>
                        <div style="height: 100%;overflow-y:auto">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/smile/smile.gif" onclick="smiles(':)')" alt="" title="">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/smile/kiss.gif" onclick="smiles(':*')" alt="" title="">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/smile/glad.gif" onclick="smiles(':D')" alt="" title="">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/smile/surprised.gif" onclick="smiles(':o')" alt="" title="">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/smile/tongue.gif" onclick="smiles(':p')" alt="" title="">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/smile/wink.gif" onclick="smiles(';)')" alt="" title="">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/smile/crying.gif" onclick="smiles(':cry:')" alt="" title="">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/smile/love.gif" onclick="smiles(':love:')" alt="" title="">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/smile/sleepy.gif" onclick="smiles(':sleepy:')" alt="" title="">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/smile/snivel.gif" onclick="smiles(':snivel:')" alt="" title="">


                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/smile/1.gif" onclick="smiles(':glad:')" alt="" title="">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/smile/2.gif" onclick="smiles(':tongue:')" alt="" title="">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/smile/3.gif" onclick="smiles(':irate:')" alt="" title="">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/smile/4.gif" onclick="smiles(':sad:')" alt="" title="">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/smile/5.gif" onclick="smiles(':angry:')" alt="" title="">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/smile/6.gif" onclick="smiles(':cool:')" alt="" title="">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/smile/7.gif" onclick="smiles(':nottalk:')" alt="" title="">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/smile/8.gif" onclick="smiles(':pokerface:')" alt="" title="">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/smile/9.gif" onclick="smiles(':norm:')" alt="" title="">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/smile/10.gif" onclick="smiles(':(')" alt="" title="">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/smile/11.gif" onclick="smiles(':\'(')" alt="" title="">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/smile/12.gif" onclick="smiles('0:)')" alt="" title="">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/smile/13.gif" onclick="smiles(':amaze:')" alt="" title="">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/smile/14.gif" onclick="smiles(':fine:')" alt="" title="">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/smile/15.gif" onclick="smiles(':recoil:')" alt="" title="">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/smile/like.gif" onclick="smiles(':like:')" alt="" title="">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/smile/dislike.gif" onclick="smiles(':dislike:')" alt="" title="">


                        </div></div>
                    <div rel="close" class="mchat_smiles"></div>


                </div>
            </div>
        </div>

    </div></div>


<div class="leftsection">
    <div class="leftbody" style="padding:0; overflow: hidden;border-radius: 5px;">
        <a class="betsrec" href="#"></a>
    </div>
</div>

<div class="leftsection">

    <div class="lefttitle"><strong>Пользователи онлайн</strong></div>
    <div class="leftbody">
        <div class="useronline">
            loading online users..
        </div>
    </div>
</div>



