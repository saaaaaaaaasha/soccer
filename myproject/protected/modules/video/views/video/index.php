
<div class="video">
    <h1>Видео</h1>
  

     <?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view_list',
)); ?>
</div> 