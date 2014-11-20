<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="icon" href="<?php echo Yii::app()->baseUrl."/icon.png"; ?>" type="image/x-icon">
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/main.js"></script>
    <script src="http://updatesite.ru/js/jquery.tipsy.js"></script>
    <script type='text/javascript'>
        $(document).ready( function() {
            $('.north').tipsy({gravity: 'n'});
            $('.south').tipsy({gravity: 's'});
            $('.east').tipsy({gravity: 'e'});
            $('.west').tipsy({gravity: 'w'});

        });
    </script>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>

<?php //var_dump(Yii::app()->user->name, Yii::app()->user->id);?>

<!--<div id="button" onclick="modal_remote('http://localhost/myproject/login');">Live</div>-->

<div id="modalC" style="display: none;">
    <div id="submodal" onclick="modalClose(0);" style="display: none;"></div>
    <div id="modal" class="modal" style="top: 50px; display: none;">
        <div style="position:absolute;top:0;left:0">
            <span id="modal_reload" style=""><span class="button" onclick="modalReload();">↻&nbsp;Обновить</span></span>
        </div>
        <div style="position:absolute;top:0;right:0">
            <span id="modal_close"><span class="button" onclick="modalClose(0);">╳&nbsp;&nbsp;Закрыть</span></span>
        </div>
        <div id="modal_content">
             <div id="loading" style="display: none;">
                <img src="http://st1.soccer365.ru/img/loading.gif" border="0">
             </div>
             <div id="modal_content_remote"></div>
        </div>
    </div>
</div>

<style>
    /* Модально окно */
    #modalC {display:none;position:absolute;top:0;left:0;width:100%;text-align:center;height:200px;z-index:5000;}
    #submodal {width:100%;top:0;left:0;position:absolute;z-index:1999;filter:alpha(opacity=70);opacity:0.7;display:none;background-color:#000;}
    #modal {position:absolute;width:700px;left:50%;margin-left:-350px;display:none;background-color:#fff;z-index:2000;text-align:center}
    #modal_content {margin:40px 15px 25px 15px; min-height:200px;}

    span.button {background:#668099;color:#fff;padding:1px 7px;font-size:8pt;cursor:pointer;height:23px;line-height:23px;display:inline-block;vertical-align:top}
    span.button:hover, span.button_hover {background:#5C738A}
    span.button.white {background:#e4e4e4;color:#1A1A1A}
    span.button.white:hover {background:#d4d4d4;color:#1A1A1A}
    .button a {color:#fff;text-decoration:none}
    span.bt_active, span.bt_active:hover {background:#CB363F}
</style>

<script>
function modal_remote(path) {
    //modal_history.push('modal_remote(\''+path+'\')'); // добавляем текущий вызов в историю
    //modal('loading');
    //if(path.indexOf('/?c=') == -1) {
    //    path = "/tpl/"+path;
    //}
    $.ajax({
        type: "POST",
        data: "modal=1",
        url: path,
        cache: true,
        success: function(html){
            $('div#modal_content_remote').html(html);//remove();
            //$('body').append('<div id="modal_content_remote" style="display:block">'+html+'</div>');
            //if(modal_history.length!=0)
            modal('modal_content_remote'); // если история пустая, значит ответ html вызвал закрытие окна
        }
    });
}
function modalClose(auto) {
    //if(auto==0) {
    //    modal_history = [];
    //}
    $('div#modalC').hide();
    $('div#modal').hide();
    $('div#submodal').hide();
    $('div#'+modal_id).hide();
    //if(typeof(eval('window.'+modal_id+'_end'))=='function') {
    //    eval(modal_id+'_end'+'()');
    //}
    //modal_id = '';
    //is_modal_opened = 0;
}

function modal(id) {

    //if(id!='loading'&&id!='modal_content_remote'&&id!='video_modal') { // добавляем в историю, кроме исключений
    //    modal_history.push('modal(\''+id+'\')');
    //}

    //if(is_modal_opened==1) modalClose(1); // закрываем старое окно

    //if(id!='loading'&&typeof(modal_history)!=='undefined'&&modal_history.length>1) {
    //    $('#modal_back').show();
    //} else {
    //    $('#modal_back').hide();
    //}

    //if(id=='modal_content_remote'&&modal_history[modal_history.length-1].indexOf("c=chat&a=auth")==-1&&modal_history[modal_history.length-1].indexOf("c=accounts")==-1&&modal_history[modal_history.length-1].indexOf("c=prediction&a=add")==-1) {
    //    $('#modal_reload').show();
    //} else {
    //    $('#modal_reload').hide();
    //}

    //is_modal_opened = 1;
    //modal_id = id;
    var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
    var height = $(document).height();
    $('div#submodal').css('width',width+'px');
    $('div#submodal').css('height',height+'px');
    $('div#submodal').show();
    var top_offset = $(window).scrollTop() + 50;
    $('div#modal').css({"top":top_offset+'px'});
    if($('div#'+id).size()==1) {
        $('div#modal_content').append($('div#'+id));
    }
    $('div#'+id).show();
    $('div#modalC').show();
    $('div#modal').show();

    if(id!='loading') {
        $('div#modal').ready(function() {
            $('div#submodal').css('height',$(document).height()+'px');
        });
        $("div#modal img").load(function() {
            $('div#submodal').css('height',$(document).height()+'px');
        });
    }

    //if(typeof(eval('window.'+modal_id+'_start'))=='function') {
    //    eval(id+'_start'+'()');
    //}

    //tipp_reload();

}



</script>



<?php $this->widget('application.extensions.widgets.topbar.TopBarWidget', array(
    'username' => (Yii::app()->user->isGuest)?"Гость":Yii::app()->user->name,
)); ?><!-- /topbar -->



<div id="main" style="width:1080px; margin: 0 auto; background: rgb(244, 244, 244); margin-top:45px;">
    <?php echo $content; ?>
</div><!-- main -->

<?php if(!Yii::app()->user->isGuest): ?>
<script>

    $(document).ready( function () {

        var uid=<?php echo Yii::app()->user->getId(); ?>; //$(this).data("user-id");
        //user_name = $(this).parent().prev().prev().html();
        // alert(user_name);
        $.ajax({
            url: '<?php echo Yii::app()->CreateUrl("/user/profile/activity"); ?>',
            type: 'GET',
            data: "id="+uid,
            success: function (html) {
                //current_page=$("#yw1 .selected a").html();
                //new Noty('Онлайн: '+html+'!',4000);
                //$(".userlist").load($('#createurl-userpage').html()+current_page+' .userlist');
                onlineuser();
                return;
            }
        });
    });
</script>
<?php endif;?>

<script>
    function onlineuser() {
        //alert('yess');
        $.get('<?php echo Yii::app()->CreateUrl("/user/user/online",array("action"=>"count")); ?>', function(content){
            if (content=="0"){
                $(".useronline").parent().parent().hide();//html("Пользователей онлайн нет");
            }
            else {
                var text="пользователей";
                $(".useronline").parent().parent().show();
                $(".useronline").html(content);
            }
            //new Noty('Онлайн: '+content+'!',4000);
        });
        setTimeout(function(){onlineuser()},60000)
    }
    onlineuser();
</script>
<div id="scrollTop" style="width: 100px; display: block;"><div id="scrollTopButton">Вверх!</div></div>
</body>
</html>














