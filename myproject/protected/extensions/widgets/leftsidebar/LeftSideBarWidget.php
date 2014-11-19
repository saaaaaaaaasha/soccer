<?php

class LeftSideBarWidget extends CWidget
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
        $this->render('index', array(
            'username' => $this->username,
        ));

    }
}


/*<h1>Привет <?php echo $username; ?>!</h1>*/