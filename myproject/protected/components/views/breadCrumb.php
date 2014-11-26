<div id="breadCrumb">
    <div style="float:left; padding-right:15px;">
    <?php
    foreach($this->crumbs as $crumb) {
        if(isset($crumb['url'])) {
            echo CHtml::link($crumb['name'], $crumb['url']);
        } else {
            echo "<strong>".$crumb['name']."</strong>";
        }
        if(next($this->crumbs)) {
            echo $this->delimiter;
        }
    }
    ?>
        </div>
    <script type="text/javascript" src="//yastatic.net/share/share.js" charset="utf-8"></script>
    <div  style="margin-top:-4px;" data-yasharetype="small" class="yashare-auto-init" data-yashareL10n="ru" data-yashareQuickServices="vkontakte,facebook,twitter,moimir,gplus" data-yashareTheme="counter"></div>
</div>