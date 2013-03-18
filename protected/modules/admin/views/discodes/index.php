<?php $this->pageTitle='ID'; ?>
<?php
$this->breadcrumbs=array(
    'Админка'=>array('/admin/'),
    'Споты',
    'ID',
    'Управление',
);
?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('discodes-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление ДИС</h1>


<?php echo CHtml::link('Расширенный поиск', '#', array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
  <?php
  $this->renderPartial('_search', array(
      'model'=>$model,
  ));
  ?>
</div><!-- search-form -->

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'discodes-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        'id',
        array(
            'name'=>'premium',
            'type'=>'raw',
            'value'=>'$data->getPremium()',
            'filter'=>$model->getPremiumList(),
        ),
        array(
            'name'=>'status',
            'type'=>'raw',
            'value'=>'$data->getStatus()',
            'filter'=>$model->getStatusList(),
        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{update}',
        ),
    ),
));
?>
