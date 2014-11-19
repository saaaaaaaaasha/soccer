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
        $teams=SoccerTeam::model()->findAll();
        $this->render('index', array(
            'teams' => $teams,
        ));
    }
}