<div id="headerbar">
    <div id="headerbar-inner">
        <div id="logo"><a href="<?php echo Yii::app()->request->baseUrl; ?>"></a></div><span>Все об английском футболе на одном сайте!</span>
        <div id="search"><form id="search" name="search" action="<?php echo Yii::app()->CreateUrl("/search"); ?>" method="get">
                <input class="search-text placeholder" type="text" name="q" placeholder="Поиск " value="">
                <input type="hidden" name="view" value="search"/>
                <input type="hidden" name="search" value="Искать"/>
            </form>
        </div>
    </div>
</div>


<div id="header2"><div id="headerbar2-inner">
        <div id="header-inner">
            <a href="#nav" id="toggle-nav">Toggle navigation</a>
            <ul id="nav">
                <?php if(!Yii::app()->user->isGuest): ?>
                <li id="t-profile" style="margin-left: -20px;/*margin-right: 70px;*/ width: 200px;">
                    <a id="openleftmenu" href="#" class="has-sub">
                        <img class="topbarava" alt="Avatar-default" height="30" src="<?php echo Yii::app()->request->baseUrl; ?>/images/avatars/no/noavatar6.png" width="30">
                        <span class="profile-name" style="padding-left:10px;"><strong><?php echo $this->username ?></strong><!----></span>
                        <div class="topmenuuserbutton"></div>
                    </a>

                </li>
                <?php else: ?>
                <li id="t-signin">
                    <a href="#" onclick="modal_remote('<?php  echo Yii::app()->CreateUrl("//login"); ?>');"><span>Войти</span></a><span class="loginsocial"><span title="Совсем скоро" class="ls_facebook south"></span><span class="ls_twitter"></span><span class="ls_in"></span></span>
                </li>
                <li id="t-signup"><a href="<?php echo Yii::app()->CreateUrl(Yii::app()->getModule('user')->registrationUrl[0]); ?>"><strong>Присоединиться</strong></a></li>
                <?php endif; ?>


                <li id="t-shots">
                    <a href="http://mylfc.ru/recent" class="has-sub">Быстрая навигация</a>
                    <ul class="tabs">
                        <li class=""><a href="<?php echo Yii::app()->request->baseUrl; ?>">Главная страница</a></li>
                        <li class=""><a href="<?php echo Yii::app()->CreateUrl('/news/index'); ?>">Новости</a></li>
                        <li class=""><a href="<?php echo Yii::app()->CreateUrl('/timetable/index'); ?>"><strong>Расписание матчей</strong></a></li>
                        <li class=""><a href="<?php echo Yii::app()->CreateUrl('/photo/index'); ?>">Фотогалерея</a></li>
                        <li class=""><a href="<?php echo Yii::app()->CreateUrl('/video/index'); ?>">Видеоархив</a></li>
                    </ul>
                </li>

               <li id="t-teams">
                    <a href="http://mylfc.ru/teams" class="has-sub">Сезон</a>
                    <ul class="tabs">
                        <li class=""><a href="http://mylfc.ru/teams">Трансферы</a></li>
                        <li class=""><a href="http://mylfc.ru/teams">Календарь 2014/2015</a></li>
                        <li class=""><a href="http://mylfc.ru/teams">Расписание 2014/2015</a></li>
                        <li class=""><a href="http://mylfc.ru/teams?hiring=on">Турнирная таблица</a></li>
                        <li class=""><a href="http://mylfc.ru/teams?hiring=on">Бомбардиры</a></li>                        
                        <li class=""><a href="http://mylfc.ru/teams/info">Статистика</a></li>
                    </ul>
                </li>

                <li id="t-players">
                    <a href="http://mylfc.ru/sections" class="has-sub"><strong>Конкурс прогнозов</strong></a>
                </li>

                <li id="t-jobs">
                    <a href="http://mylfc.ru/jobs">Команды</a>
                    <ul class="tabs">
                        <li class=""><a href="http://mylfc.ru/jobs">@ Состав</a></li>
                        <li class=""><a href="http://mylfc.ru/jobs?location=Anywhere">Тренерский штаб</a></li>
                        <li class=""><a href="http://mylfc.ru/jobs?location=Anywhere">История клуба</a></li>
                        <li class=""><a href="http://mylfc.ru/jobs?teams_only=true">Рейтинг игроков</a></li>
                    </ul>
                </li>

                <li id="t-more">
                    <a href="http://mylfc.ru/users">
                        <span>More</span>
                    </a>      <ul class="tabs">
                        <li></li><li class=""><a href="http://mylfc.ru/users">Пользователи</a></li>

                        <li></li><li class=""><a href="http://mylfc.ru/rules">Правила сайта</a></li>
                        <li></li><li class=""><a href="http://mylfc.ru/tags">Тэги</a></li>
                        <li><a href="http://mylfc.ru/about">О сайте</a></li>
                        <li  class="separate"><a href="http://mylfc.ru/about"><b>Вакансии на сайте</b></a></li>
                        <li><a href="http://mylfc.ru/feedback">Отправить e-mail</a></li>

                    </ul>
                </li>
            </ul>

        </div>
    </div>
</div>










<?php /*$this->widget('zii.widgets.CMenu',array(
    'htmlOptions'=>array('class'=>'tabs'),
    'items'=>array(
        array('label'=>'Home', 'url'=>array('/site/index')),
        array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
        array('label'=>'Contact', 'url'=>array('/site/contact')),
        //array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
        //array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),

        array('url'=>Yii::app()->getModule('user')->loginUrl, 'label'=>Yii::app()->getModule('user')->t("Login"), 'visible'=>Yii::app()->user->isGuest),
        array('url'=>Yii::app()->getModule('user')->registrationUrl, 'label'=>Yii::app()->getModule('user')->t("Register"), 'visible'=>Yii::app()->user->isGuest),
        array('url'=>Yii::app()->getModule('user')->profileUrl, 'label'=>Yii::app()->getModule('user')->t("Profile"), 'visible'=>!Yii::app()->user->isGuest),
        array('url'=>Yii::app()->getModule('user')->logoutUrl, 'label'=>Yii::app()->getModule('user')->t("Logout").' ('.Yii::app()->user->name.')', 'visible'=>!Yii::app()->user->isGuest),


        array(
            'url' => Yii::app()->getModule('message')->inboxUrl,
            'label' => 'Сообщения' .
                (Yii::app()->getModule('message')->getCountUnreadedMessages(Yii::app()->user->getId()) ?
                    ' (' . Yii::app()->getModule('message')->getCountUnreadedMessages(Yii::app()->user->getId()) . ')' : ''),
            'visible' => !Yii::app()->user->isGuest),

        array(
            'url' => Yii::app()->getModule('friend')->myfriendsUrl,
            'label' => 'Друзья' .
                (Yii::app()->getModule('friend')->getCountFollowers(Yii::app()->user->getId()) ?
                    ' (' . Yii::app()->getModule('friend')->getCountFollowers(Yii::app()->user->getId()) . ')' : ''),
            'visible' => !Yii::app()->user->isGuest),

    ),




)); */?>


    <!--
    http://mylfc.ru?view=page&amp;name=cat 

    <li id="t-teams">
        <a href="http://mylfc.ru/teams" class="has-sub">Teams</a>
        <ul class="tabs">
            <li class=""><a href="http://mylfc.ru/teams">All</a></li>
            <li class=""><a href="http://mylfc.ru/teams?hiring=on">Now Hiring</a></li>
            <li class="separate"><a href="http://mylfc.ru/teams/info">Get Your Team On Dribbble</a></li>
        </ul>
    </li>
    <li id="t-jobs">
        <a href="http://mylfc.ru/jobs">Jobs</a>
        <ul class="tabs">
            <li class=""><a href="http://mylfc.ru/jobs">All</a></li>
            <li class=""><a href="http://mylfc.ru/jobs?location=Anywhere">Remote / Anywhere</a></li>
            <li class=""><a href="http://mylfc.ru/jobs?teams_only=true">@ Teams</a></li>
            <li class="separate"><a href="https://mylfc.ru/jobs/new">Post a Job</a></li>
        </ul>
    </li>-->




       <!--<ul class="tabs">

            <li class=""><a href="http://mylfc.ru/sections">Лучший пользватель</a></li>
            <li class=""><a href="http://mylfc.ru/section/4">Лучший ньюсмейкер</a></li>
            <li class=""><a href="http://mylfc.ru/section/1">Конкурсы в соц. сетях</a></li>
            <li class="separate"><a href="http://mylfc.ru/section/3">Оконченные конкурсы</a></li>

        </ul>-->
    
        <!--
         <ul class="tabs">
         <li><a href="/index/8" class="url" rel="contact">Мой профиль</a></li>
         <li><a href="/index/14">Мои сообщения <span class="badge badge-pro"><b>(0)</b></span></a> </li>
         <li><a href="/index/11">Настройки</a></li>
         <li><a href="/index/10" rel="nofollow">Выйти</a></li>
         </ul>-->
    <!--<li id="t-search">
        <form id="search" name="search" action="%address%" method="get">
          <input class="search-text placeholder" type="text" name="words" placeholder="Поиск " value="">
              <input type="hidden" name="view" value="search"/>
              <input type="hidden" name="search" value="Искать"/>
        </form><a href="/index/8" class="has-sub"><strong>Присоединиться</strong></a> <a href="/index/8" class="has-sub">Войти</a>
       

    </li>-->


    <!--
<li id="t-profile">
      <a href="%address%user/%username%" class="has-sub">
        <img alt="Avatar-default" height="16" src="ava.png" width="16">
        <span class="profile-name">%username%</span>
</a>
      <ul class="tabs">
        <li><a href="%address%user/%username%" class="url" rel="contact">%username%</a></li>
         <li><a href="%address%/admin" class="url" rel="contact">Админ панель</a></li>

        <li>
          <a href="/addnews">
            Выложить <span class="badge badge-pro">новость</span>
</a>        </li>
        <li class="separate"><a href="/account">Настройки</a></li>


        <li><a href="%address%functions.php?logout=1" rel="nofollow">Выйти</a></li>
      </ul>
    </li>-->


