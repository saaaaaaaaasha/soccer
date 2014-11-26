<div class="forecast">
 
<h1>Конкурс прогнозов</h1>
    
<div class="table">    
<?php echo CHtml::beginForm();


$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$model,
    'enablePagination' => true,
    'cssFile' => Yii::app()->request->baseUrl .'/css/grid.css',
    'pager' => array(        
           'prevPageLabel'=>'Предыдущий тур',
           'nextPageLabel'=>'Следующий тур',           
           'maxButtonCount'=>'0',
           'header'=>''
       ),    
    'template'=>"{pager}<br/><hr/>{items}",
    'columns' =>array(
                
                    array (
                        'header'=>'Первая команда',    
                        'name'=>'hometeam_rusname',
                        //'cssClassExpression'=>'hometeam',
                        'type' =>'raw',
                        'value'=>'$data["hometeam_rusname"]." ".CHtml::image("'.Yii::app()->request->baseUrl .'/images/soccer/team/$data[hometeam_logo_img]","",array("class"=>"logo_img"));',
                    ),                           
                    array(
                        'name' =>'t1_homegoals',
                        'header'=>'Счет',
                        'value'=>'$data["t1_homegoals"].":".$data["t1_awaygoals"]',                     
                       // 'cssClassExpression'=>'account',
                    ),
                     array (
                        'header'=>'Вторая команда',
                        'name'=>'awayteam_rusname',                         
                        'type' =>'raw',
                        'value'=>'CHtml::image("'.Yii::app()->request->baseUrl .'/images/soccer/team/$data[awayteam_logo_img]","",array("class"=>"logo_img"))." ".$data["awayteam_rusname"];',
                    ),         

                      array(
                        'name' =>'t2_homegoals',
                        'header'=>'Прогноз',
                        'value'=> '$data["status"]!=0?$data["t2_homegoals"].":".$data["t2_awaygoals"]:'
                          .'CHtml::TextField("goals[$data[id]][home]",$data["t2_homegoals"]).":".'
                          .'CHtml::TextField("goals[$data[id]][away]",$data["t2_awaygoals"])',
                        'type'=>'raw',
                      //  'cssClassExpression'=>'account',
                    ),    
                    
                    array(
                        'name'=>'scores',
                        'header'=>'Очки',   
                       // 'cssClassExpression'=>'scores',
                    ),
        )
));

?>
 
<?php echo CHtml::ajaxSubmitButton('Сохранить', '', array(
    'type' => 'POST',
   'success'=>"js:function(data){
            alert('Сохранено!');
        }"

));
  
 echo CHtml::endForm(); 

 
?>
</div><!-- form -->

  
         
        
    

<div class = "statistics">
    <div class = "statistics_player">
        <h3>Статистика игрока:</h3>
        
        <table>
            <tr>
                <td>Пользователь:</td>
                <td><?php echo Yii::app()->getModule('user')->getName(Yii::app()->user->id) ;?></td>
            </tr>
            <tr>
                <td>Очки в турнире:</td>
                <td><?php echo$statistics_arr['score_turn_pl'];?> </td>
            </tr>
            <tr>
                <td>Очки в туре:</td>
                <td><?php echo$statistics_arr['score_tur_pl'];?> </td>
            </tr>
            <tr> 
                <td>Успех:</td>
                <td><?php echo$statistics_arr['success_pl'];?></td>
            </tr>
        </table>
    </div>
        
        
      
        

    <div class = "statistics_tournament"> 
        <h3>Статистика турнира:</h3>

        <table>
            <tr>
                <td>Тур:</td>
                <td><?php echo$statistics_arr['matchday'];?></td>
            </tr>
            <tr>
                <td>Всего участников в трунире:</td>
                <td><?php echo$statistics_arr['players_turn'];?></td>
            </tr>
            <tr>
                <td>Всего прогнозов в турнире:</td>
                <td><?php echo$statistics_arr['statistics_turn'];?></td>
            </tr>
            <tr>
                <td>Всего участников в туре:</td>
                <td><?php echo $statistics_arr['players_tur'];?></td>
            </tr>
            <tr>
                <td>Всего прогнозов в туре:</td>
                <td><?php echo$statistics_arr['statistics_tur'];?></td>
            </tr>
        </table>
        
    </div>
</div>

<div class="best_player">
    <h3>Лидеры турнира:</h3>
    <hr/>
    
    <?php
        foreach ($statistics_arr['best_player'] as $best_player){
            echo Yii::app()->getModule('user')->getName($best_player["user_id"]);
            echo ":".$best_player["scores"];
            echo "<br/>";
        }
    ?>
</div>

<div class=news_tournament">
    <h3>Новости турнира:</h3>
    <hr/>
</div>