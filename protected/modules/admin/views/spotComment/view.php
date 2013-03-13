<?php $this->pageTitle = 'Комментарии'; ?>
<?php
$this->breadcrumbs = array(
    'Админка' => array('/admin/'),
    'Споты' => array('/admin/spot/'),
    'Комментарии' => array('/admin/spotComment'),
    'Управление'
);

$this->menu = array(
    array('label' => 'Удалить комментарий', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Вы уверены что хотите удалить этот комментарий?')),
);
?>

<h1>Комментарий №<?php echo $model->id; ?> к споту <?php echo $model->spot->name; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'name' => 'user_id',
            'type' => 'raw',
            'value' => ($model->user) ? $model->user->email : "",
        ),
        array(
            'name' => 'spot_id',
            'type' => 'raw',
            'value' => ($model->spot) ? $model->spot->name : "",
        ),
        'body',
        array(
            'name' => 'generated_date',
            'type' => 'raw',
            'value' => Yii::app()->dateFormatter->format("dd.MM.yy hh:mm", $model->creation_date),
        ),
    ),
));
?>
