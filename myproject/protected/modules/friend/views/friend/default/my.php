<?php
$this->breadcrumbs=array(
    MessageModule::t("Мои друзья"),
);
?>




<style>
    ul, ol {padding-left: 0 !important;}
    .userlist li.user .useravatar,.buttonsrelationship{text-align:center; margin-bottom:5px; }
    .userlist li.user .useravatar img{ border-radius:100px; height: 110px; width:110px;}
    .userlist li.user{float: left; width:22%; list-style-type: none;padding-bottom:15px;height: 185px;}
    .userlist:after{
        content:'';
        display:block;
        clear: both;
    }
    .userlist .userlogin{font-weight:bold; font-size:16px; color: #555; text-align: center;}
    .userlist .userlogin a{text-decoration: none; color: #555;}
    .userlist .username{font-weight:normal; font-size:13px; color: #aaa; text-align: center;}



    .list-view .sorter,.list-view .summary {
        text-align: left !important;
    }
    /*.list-view strong {color: #fff; background: #00b3ee; padding: 0px 5px; border-radius: 2px;}*/
    /*.list-view .sorter:after {
        content:'';
        display:block;
        clear: both;
        height:1px;
        margin: 10px 0px;
        background: #eee;
    }*/

    .buttonsrelationship
    {
        text-align:center;
        margin:5px 1px;
    }

    .buttonsrelationship a{
        padding: 2px 4px;
        border-radius: 3px;
        font-size:9px;
        font-weight: bold;
        text-align: center;
        color:#fff;
        /*margin:3px 1px;*/

        text-decoration: none;
        text-transform: uppercase;
        font-family: "Tahoma","Arial",sans-serif;
    }
    .buttonsrelationship a:hover,.userlist li.user .useravatar img:hover,.userlist .userlogin a:hover{
        opacity:0.7;
    }
    .buttonsrelationship a.add_user{
        background: linear-gradient(to top, #1A9CBC, #26C3E4);
    }
    .buttonsrelationship a.unsub_user{
        background: linear-gradient(to top, #c2c2c2, #d2d2d2);
    }
    .buttonsrelationship a.delete_user{
        background: linear-gradient(to top, #DE386A, #D3395B);
    }
    .buttonsrelationship a.send_mail{
        background-image: url('/myproject/images/buttonsend.png');
        background-repeat: no-repeat;
        background-position: 0 0;
        background-color: #1A9CBC;
        width: 30px;
        padding-right: 15px;
        height: 20px;
        margin-left: 3px;

    }

</style>


<h1><?php echo FriendModule::t("Мои друзья"); ?></h1>


<ul class="userlist">


    <?php $form = $this->beginWidget('CActiveForm', array(
        'enableAjaxValidation'=>false,
    )); ?>


    <?php foreach ($friendsAdapter->data as $index => $friend): ?>
        <?php $this->renderPartial('/friend/default/_view',array(
            'data'=>$friend->friend,
        )); ?>
    <?php endforeach ?>

    <?php $this->endWidget(); ?>
    <?php $this->widget('CLinkPager', array('pages' => $friendsAdapter->getPagination())) ?>


</ul>




<script>

</script>