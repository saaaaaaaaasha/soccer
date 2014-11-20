<?php
$this->breadcrumbs=array(
	UserModule::t("Users"),
);
if(UserModule::isAdmin()) {
	$this->layout='//layouts/column2';
	$this->menu=array(
	    array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin')),
	    array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('profileField/admin')),
	);
}
?>

<h1><?php echo UserModule::t("List User"); ?></h1>

<ul class="userlist">
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
    'itemView' => '/user/_view',
    'sortableAttributes'=>array(
        'username',
        'create_at',
    ),
    'sorterHeader' => 'Сортировать по:',
    'summaryText' => 'Зарегистрировано: <strong>{count}</strong> | Показано с <strong>{start}</strong> по <strong>{end}</strong>',
    'pagerCssClass'=>'custom-pager',

	/*'columns'=>array(
		array(
			'name' => 'username',
			'type'=>'raw',
			'value' => 'CHtml::link(CHtml::encode($data->username),array("user/view","id"=>$data->id))',
		),
		'create_at',
        array(
            'name' => 'lastvisit_at',
            //'value' => (($this->model->lastvisit_at!='0000-00-00 00:00:00')?$this->model->lastvisit_at:UserModule::t('Not visited')),
        ),
	),*/
)); ?>
</ul>


<div id="createurl-unsub" style="display:none;"><?php echo Yii::app()->CreateUrl("/friend/unsub"); ?></div>
<div id="createurl-delete" style="display:none;"><?php echo Yii::app()->CreateUrl("/friend/delete"); ?></div>
<div id="createurl-add" style="display:none;"><?php echo Yii::app()->CreateUrl("/friend/add"); ?></div>
<div id="createurl-userpage" style="display:none;"><?php echo Yii::app()->CreateUrl("/user/user/index/User_page")."/";?></div>
<script>



    $(document.body).on("click", ".unsub_user", function (event) {
        var uid=$(this).data("user-id");
        user_name = $(this).parent().prev().prev().html();
        $.ajax({
            url: $('#createurl-unsub').html(),
            type: 'POST',
            data: "unsubfriend="+uid,
            success: function (html) {
                current_page=$("#yw1 .selected a").html();
                new Noty('Вы отписались от '+user_name+'',4000);
                $(".userlist").load($('#createurl-userpage').html()+current_page+' .userlist');
                return;
            }
        });
        event.preventDefault();
    });
    $(document.body).on("click", ".delete_user", function (event) {
        var uid=$(this).data("user-id");
        user_name = $(this).parent().prev().prev().html();
        $.ajax({
            url: $('#createurl-delete').html(),
            type: 'POST',
            data: "deletefriend="+uid,
            success: function (html) {
                current_page=$("#yw1 .selected a").html();
                new Noty('Вы успешно удалили из друзей '+user_name+'',4000);
                $(".userlist").load($('#createurl-userpage').html()+current_page+' .userlist');
                return;
            }
        });
        event.preventDefault();
    });
    $(document.body).on("click", ".add_user", function (event) {
        var uid=$(this).data("user-id");
        user_name = $(this).parent().prev().prev().html();
        // alert(user_name);
        $.ajax({
            url: $('#createurl-add').html(),
            type: 'POST',
            data: "addfriend="+uid,
            success: function (html) {
                current_page=$("#yw1 .selected a").html();
                new Noty('Вы успешно подписались на '+user_name+'!',4000);
                $(".userlist").load($('#createurl-userpage').html()+current_page+' .userlist');
                return;
            }
        });
        event.preventDefault();
    });
</script>