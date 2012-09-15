<?php $this->pageTitle = 'Споты'; ?>
<?php
$this->breadcrumbs = array(
    'Админка' => array('/admin/'),
    'Споты' => array('/admin/spot/'),
    'Управление'
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('spot-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php echo CHtml::link('Сгенерировать активационные коды', '/admin/spot/generate'); ?><br/>
<?php echo CHtml::link('Расширенный поиск', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array(
    'model' => $model,
)); ?>
</div><!-- search-form -->

<?php if (Yii::app()->user->hasFlash('spot')): ?>
<div class="success">
    <?php echo Yii::app()->user->getFlash('spot'); ?>
</div>
<?php endif; ?>

<?
$this->widget('ext.selgridview.SelGridView', array(
    'id' => 'spot-grid',
    'dataProvider' => $model->search(),
    'selectableRows' => 2,
    'filter' => $model,
    'columns' => array(
        array(
            'class' => 'CCheckBoxColumn',
        ),
        'discodes_id',
        'code',
        array(
            'name' => 'spot_type_name',
            'value' => '($data->spot_type)?$data->spot_type->name:""',
        ),
        array(
            'name' => 'user_id',
            'type' => 'raw',
            'value' => '($data->user)?$data->user->email:""',
        ),
        array(
            'name' => 'status',
            'type' => 'raw',
            'value' => '$data->getStatus()',
            'filter' => $model->getStatusList(),
        ),
        'url',
        array(
            'class' => 'CButtonColumn',
            'template' => '{view} {update}',
        ),
    ),
));
?>

<button id="activate_btn" type="button">Активировать</button><button id="activate_btn" type="button">Активировать</button>
<button id="delete_btn" type="button">Удалить</button>
<script type="text/javascript">
    $("#activate_btn, #delete_btn").click(function () {
        var url;
        var action = $(this).attr('id');
        var selected = $("#spot-grid").selGridView("getAllSelection");
        var id = selected.join("|");

        if (action === 'activate_btn') url = '/admin/spot/activate/';
        else if (action === 'delete_btn') url = '/admin/spot/delete/';

        if (id[0]) {
            $.ajax({
                url:url,
                dataType:"json",
                type:'GET',
                data:{id:id, ajax:1},
                success:function (data, textStatus) {
                    $().redirect('/admin/spot/');
                }
            });
        }
        return false;
    });
</script>
