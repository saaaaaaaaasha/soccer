<?php
$this->breadcrumbs=array(
    //UserModule::t('Users')
    "Матчи"=>array('index'),
    $model->hometeam->rusname." - ".$model->awayteam->rusname." (".$model->matchday." тур)",
);
$this->layout='//layouts/column2';

?>

<h1><?php echo 'Отчет матча <strong>«'.$model->hometeam->rusname.'» </strong> vs <strong>«'.$model->awayteam->rusname.'» </strong>'; ?></h1>

<h2>Основные события</h2>



<?php //print_r($events);
foreach($events as $event){
    echo "Тип: ".$event["type"]." | ";
    echo "Минута: ".$event["minute"]." | ";
    echo "Команда: ".$event["team"]." | ";
    echo "Игрок: ".$event["player_id"]."";
    echo "<br>";
}


?>

