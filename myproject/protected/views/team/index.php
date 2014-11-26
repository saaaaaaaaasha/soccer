<?php
$this->layout='//layouts/column1';
$this->setPageTitle("Список команд");
?>

<?php $this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Главная', 'url' => array('')),
        array('name' => 'Команды'),
    )
)); ?>

<h1 class="h1content"><?php echo 'Список команд'; ?></h1>