<?php $this->pageTitle = 'Настройки'; ?>
<?php

$this->breadcrumbs = array(
    'Админка' => array('/admin/'),
    'Общие',
    'Настройки',
);

$this->menu = array(
    array('label' => 'Добавить', 'url' => array('create')),
);
?>

<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'settings-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'desc',
        'name',
        array(
            'name' => 'change_date',
            'type' => 'raw',
            'value' => 'Yii::app()->dateFormatter->format("dd.MM.yy hh:mm", $data->change_date)',
        ),
        array(
            'name' => 'user_id',
            'type' => 'raw',
            'value' => '($data->user)?$data->user->email:""',
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}',
        ),
    ),
));
?>
