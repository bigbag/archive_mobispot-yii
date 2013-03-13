<?php $this->pageTitle = 'Комментарии'; ?>
<?php
$this->breadcrumbs = array(
    'Админка' => array('/admin/'),
    'Споты' => array('/admin/spot/'),
    'Комментарии' => array('/admin/spotComment'),
    'Управление'
);
?>

<h1>Управление комментариями</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'spot-comment-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        array(
            'name' => 'user_id',
            'type' => 'raw',
            'value' => '($data->user)?$data->user->email:""',
        ),
        array(
            'name' => 'spot_id',
            'type' => 'raw',
            'value' => '($data->spot)?$data->spot->name:""',
        ),
        array(
            'name' => 'creation_date',
            'type' => 'raw',
            'value' => 'Yii::app()->dateFormatter->format("dd.MM.yy hh:mm", $data->creation_date)',
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{view} {update}',
        ),
    ),
));
?>
