<div class="leftsection">

    <div class="lefttitle"><strong>Мини-чат</strong></div>
    <div id="mchatpage" class="leftbody">

        <script type="text/javascript" src="http://updatesite.ru/demo/mchat/cookie.js"></script>
        <script>

            function sbtFrmMC991(){
                $('#mchatBtn').css({display:'none'});
                $('#mchatAjax').css({display:''});
                //_uPostForm('MCaddFrm',{type:'POST',url:'/mchat/?203595553.301998'});
                var text = $('#mchatMsgF').val();
                //var REL = $(this).attr("rel");
                var URL='<?php echo Yii::app()->CreateUrl("/mchat/add"); ?>';
                var dataString = 'text=' + text;// +'&rel='+ REL;
                //alert(dataString);
                //alert(URL+"  ---  "+text);
                $.ajax({
                    type: "POST",
                    url: URL,
                    data: dataString,
                    cache: false,
                    success: function(html){
                        //alert(html);
                    }
                });
            }


            var chatup,chatposition,chatinterval,chatblocking;
            function sound_on() {$('.sound_off').fadeOut(200, function(){$('.sound_on').fadeIn(200)});setCookie('musics', 'on', 10, "/")}
            function sound_off() {$('.sound_on').fadeOut(200, function(){$('.sound_off').fadeIn(200)});setCookie('musics', 'off', 10, "/")}
            function show_chat() {
                $('.chat_over').animate({bottom:'20px'},200)
                $('#top_chat').fadeOut(200,function(){$('#bottom_chat').fadeIn(200)})
                setCookie('chat', '1', 10, "/")}

            function hide_chat() {
                $('.chat_over').animate({bottom:'-212px'},200)
                $('#bottom_chat').fadeOut(200,function(){$('#top_chat').fadeIn(200)})
                setCookie('chat', '0', 10, "/")}
            function show_profile(nmm) {
                document.location.href='/index/8-'+nmm
            }
            function messages() {
                $.get('<?php echo Yii::app()->CreateUrl("/mchat/"); ?>', function(dt){
                    if($('#c_one_clon').html() != $('#c_one', dt).html() && $('#c_one_clon').html() != '0' && $('#c_one_clon').html() != '' && getCookie('musics') != 'off') {
                        $('#c_tell').html('<embed src="http://myanfield.do.am/audioplayer.swf" flashvars="file=http://myanfield.do.am/message.mp3&startplay=true" wmode="opaque" width="90" height="8"></embed>');
                        setTimeout(function(){$('#c_tell').html('')},2000)}
                    setTimeout(function(){$('#c_one_clon').html($('#c_one', dt).html())},2100)
                    $('#scroller').html($('div.msg', dt).after());
                    setTimeout(function(){$('#wrapper').fadeIn(200);},200)});
                setTimeout(function(){messages()},20000)
            }

            function otbet(xt) {$('#mchatMsgF').val(''+xt+', ');$('#mchatMsgF').focus()}


            $(document).ready(function(){


                $('#mchatMsgF').keyup(function(e) {
                    if(e.keyCode == 13){
                        //
                        sbtFrmMC991();
                        messages();
                        setTimeout(function(){messages()},500);
                        $('#mchatMsgF').val("");
                    }
                });


                $('.sound_on').click(function () {sound_off();})
                $('.sound_off').click(function () {sound_on();})
                $('.mchat_delstatus').click(function () {$('#mchatMsgF').val("");})

                chatinterval=0;
                musics = getCookie('musics')
                if(musics == 'off') {$('.sound_off').show();$('.sound_on').hide()}

                messages()
                chtcc = getCookie('chat')
                if(chtcc == '1') {$('.chat_over').css('bottom', '20px');$('#top_chat').hide();$('#bottom_chat').show()}


            });

        </script>



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
                            <img src="http://updatesite.ru/image/tmpl/smile/smile.gif" onclick="smiles(':)')" alt="" title="">
                            <img src="http://updatesite.ru/image/tmpl/smile/kiss.gif" onclick="smiles(':*')" alt="" title="">
                            <img src="http://updatesite.ru/image/tmpl/smile/glad.gif" onclick="smiles(':D')" alt="" title="">
                            <img src="http://updatesite.ru/image/tmpl/smile/surprised.gif" onclick="smiles(':o')" alt="" title="">
                            <img src="http://updatesite.ru/image/tmpl/smile/tongue.gif" onclick="smiles(':p')" alt="" title="">
                            <img src="http://updatesite.ru/image/tmpl/smile/wink.gif" onclick="smiles(';)')" alt="" title="">
                            <img src="http://updatesite.ru/image/tmpl/smile/crying.gif" onclick="smiles(':cry:')" alt="" title="">
                            <img src="http://updatesite.ru/image/tmpl/smile/love.gif" onclick="smiles(':love:')" alt="" title="">
                            <img src="http://updatesite.ru/image/tmpl/smile/sleepy.gif" onclick="smiles(':sleepy:')" alt="" title="">
                            <img src="http://updatesite.ru/image/tmpl/smile/snivel.gif" onclick="smiles(':snivel:')" alt="" title="">


                            <img src="http://updatesite.ru/image/tmpl/smile/1.gif" onclick="smiles(':glad:')" alt="" title="">
                            <img src="http://updatesite.ru/image/tmpl/smile/2.gif" onclick="smiles(':tongue:')" alt="" title="">
                            <img src="http://updatesite.ru/image/tmpl/smile/3.gif" onclick="smiles(':irate:')" alt="" title="">
                            <img src="http://updatesite.ru/image/tmpl/smile/4.gif" onclick="smiles(':sad:')" alt="" title="">
                            <img src="http://updatesite.ru/image/tmpl/smile/5.gif" onclick="smiles(':angry:')" alt="" title="">
                            <img src="http://updatesite.ru/image/tmpl/smile/6.gif" onclick="smiles(':cool:')" alt="" title="">
                            <img src="http://updatesite.ru/image/tmpl/smile/7.gif" onclick="smiles(':nottalk:')" alt="" title="">
                            <img src="http://updatesite.ru/image/tmpl/smile/8.gif" onclick="smiles(':pokerface:')" alt="" title="">
                            <img src="http://updatesite.ru/image/tmpl/smile/9.gif" onclick="smiles(':norm:')" alt="" title="">
                            <img src="http://updatesite.ru/image/tmpl/smile/10.gif" onclick="smiles(':(')" alt="" title="">
                            <img src="http://updatesite.ru/image/tmpl/smile/11.gif" onclick="smiles(':\'(')" alt="" title="">
                            <img src="http://updatesite.ru/image/tmpl/smile/12.gif" onclick="smiles('0:)')" alt="" title="">
                            <img src="http://updatesite.ru/image/tmpl/smile/13.gif" onclick="smiles(':amaze:')" alt="" title="">
                            <img src="http://updatesite.ru/image/tmpl/smile/14.gif" onclick="smiles(':fine:')" alt="" title="">
                            <img src="http://updatesite.ru/image/tmpl/smile/15.gif" onclick="smiles(':recoil:')" alt="" title="">
                            <img src="http://updatesite.ru/image/tmpl/smile/like.gif" onclick="smiles(':like:')" alt="" title="">
                            <img src="http://updatesite.ru/image/tmpl/smile/dislike.gif" onclick="smiles(':dislike:')" alt="" title="">


                        </div></div>
                    <div rel="close" class="mchat_smiles"></div>


                </div>
            </div>
        </div></div></div>


<div class="leftsection">

    <div class="lefttitle"><strong>Пользователи онлайн</strong></div>
    <div class="leftbody">
        <div class="useronline">
            loading online users..
        </div>
    </div>
</div>