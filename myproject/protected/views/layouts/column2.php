<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main');?>
<div class="middle" style="border-right:0 !important;">
    <div class="container">
        <main class="content">
            <?php if(isset($this->breadcrumbs)):?>
                <?php $this->widget('zii.widgets.CBreadcrumbs', array(
                    'links'=>$this->breadcrumbs,
                )); ?><!-- breadcrumbs -->
            <?php endif?>

            <?php echo $content; ?>
        </main><!-- .content -->
    </div><!-- .container-->

    <aside class="left-sidebar">
        <?php $this->widget('application.extensions.widgets.leftsidebar.LeftSideBarWidget', array(
            //'username' => (Yii::app()->user->isGuest)?"Гость":Yii::app()->user->name,
            //'menu' => $this->menu,
        )); ?>
        <div class="span-5">
            <div id="sidebar">
                <?php
                $this->beginWidget('zii.widgets.CPortlet', array(
                    'title'=>'Operations',
                ));
                $this->widget('zii.widgets.CMenu', array(
                    'items'=>$this->menu,
                    'htmlOptions'=>array('class'=>'operations'),
                ));
                $this->endWidget();
                ?>
            </div><!-- sidebar -->
        </div>
    </aside><!-- .left-sidebar -->
    <?php if (!Yii::app()->user->isGuest): ?>
        <aside id="leftmenu" style="position:fixed;top:85px; display:none; float:left; margin-left: -250px; width:250px; /*min-height:200px;*/ height:100%; color:fefefe; background: #1e1e1e;/* url(leftmenubg.png) 0 0;*/">
            <div class="leftbarsection">
                <div class="leftbartitle"><strong>Мой профиль</strong></div>
                <ul class="leftnav">
                    <li><a class="point" href="<?php echo Yii::app()->baseUrl."/user/profile" ?>">Персональная страница</a><span class="leftnavadd"><a href="<?php echo Yii::app()->baseUrl."/user/profile/edit" ?>">Ред.</a></span></li>
                    <li><a class="point" href="<?php echo Yii::app()->baseUrl.Yii::app()->getModule('friend')->myfriendsUrl[0]; ?>">Мои друзья</a>
                        <?php if(Yii::app()->getModule('friend')->getCountNewFollowed(Yii::app()->user->getId())): ?>
                            <span class="leftnavadd2"><a href="<?php echo Yii::app()->baseUrl.Yii::app()->getModule('friend')->myfriendsUrl[0]."/followed"; ?>">+<?php echo Yii::app()->getModule('friend')->getCountNewFollowed(Yii::app()->user->getId());?></a></span>
                        <?php endif; ?>
                    </li>
                    <li><a class="point" href="<?php echo Yii::app()->baseUrl.Yii::app()->getModule('message')->inboxUrl[0]; ?>">Мои сообщения</a>

                        <?php if(Yii::app()->getModule('message')->getCountUnreadedMessages(Yii::app()->user->getId())): ?>
                            <span class="leftnavadd2"><a href="<?php echo Yii::app()->baseUrl.Yii::app()->getModule('message')->inboxUrl[0]; ?>">+<?php echo Yii::app()->getModule('message')->getCountUnreadedMessages(Yii::app()->user->getId());?></a></span>
                        <?php endif; ?>

                    </li>


                    <li><a class="point" href="#">Мои уведомления</a></li>
                    <li style="margin:3px 0px; height:1px; padding-top:0px; padding-bottom:0px;"><hr style="background: #333;  border:0; /*border-bottom:1px solid #333;*/"></li>
                    <li><a class="point" href="<?php echo Yii::app()->baseUrl."/logout" ?>">Выйти</a></li>
                    <li style="margin:3px -1px; background: #2f95fe url(leftmenudollars.png) repeat-x; padding: 6px 15px;"><span style="font-size: 20px;
font-weight: 700;">$105</span> на счету<span class="leftnavadd3"><a href="#">Магазин</a></span></li>
                    <!--<li><a class="point" href="#">Новости с тэгом <strong>#Ливерпуль</strong></a></li>-->
                </ul>
                <div style="clear:both;"></div>
                <div style="padding: 2px 10px 5px 10px">Ваш рейтинг равен: <strong>2523</strong></div>
            </div>

            <div class="leftbarsection">
                <div class="leftbartitle">События клуба <strong>"Ливерпуль"</strong></div>
            </div>
        </aside>
    <?php endif; ?>

</div>
<?php $this->endContent(); ?>