<script>
    function livegameright() {
        //alert('yess');
        //var id_game=$("#game").data("id-game");
        //alert(id_game);
        $( "#minilivegames" ).load( '/myproject/ #minilivegames');

        //$.get('/myproject/games/'+id_game+' #game', function(content){
        //alert(content);
        //$("#game").html(content);
        /*if (content=="0"){
         $(".useronline").parent().parent().hide();//html("Пользователей онлайн нет");
         }
         else {
         var text="пользователей";
         $(".useronline").parent().parent().show();
         $(".useronline").html(content);
         }*/
        //new Noty('Онлайн: '+content+'!',4000);
        //});
        setTimeout(function(){livegameright()},30000)
    }
    livegameright();
</script>


<table id="minilivegames" class="stat-table results" cellpadding="0" cellspacing="0">
<tr>
    <td colspan="3" style="text-align:center">воскресенье <b>23 ноября</b></td>
</tr>
    <?php foreach($matchs as $match): ?>
<tr data-match-id="976063">
    <!--<td class="gray-text">14:30</td>-->
    <td class="owner-td">

        <!--<div style="float: left;color: white;background: #F73737;padding: 2px 5px;display: inline-block;line-height: 11px;margin-top: 5px;font-weight: bold;font-size: 10px;border-radius: 2px;">LIVE</div>-->
        <div class="rel"><a class="player" href="<?php echo Yii::app()->baseUrl."/team/".$match->hometeam->id; ?>" title="<?php echo $match->hometeam->rusname; ?>"><?php echo Text::GetShotName2($match->hometeam->rusname); ?></a><i class="flag-s" style="background-image: url(<?php echo Yii::app()->baseUrl."/images/soccer/team/".$match->hometeam->logo_img ;?>);" title="Англия" alt="Англия"></i></div></td>
    <td class="score-td"><a class="score" href="<?php echo Yii::app()->baseUrl."/games/".$match->id; ?>"><noindex><b><?php echo Text::getScoreMatch($match->homegoals,$match->awaygoals); ?></b></noindex></a></td>
    <td class="guests-td"><div class="rel"><i class="flag-s" style="background-image: url(<?php echo Yii::app()->baseUrl."/images/soccer/team/".$match->awayteam->logo_img ;?>);" title="Англия" alt="Англия"></i><a class="player" href="<?php echo Yii::app()->baseUrl."/team/".$match->awayteam->id; ?>" title="<?php echo $match->awayteam->name; ?>"><?php echo Text::GetShotName2($match->awayteam->rusname); ?></a></div></td>
</tr>
    <?php endforeach; ?>
</table>


<style>
    .stat-table.results {
        font-size: 11px;
        table-layout: auto;
    }
    .stat-table {
        font-size: 13px;
        width: 100%;
        text-align: center;
        table-layout: fixed;
    }
    .stat-table.results .owner-td {
        padding-left: 8px;
        width: 107px;
    }
    .stat-table .owner-td {
        padding-right: 5px;
        text-align: right;
        white-space: nowrap;
    }
    .stat-table TD, .stat-table THEAD .score-td {
        background: #f9f9f7;
        /*border-top: 1px solid #d8d8d8;*/
        border-bottom: 1px solid #d8d8d8;
        vertical-align: middle;
        line-height: 24px;
    }
    .stat-table TD {
        white-space: nowrap;
    }
    .stat-table .owner-td .rel > .fader {
        right: 16px;
        top: 2px;
        width: 9px;
        background-position: 1px 0;
        z-index: 5;
    }
    .fader {
        display: block;
        position: absolute;
        top: 0;
        right: -5px;
        background: url(http://s5o.ru/common/css/i/fader.png) repeat-y 0 0;
        width: 14px;
        height: 22px;
    }
    /*.stat-table .owner-td .player, .stat-table .owner-td .flag-s, .stat-table .owner-td .player-score {
        float: right;
    }*/
    .stat-table .flag-s {
        display: inline-block;
        margin: 3px 0 0;
        vertical-align: top;
    }
    .flag-s.flag-1413 {
        background-position: -113px -3px;
    }
    .flag-s {
        /*background-image: url(http://s5o.ru/common/css/i/flags-sprite.png);*/
        background-repeat: no-repeat;
        background-size:16px 16px;
        display: inline-block;
        width: 16px;
        height: 16px;
    }
    .stat-table.results .owner-td .player {
        padding: 0 5px 0 0;
    }
    .stat-table.results .player {
        max-width: auto;
        width: 56px;
        position: static;
    }
    .stat-table .player {
        overflow: hidden;
        position: relative;
        display: inline-block;
        vertical-align: top;
        white-space: nowrap;
        max-width: 60px;
        padding: 0 5px;
    }
    .stat-table A {
        text-decoration: none;
    }
    .stat-table .score {
        display: inline-block;
        vertical-align: top;

    }
    .stat-table.results .guests-td {
        padding-right: 8px;
        width: 50px;
    }
    .stat-table .guests-td {
        padding-left: 5px;
        text-align: left;
        white-space: nowrap;
    }
    .stat-table .score-td {
        /*width: 60px;*/
        background: #e8e8e0;
        text-align: center;
        padding: 0 5px;
    }

</style>