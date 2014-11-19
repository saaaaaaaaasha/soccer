<?php
$this->breadcrumbs=array(
	UserModule::t('Users')=>array('index'),
	$model->username,
);
$this->layout='//layouts/column2';
/*
$this->menu=array(
    array('label'=>UserModule::t('List User'), 'url'=>array('index')),
);*/
?>
<?php //echo UserModule::t('View User').' "'.$model->username.'"'; ?>

<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="http://updatesite.ru/js/jquery.tipsy.js"></script>

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

<h1><?php echo 'Персональная страница <strong>«'.$model->username.'» </strong>'; ?></h1>


<style>




</style>
<div style="float:right;">
<div class="myfriends" style="margin-bottom:20px; font-family: 'Tahoma'; color: #777; min-height:90px; font-size:14px;padding:10px; width:210px; background: #f5f5f5;">
    <div class="myfriends_title" style="text-align:center;"><strong>Друзья</strong> пользователя</div>
</div>

<div class="myfriends" style="font-family: 'Tahoma'; color: #777; min-height:90px; font-size:14px;padding:10px; width:210px; background: #f5f5f5;">
    <div class="myfriends_title" style="text-align:center;"><strong>Активность</strong> <?php echo $model->username; ?></div>
</div>
</div>


<div style="width: 500px;">
<div class="userspage">
    <div style="text-align: center;" class="right_userspage">
        <div class="south" title="Аватарка пользователя" style="margin-bottom:5px"><span class="photo2"><span class="user_avatar">
                    <?php echo ($model->profile->avatar)?CHtml::image($model->profile->avatar):CHtml::image('images/noavatar.gif'); ?>
                </span>
            </span>
        </div>
        <div class="buttonsrelationship">

            <?php if($model->id!=Yii::app()->user->getId() && !Yii::app()->user->isGuest){
                if (Yii::app()->getModule('friend')->isFriend($model->id,Yii::app()->user->getId(),true)){
                    echo "<a href=\"\" data-user-id=".$model->id." class=\"delete_user\">Удалить из друзей</a>";
                }
                elseif (Yii::app()->getModule('friend')->isFollower($model->id,Yii::app()->user->getId(),true)){
                    echo "<a href=\"\" data-user-id=".$model->id." class=\"unsub_user\">Отписаться</a>";
                } else {
                    echo "<a href=\"\" data-user-id=".$model->id." class=\"add_user\">Добавить в друзья</a>";
                }

                echo "<a href=\"\" data-user-id=".$model->id." class=\"send_mail\"></a>";
                //Yii::app()->request->baseUrl.'/images/buttonsend.gif'

            } ?>

        </div>
        <div class="userstatus"><div id="mystatus">STATUS</div></div>


        <style>
            .delstatus{background-position:0 0; background-repeat:no-repeat; opacity: 0.3; background-image:url(http://updatesite.ru/image/tmpl/closesearch2.png); height:13px; width:13px; position:absolute; top:55%; right:18px; cursor:pointer; z-index:3;}
            .delstatus:hover{opacity: 1;}
            input.status-text2{opacity: 1; padding:5px 28px 5px 5px; font-family:Helvetica, Arial, sans-serif;font-size:12px;vertical-align:middle;color:#bbb;border:1px solid #e6e6e6;background-color:#fff;/*background-position:95% 50%;*/-webkit-border-radius:1px;-moz-border-radius:1px;border-radius:1px}
            input.status-text2::-webkit-input-placeholder{color:#bbb}
            input.status-text2:focus{color:#444;outline:none; opacity: 1;}
            .userstatus a span{color: #bbb;}
            .userstatus a{font-weight: bold;}
            .userstatus a span{color: #999;}
            #mystatus {display: inline-block;}
            .userstatus,.userstatus_edit{ border-radius:2px; height:15px; margin:5px 0 10px 0; color: #bbb;font: normal 11px/13px 'Tahoma';}

        </style>

        <span class="south" title="10 из 10"><img alt="" name="rankimg" border="0" src="http://updatesite.ru/image/tmpl/ranks/rank10.gif" align="absmiddle"></span>
        <div class="rating_userspage">
            <div> РЕЙТИНГ<br><span><a href="javascript://" rel="nofollow" onclick="new _uWnd('Rh',' ',400,250,{autosize:1,maxh:300,minh:100,closeonesc:1},{url:'/index/9-2'});return false;">84%</a></span></div> <div>АКТИВНОСТЬ<br><span id="activity">953%</span></div>

        </div>
    </div>
    <div class="left_userspage">

        <div class="nameblock_userspage">

            <div class="name_userspage">
                <?php echo $model->profile->firstname." ".$model->profile->lastname; ?>
                <?php if($model->status==1):?> <div title="Пользователь подтвержден" class="aemail south" style=""></div><?php endif; ?>
            </div>
        </div>
        <div class="spanup"><span id="country"><?php echo $model->profile->country; ?></span><span id="city"><?php echo $model->profile->city; ?></span></div>


        <div class="none" id="urlavatar"></div>
        <script type="text/javascript" src="http://updatesite.ru/js/useredit.js"></script>
        <script type="text/javascript">

            function editStatus2 (name) {
                if (1!=2) {
                    userData.edit({yahoo: name}, function (errorText) {
                        _uWnd.alert(errorText ? errorText : 'Данные успешно изменены!', 'Редактирование', {w: 250, h: 75, tm: 4500});
                        if (!errorText) {var ur= $("#mystatus").html(name); if (name=="") $("#setstatus").html("Установить статус"); else $("#setstatus").html("ред.");}
                    });
                };
            };



            function statusactive() {

                var str=$('#setstatusa').attr('rel');
                if (str=="on") {
                    $('#setstatusa').attr('rel','off');
                    $('.userstatus_edit').removeClass('none');
                    $('.userstatus').addClass('none');
                    $('#setstatustext').focus();
                    var now=$("#mystatus").html();
                    $('#setstatustext').val(now);

                }
                else {
                    $('#setstatusa').attr('rel','on');
                    $('.userstatus_edit').addClass('none');
                    $('.userstatus').removeClass('none');
                }
            }

            $('#setstatusa').click(function () {

                statusactive();
                return false;
            })

            $('.delstatus').click(function () {
                $('#setstatustext').val("");
                //alert("34");
            })


            $(function(){
                $(document).click(function(event) {
                    if ($(event.target).closest(".delstatus").length) return;
                    if ($(event.target).closest("#setstatustext").length) return;
                    //.userstatus_edit,.delstatus,#setstatustext
                    if ($('#setstatusa').attr('rel')=="on") return;
                    statusactive();
                    event.stopPropagation();
                    //return false;
                });
            });

            $('#setstatustext').keyup(function(e) {
                if(e.keyCode == 13){
                    //alert("44");
                    editStatus2( $('#setstatustext').val());
                    return false;
                }
            });

            function editName (name) {
                if (name.length) {
                    userData.edit({avatar: name}, function (errorText) {
                        _uWnd.alert(errorText ? errorText : 'Данные успешно изменены!', 'Редактирование', {w: 250, h: 75, tm: 4500});
                        if (!errorText) {var ur= $("#urlavatar").html(); $(".user_avatar img").attr("src",ur); _uWnd.close('avadata');/*location.reload();*/}
                    });
                };
            };

            function editStatus () {
                var now = $("#mystatus").html();
                //alert(now);
                //if (now==)
                var name = prompt("Введите статус",now);
                if (name!=null) {
                    userData.edit({yahoo: name}, function (errorText) {
                        _uWnd.alert(errorText ? errorText : 'Данные успешно изменены!', 'Редактирование', {w: 250, h: 75, tm: 4500});
                        if (!errorText) {var ur= $("#mystatus").html(name); if (name=="") $("#setstatus").html("Установить статус"); else $("#setstatus").html("ред.");}
                    });
                };
            };
            function editAvatar () {
                new _uWnd('avadata','Изменение аватарки',300,150,{autosize:1,maxh:300,minh:100},'<div style="color: #999; text-align:center;"><input style="width: 180px; padding: 5px;" type="text" placeholder="Введите ссылку до аватарки" id="avatarname" value=""><br><button style="width: 180px;" id="buttoon">Изменить аватарку</button><br><br>Если изображение находится у вас на компьютере, то загрузите его на любой хостинг изображений (например: <a href="http://radikal.ru" target="_blank">сюда</a>), вставке ссылку в текстовое поле и нажмите на кнопку &quot;Изменить&quot;.</div>');
            }
            $('body').on('click', '#buttoon', function(e){
                var ur=$("#avatarname").val();
                $("#urlavatar").html(ur);
                editName(ur);
            });
        </script>


        <script type="text/javascript">


            $( document ).ready(function() {

                if ( $("#staatus span").hasClass("statusOnline") ) {
                    $(".logtime_userspage").html("Пользователь онлайн");
                }

                var city=$("#city").html();
                var country=$("#country").html();
                if (city=="" && country=="") $("#country").html("Местоположение не определено...");
                else if (city!="" && country!="") $("#country").html(country+", ")

                var comm=$("#commsCOUNT").html(); if (comm=="") comm=0;
                var forum=$("#forumsCOUNT").html(); if (forum=="") forum=0;
                var post=$("#postsCOUNT").html(); if (post=="") post=0;
                var result=+comm+forum*2+post*5;
                //$("#activity").html(result+"%");
            });
        </script>


        <div class="information_userspage">
            <div style="padding-bottom:11px;"><div style="width: 100px;" class="spanup">Заходил</div> <div style="color #737c93 !important; font-weight: bold !important;" class="spanup"><span id="regtime"><?php echo Date::timeElapsedString(strtotime($model->lastvisit_at)); ?></span></div></div>
            <div style="padding-bottom:11px;"><div style="width: 100px;" class="spanup">Зарегистирован</div> <div style="color #737c93 !important; font-weight: bold !important;" class="spanup"><span id="regtime"><?php echo Date::timeElapsedString(strtotime($model->create_at)); ?></span></div></div>
            <?php if($model->profile->date_birth!="0000-00-00"): ?><div style="padding-bottom:11px;"><div style="width: 100px;" class="spanup">Дата рождения</div> <div style="color #737c93 !important; font-weight: bold !important;" class="spanup"><?php echo Date::getRussianDate($model->profile->date_birth); ?> [ <b><?php echo Date::getAge($model->profile->date_birth); ?></b> ]</div></div><?php endif; ?>
            <div style="padding-bottom:11px;"><div style="width: 100px;" class="spanup">Email</div> <div style="color #737c93 !important; font-weight: bold !important;" class="spanup">
                    Адрес скрыт </div></div>

            <?php if($model->profile->site): ?><div style="padding-bottom:11px;"><div style="width: 100px;" class="spanup">Сайт</div> <div style="color #737c93 !important; font-weight: bold !important;" class="spanup"><noindex><a href="<?php echo $model->profile->site; ?>" target="_blank" rel="nofollow"><?php echo $model->profile->site; ?>/</a></noindex></div></div><?php endif; ?>
            <?php if($model->profile->vk_id): ?><div style="padding-bottom:11px;"><div style="width: 100px;" class="spanup">Вконтакте</div> <div style="color #737c93 !important; font-weight: bold !important;" class="spanup"><noindex><a href="http://vk.com/<?php echo $model->profile->vk_id; ?>" target="_blank" rel="nofollow"><?php echo $model->profile->vk_id; ?></a></noindex></div></div><?php endif; ?>
            <?php if($model->profile->twitter_id): ?><div style="padding-bottom:11px;"><div style="width: 100px;" class="spanup">Твиттер</div> <div style="color #737c93 !important; font-weight: bold !important;" class="spanup"><noindex><a href="http://twitter.com/<?php echo $model->profile->twitter_id; ?>" target="_blank" rel="nofollow"><?php echo $model->profile->twitter_id; ?></a></noindex></div></div><?php endif; ?>

        </div>
    </div>



</div>

<div class="userwall">
    <div class="userwall_title"><strong>Стена пользователя</strong> <span><strong>xxx</strong> записей</span></div>
</div>
</div>

<script type='text/javascript'>
    $(function() {
        $('.north').tipsy({gravity: 'n'});
        $('.south').tipsy({gravity: 's'});
        $('.east').tipsy({gravity: 'e'});
        $('.west').tipsy({gravity: 'w'});

    });
</script>









<!--<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>-->
<script>

    $(document).ready(function(){
        $(".userspage").parent().parent().removeClass( "span-19" );//.addClass( "span-17" );
    })
    $(document.body).on("click", "#unsub_user", function (event) {
        var uid=$(this).data("user-id");
        $.ajax({
            url: '<?php echo Yii::app()->CreateUrl("/friend/unsub"); ?>',
            type: 'POST',
            data: "unsubfriend="+uid,
            success: function (html) {
                //alert(html);
                window.location.reload();
                return;
            }
        });
        event.preventDefault();
    });
    $(document.body).on("click", "#delete_user", function (event) {
        var uid=$(this).data("user-id");
        $.ajax({
            url: '<?php echo Yii::app()->CreateUrl("/friend/delete"); ?>',
            type: 'POST',
            data: "deletefriend="+uid,
            success: function (html) {
                alert(html);
                window.location.reload();
                return;
            }
        });
        event.preventDefault();
    });
    $(document.body).on("click", "#add_user", function (event) {
        var uid=$(this).data("user-id");
        $.ajax({
            url: '<?php echo Yii::app()->CreateUrl("/friend/add"); ?>',
            type: 'POST',
            data: "addfriend="+uid,
            success: function (html) {
                    //alert(html);
                    window.location.reload();
                    return;
            }
        });
        event.preventDefault();
    });
</script>

