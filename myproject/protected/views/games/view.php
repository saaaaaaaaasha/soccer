<?php
$this->breadcrumbs=array(
    //UserModule::t('Users')
    "Матчи"=>array('index'),
    $model->hometeam->rusname." - ".$model->awayteam->rusname." (".$model->matchday." тур)",
);
$this->layout='//layouts/column2';

?>

<h1><?php echo 'Отчет матча <strong>«'.$model->hometeam->rusname.'» </strong> vs <strong>«'.$model->awayteam->rusname.'» </strong>'; ?></h1>

<div id="timer" align="center"></div>
<div id="game" data-id-game="<?php echo $model->id?>">
<h2>Основная информация</h2>

<ul>
    <li><b>Счет: </b><?php echo SoccerMatch::getResultMatch($model->homegoals,$model->awaygoals); ?></li>
    <li><b>Статус мачта: </b><?php echo SoccerMatch::getStatusMatch($model->status); ?></li>
    <li><b>Стадион: </b><?php echo $model->stadium->name; ?></li>
    <li><b>Тур матча: </b><?php echo $model->matchday; ?></li>
</ul>

<?php if ($events): ?>
<h2>Основные события</h2>

<ul class="events" style="width:350px;">
<?php //print_r($events);
foreach($events as $event){
    echo SoccerMatch::getLineEvent($event);
}
?>
</ul>
<?php endif; ?>
<?php if ($commentaries): ?>
<h2>Лента событий</h2>
<div class="commentaries" style="max-height: 220px; overflow-y: auto; width:450px;">
<?php //print_r($events);
foreach($commentaries as $comment){
    echo SoccerMatch::getCommentaries($comment);
}
?>
</div>
<?php endif; ?>

<?php if ($players_h): ?>
<h2>Основной состав</h2>
<div class="players_team" style="float: left; height: 280px; overflow-y: auto; width:300px;">
    <?php //print_r($events);
    foreach($players_h as $player){
        echo SoccerMatch::getPlayer($player);
    }
    ?>
</div>
<div class="players_team" style="height: 280px; overflow-y: auto; width:300px;">
    <?php //print_r($events);
    foreach($players_a as $player){
        echo SoccerMatch::getPlayer($player);
    }
    ?>
</div>
<?php endif; ?>


</div>

<style>

 </style>

<script>
    function updateposevents(){
        $('.events div.event_at').sort(function(a,b) {
            var a = $(a).data('minute');
            var b = $(b).data('minute');
            if (a<10) a="0"+a;
            if (b<10) b="0"+b;
            return a > b;
            //return ($(a).data('minute')+0) > ($(b).data('minute')+0);
        }).appendTo('.events');
        setTimeout(function(){updateposevents()},500)
    }
    updateposevents();

    /* ТАЙМЕР ОБРАТНОГО ОТСЧЕТ МАТЧА */
    function timerIn(totalRemains) {

        // Время остатка
        totalRemains = timer_start - (Math.round(new Date().getTime()/1000) + timer_diff);
        //alert(totalRemains);

        if (totalRemains>1) { /* если разница между временем и стартом больше одной милисекунды то обрабатываем таймер*/
            /* var tStart = new Date(); */
            var RemainsSec = (parseInt(totalRemains)); 						/* вычисляем кол-во секунд в разнице времени */
            var RemainsFullDays = (parseInt(RemainsSec/(24*60*60)));				/* из него определяем количество целых суток (24часа) */
            var secInLastDay = RemainsSec-RemainsFullDays*24*3600;				/* количество секунд в текущем дне */
            var RemainsFullHours = (parseInt(secInLastDay/3600));					/* кол-во оставшихся часов в сутках */
            if(RemainsFullHours<10) {RemainsFullHours="0"+RemainsFullHours};	/* Если количество часов <10 то подставляем 0 перед символом */
            var secInLastHour = secInLastDay-RemainsFullHours*3600;				/* количество секунд в последнем часе */
            var RemainsMinutes = (parseInt(secInLastHour/60));					/* количество минут в последнем часе */
            if(RemainsMinutes<10) {RemainsMinutes="0"+RemainsMinutes};			/* Если кол-во минут <10 то подставляем 0 перед символом */
            var lastSec = secInLastHour-RemainsMinutes*60;						/* количество секунд в последней минуте */
            if(lastSec<10) {lastSec="0"+lastSec};								/* Если количество секунд <10 то подставляем 0 перед символом */
            /* обновления таймер */
            $("#timer-day span").html(RemainsFullDays);
            $("#timer-hour span").html(RemainsFullHours);
            $("#timer-min span").html(RemainsMinutes);
            $("#timer-sec span").html(lastSec);
            totalRemains = totalRemains-1;
            /* var tEnd = new Date();
             /* перезапускаем функцию таймера через секунду (таким образом таймер перезапускает сам себя каждую секунду) */
            /* setTimeout("timerIn("+totalRemains+")",(1000-(tEnd.getTime()-tStart.getTime()))); */
            setTimeout("timerIn("+totalRemains+")",1000);
        } else {
            $("#timer").fadeOut('slow')
            /* иначе перезагружаем страницу */
            /*	setTimeout('location.replace("<?php //echo $time_tmp_url; ?>")', 1000); */
        }
    }

</script>

<?php if($model->status!="FT"): ?>
<script type="text/javascript">

    var timer_diff = <?php $format = 'Y-m-d H:i:s'; echo strtotime(gmdate($format));?> - Math.round(new Date().getTime()/1000);
    var timer_start = <?php echo strtotime($model->date);?>;//1416668400;
    $("#timer").fadeIn('slow');
    $('#timer').html('<div id="timer-header">до начала матча осталось</div><div id="timer-day"><span></span><br>дней</div><div id="timer-hour"><span></span><br>часов</div><div id="timer-min"><span></span><br>минут</div><div id="timer-sec"><span></span><br>секунд</div>');
    timerIn(0);

</script>
<script>
    function matchinfo() {
        //alert('yess');
        var id_game=$("#game").data("id-game");
        //alert(id_game);
        $( "#game" ).load( '/myproject/games/'+id_game+' #game' );


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
        setTimeout(function(){matchinfo()},10000)
    }
    matchinfo();
</script>
<?php endif; ?>




