<ul class="actions">
	<li><a href="<?php echo $this->createUrl('inbox/') ?>">inbox
		<?php if (Yii::app()->getModule('message')->getCountUnreadedMessages(Yii::app()->user->getId())): ?>
			(<?php echo Yii::app()->getModule('message')->getCountUnreadedMessages(Yii::app()->user->getId()); ?>)
		<?php endif; ?>
	</a></li>
	<li><a href="<?php echo $this->createUrl('sent/sent') ?>">sent</a></li>
	<li><a href="<?php echo $this->createUrl('compose/') ?>">compose</a></li>
</ul>

<style>
select.folder  {
border: 0 !important;  /*Removes border*/
-webkit-appearance: none;  /*Removes default chrome and safari style*/
-moz-appearance: none; /* Removes Default Firefox style*/
background: #fefefe url(http://www.htmllion.com/img/demo/select-arrow.png) no-repeat 90% center;
width: 150px; /*Width of select dropdown to give space for arrow image*/
text-indent: 0.01px; /* Removes default arrow from firefox*/
text-overflow: "";  /*Removes default arrow from firefox*/ /*My custom style for fonts*/
color: #aaa;
border-radius: 5px;
padding: 5px;
box-shadow: inset 0 0 2px rgba(000,000,000, 0.5);
}

button.button {
    font-size: 100%;
    padding: .5em 1em;
    color: #444;
    color: rgba(0,0,0,.8);
    border: 1px solid #999;
    border: 0 rgba(0,0,0,0);
    background-color: #E6E6E6;
    text-decoration: none;
    border-radius: 2px;
}
button.button {
    display: inline-block;
    zoom: 1;
    line-height: normal;
    white-space: nowrap;
    vertical-align: baseline;
    text-align: center;
    cursor: pointer;
}

button.button:hover,.button.button:focus{
    filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#00000000', endColorstr='#1a000000', GradientType=0);
    background-image:-webkit-gradient(linear,0 0,0 100%,from(transparent),color-stop(40%,rgba(0,0,0,.05)),to(rgba(0,0,0,.1)));
    background-image:-webkit-linear-gradient(transparent,rgba(0,0,0,.05) 40%,rgba(0,0,0,.1));
    background-image:-moz-linear-gradient(top,rgba(0,0,0,.05) 0,rgba(0,0,0,.1));
    background-image:-o-linear-gradient(transparent,rgba(0,0,0,.05) 40%,rgba(0,0,0,.1));
    background-image:linear-gradient(transparent,rgba(0,0,0,.05) 40%,rgba(0,0,0,.1))}

button.button:focus{outline:0}

</style>

<div style="background: #f2f2f2; padding: 5px 15px; margin:5px; border-radius:2px; color: #888;">
    Папка:
    <select class="folder">
        <option value="1">Входяшие</option>
        <option value="2">Отправленные</option>
    </select>
    <button class="button">Написать письмо</button>

</div>

<?php if(Yii::app()->user->hasFlash('messageModule')): ?>
	<div class="success">
		<?php echo Yii::app()->user->getFlash('messageModule'); ?>
	</div>
<?php endif; ?>
