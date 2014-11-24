<?php

class ScheduleWidget extends CWidget
{
    /**
     * @var string имя пользователя
     */
    public $username = '';

    /**
     * Запуск виджета
     */
    public function run()
    {
        $format = 'Y-m-d H:i:s';

        $matches=SoccerMatch::model()->findAll(array(
            'condition' => 'date>=:date',
            'limit' => 5,
            'params' => array(':date' => Date('Y-m-d 0:0:0',strtotime(gmdate($format)))),
        ));

        //$matchday=$match->matchday-1;
        //$date=date
        //$matchs=SoccerMatch::model()->findAll('matchday=:md',array('md'=>$matchday));

        $this->render('index', array(
            'matchs' => $matches,
        ));
    }
}