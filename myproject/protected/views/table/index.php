<?php
$this->breadcrumbs=array(
    "Турнирная таблица",
);
$this->layout='//layouts/column1';
?>

<h1 class="h1content"><?php echo 'Турнирная таблица'; ?></h1>

<script>

    $(document).ready(function(){

        $('#tour li a').click(function (){
        var text = $(this).html();//$('#mchatMsgF').val();
        //alert(text);
        //$('ul.sub').css('display','none');

        //return;
        //var REL = $(this).attr("rel");
        //var URL='<?php //echo Yii::app()->CreateUrl("/mchat/add"); ?>';
        var URL=Yii.app.createUrl('table/index');
        var dataString = 'matchday=' + text;// +'&rel='+ REL;
        //alert(dataString);
        //alert(URL+"  ---  "+text);
        $.ajax({
            type: "POST",
            url: URL,
            data: dataString,
            cache: false,
            success: function(html){
                //alert(html);
                $(".table-container ul").html(html);
                //$('#team li a').click();
                changeactiveteam($("#nowteam").html());
                return false;
            }
        });
        return false;
    });

        function changeactiveteam(team_id){
            //$(this).addClass('active');
            $("#tbl-"+team_id).addClass('active');
        }


        $('#team li a').click(function (){
            var team_id = $(this).data("team-id");//$('#mchatMsgF').val();
            $("#nowteam").html(team_id);
            //alert(team_id);
            $('#team li a').each(function(){
                $(this).removeClass('active');
            })
            $(this).addClass('active');

            $('.table').each(function(){
                $(this).removeClass('active');
            })
            $("#tbl-"+team_id).addClass('active');
            //$('ul.sub').css('display','none');


            return false;
        });


    });

</script>

<div style="display:none;" id="nowteam">0</div>


<!--<script src="<?php //echo Yii::app()->request->baseUrl; ?>/js/bootstrap.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css" />-->
    <style>

        #navig {height: 30px; border-radius: 5px; background: #f4f4f4; padding-top: 15px; padding-left: 20px; margin-bottom: 10px;}

        #navig ul.tabs2.tabs2-alt{margin-top:0;border-bottom:none;background:url(http://dribbble.com/assets/border-2px-5d31dcc1a131ea98fd9aacfdc7672010.gif) repeat-x bottom left}
        #navig ul.tabs2:after{content:".";display:block;height:0;clear:both;visibility:hidden}
        #navig ul.tabs2 li{position:relative;float:left;margin:0 20px 0 0;line-height:1;color:#bbb}
        #navig ul.tabs2 li.last{margin-right:0}
        #navig ul.tabs2 li span.count{display:none}
        #navig ul.tabs2 li a,#navig ul.tabs2 li span.empty{display:block;padding:0 0 18px 0;text-decoration:none;color:#999}
        #navig ul.tabs2-alt li a,#navig ul.tabs2-alt li span.empty{padding-bottom:8px}#navig ul.tabs2 li.empty{display:none}
        #navig ul.tabs2 li a:hover{color:#777}
        #navig ul.tabs2 li a:hover span.count{color:#999}
        #navig ul.tabs2 li.active a,#navig ul.tabs2 li.active span.empty{position:relative;top:-1px;font-weight:500;color:#444}
        #navig ul.tabs2 li.active a span.count,#navig ul.tabs2 li.active span.empty span.count{color:#777}ul.tabs2 li a span.notify{padding:1px 8px;text-transform:none;font-weight:bold;color:#fff;background:#8aba56;-webkit-border-radius:14px;-moz-border-radius:14px;border-radius:14px}
        ul.tabs2 li.active a span.notify{background:#666}
        #navig ul.tabs2 li a span.badge,#navig ul.tabs2 li a span.badge-sale{display:none}
        #navig ul.tabs2 li.has-dd{margin-right:8px}
        #navig ul.tabs2 li.has-dd>a{margin:-8px 0 0 -10px;padding:8px 23px 18px 10px;background-repeat:no-repeat;background-position:100% 14px;background-image:url()}
        @media (-webkit-min-device-pixel-ratio: 1.5), (min--moz-device-pixel-ratio: 1.5), (-o-min-device-pixel-ratio: 3 / 2), (min-device-pixel-ratio: 1.5), (min-resolution: 1.5dppx){#navig ul.tabs2 li.has-dd>a{background-image:url(http://updatesite.ru/image/tmpl/icon-dd-arrow.png);-webkit-background-size:18px 5px;-moz-background-size:18px 5px;background-size:18px 5px}}@media screen and (min-width: 800px){#navig ul.tabs2 li.has-dd:hover>a,#navig ul.tabs2 li.has-dd>a:hover{color:#444;background-color:#fff;-webkit-border-radius:6px;-moz-border-radius:6px;border-radius:6px;-webkit-border-bottom-left-radius:0;-webkit-border-bottom-right-radius:0;-moz-border-radius-bottomleft:0;-moz-border-radius-bottomright:0;border-bottom-left-radius:0;border-bottom-right-radius:0;-webkit-box-shadow:1px 1px 1px rgba(0,0,0,0.2);-moz-box-shadow:1px 1px 1px rgba(0,0,0,0.2);box-shadow:1px 1px 1px rgba(0,0,0,0.2)}}
        #navig ul.tabs2 li.has-dd.hover>a{color:#444;background-color:#fff;-webkit-border-radius:6px;-moz-border-radius:6px;border-radius:6px;-webkit-border-bottom-left-radius:0;-webkit-border-bottom-right-radius:0;-moz-border-radius-bottomleft:0;-moz-border-radius-bottomright:0;border-bottom-left-radius:0;border-bottom-right-radius:0;-webkit-box-shadow:1px 1px 1px rgba(0,0,0,0.2);-moz-box-shadow:1px 1px 1px rgba(0,0,0,0.2);box-shadow:1px 1px 1px rgba(0,0,0,0.2)}
        #navig ul.tabs2 li ul.sub{position:absolute;display:none;float:left;width:132px;margin:-10px 0 0 -10px;padding:10px 0;background:#fff;-webkit-border-radius:6px;-moz-border-radius:6px;border-radius:6px;-webkit-border-top-left-radius:0;-moz-border-radius-topleft:0;border-top-left-radius:0;;border-top-right-radius:0;-webkit-box-shadow:1px 2px 2px rgba(0,0,0,0.2);-moz-box-shadow:1px 2px 2px rgba(0,0,0,0.2);box-shadow:1px 2px 2px rgba(0,0,0,0.2);-webkit-background-clip:padding-box;-moz-background-clip:padding-box;background-clip:padding-box;z-index:999}@media screen and (min-width: 800px){#navig ul.tabs2 li:hover ul.sub{display:block}}
        #navig ul.tabs2 li.hover ul.sub{display:block}
        #navig ul.tabs2 li ul.sub li{clear:left;float:none;margin:0}
        #navig ul.tabs2 li ul.sub li a{float:none;margin:0;padding:5px 15px;font-size:13px;font-weight:normal;color:#555}
        #navig ul.tabs2 li ul.sub li a.active{color:#fff; background:#fe444b}
        #navig ul.tabs2 li ul.sub li a:hover{color:#777;background:#f4f4f4}
        #navig ul.tabs2 li ul.sub li a:active{color:#444;background:#ddd}
        #navig ul.tabs2 li ul.sub li a.title-link{font-weight:500;color:#777}


    </style>

    <div id="navig">
        <div style="font-size: 16px; float:left;"><span>Текущий тур: <strong><?php echo $cmday; ?></strong></span></div>
        <ul class="shot-menu tabs2">
            <li class="has-dd active srght">
                <a href="#">Выберите тур <span class="caret"></span></a>
                <ul id="tour" class="sub">
                    <?php for($i=0;$i<$cmday;$i++) echo "<li><a href=\"#\">".($i+1)."</a></li>" ?>
                </ul>
            </li>
            <li class="has-dd active srght">
                <a href="#">Выберите команду <span class="caret"></span></a>
                <ul id="team" class="sub" style="width:163px;">
                    <?php for($i=0;$i<count($listteam['team']);$i++) echo "<li><a data-team-id=\"".$listteam['id'][$i]."\" href=\"#\">".$listteam['team'][$i]."</a></li>" ?>
                </ul>
            </li>
        </ul>
    </div>


    <style>
        .caret {
            display: inline-block;
            width: 0;
            height: 0;
            margin-left: 2px;
            vertical-align: middle;
            border-top: 4px solid;
            border-right: 4px solid transparent;
            border-left: 4px solid transparent;
        }

    </style>

    <div class="table-container">
    <div style="padding-bottom:5px;"></div>
    <ul>
        <?php for($i=0;$i<count($result['teams']);$i++): ?>
            <?php $this->renderPartial('_view',array(
                'team'=>$result['teams'][$i],
                'stats'=>$result['stats'][$i],
                'number'=>($i+1),
                'head'=>true,
            )); ?>
        <?php endfor; ?>
    </ul>
</div>
<strong>Обозначения:</strong> <b>И</b> - Игр сыграно, <b>О</b> - Очков, <b>Пб</b> - Побед, <b>Н</b> - Матчей, сыгранных в ничью,
<b>Пр</b> - Поражений, <b>ЗП</b> - Забито мячей и пропущено, <b>Р</b> - Разница забитых и пропущенных.

<style>
    .table-container {overflow:hidden; margin:20px 0 12px;}
    .table {width: 100%; float:left; height:20px; line-height:20px; background:#e8e8e0; border-radius:3px; font-size:11px; color:#000; margin:2px 10px 0 0;}
    .table:hover {background: rgba(18, 158, 248, 0.14)
    }
    .table .table-th{color: white !important; font-weight: bold;}
    .t-th{background: #4096EA;  height:24px; line-height:24px;}
    .table .item {padding:0 6px; float:left; border-left:0px solid #c8c8c3;}


    li.active.table {background: #fe444b;color: white !important;}
    li.active.table .item{background: #fe444b;color: white !important;}
    li.active.table .teamhome a{color: white !important;}
    li.active.table .line-th{color: white !important;}
    li.active.table .line-th span{color: white !important;}
    .table .item:first-child {border-left:0;}
    .table .width50 {width:50px}
    .table .width30 {width:30px}
    .table .width70 {width:70px}
    .table .number {width:18px;}
    .table .teamhome {width:170px;}
    .table .teamhome .line-td {float:left;}
    .table .teamhome a, .game .teamaway a{text-decoration: none; color: #222;height: 16px; background-repeat: no-repeat; background-size: 14px 14px;}
    .table .teamhome a:hover, .game .teamaway a:hover{color: #444}
    .table .teamaway {width:130px; text-align:left;}
    .table .score a{text-decoration:none; color:white; padding: 0 10px; border-radius: 2px;}
    .table .score a.fulltime{background: #fe444b;}
    .table .score a.nulltime{background: #bbb;}
    .table .score a:hover{background: #888}
    .table .line-th {float:left; font-size: 12px; text-align:center; color: #555; margin:0px 0px 0 0;}
    .table .line-th span {color: #888;}
    .table .line-td {font-size:13px; font-weight:bold; float:left;}
    .table .line-td span {font-size:17px; color: #555;}
    .short-statistic-descr {color:#a1a1a1; overflow:hidden;margin:5px;}
</style>