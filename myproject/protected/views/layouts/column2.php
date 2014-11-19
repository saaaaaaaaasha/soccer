<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
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
</div>
<?php $this->endContent(); ?>