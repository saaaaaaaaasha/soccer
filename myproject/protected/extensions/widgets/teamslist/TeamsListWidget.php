<?php

class TeamsListWidget extends CWidget
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


/*<h1>Привет <?php echo $username; ?>!</h1>*/