<?php $this->pageTitle = 'Споты'; ?>
<?php
$this->breadcrumbs = array(
    'Админка' => array('/admin/'),
    'Споты' => array('/admin/spot/'),
    $model->discodes_id,
);
$menu = array();

if ($model->status == Spot::STATUS_GENERATED) {
    array_push($menu, array('label' => 'Активировать спот', 'url' => array('activate', 'id' => $model->id)));
}

if (!$model->nfc) {
    array_push($menu, array('label' => 'Сгенерировать NFC', 'url' => array('nfc', 'id' => $model->id)));
}

array_push($menu, array('label' => 'Редактировать спот', 'url' => array('update', 'id' => $model->id)));

if ($model->status == Spot::STATUS_ACTIVATED or $model->status == Spot::STATUS_GENERATED) {
    array_push($menu, array('label' => 'Удалить спот', 'url' => '#', 'linkOptions' => array(
        'submit' => array('delete', 'id' => $model->id),
        'confirm' => 'Вы уверены что хотите удалить спот ID ' . $model->discodes_id . '?')));
}

$this->menu = $menu;
?>

<h1>Информация о споте <?php echo $model->discodes_id; ?></h1>

<?php if (Yii::app()->user->hasFlash('spot')): ?>
<div class="success">
    <?php echo Yii::app()->user->getFlash('spot'); ?>
</div>
<?php endif;?>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'name',
        'discodes_id',
        array(
            'name' => 'spot_type_id',
            'type' => 'raw',
            'value' => ($model->spot_type) ? $model->spot_type->name : "",
        ),
        array(
            'name' => 'user_id',
            'type' => 'raw',
            'value' => ($model->user) ? $model->user->email : "",
        ),
        array(
            'name' => 'spot_hard_type_id',
            'type' => 'raw',
            'value' => ($model->spot_hard_type) ? $model->spot_hard_type->name : "",
        ),
        'spot_hard',
        'nfc',
        array(
            'name' => 'premium',
            'type' => 'raw',
            'value' => $model->getPremium(),
        ),
        array(
            'name' => 'type',
            'type' => 'raw',
            'value' => $model->getType(),
        ),
        array(
            'name' => 'status',
            'type' => 'raw',
            'value' => $model->getStatus(),
        ),
        array(
            'name' => 'generated_date',
            'type' => 'raw',
            'value' => Yii::app()->dateFormatter->format("dd.MM.yy hh:mm", $model->generated_date),
        ),
        array(
            'name' => 'registered_date',
            'type' => 'raw',
            'value' => Yii::app()->dateFormatter->format("dd.MM.yy hh:mm", $model->registered_date),
        ),
        array(
            'name' => 'removed_date',
            'type' => 'raw',
            'value' => Yii::app()->dateFormatter->format("dd.MM.yy hh:mm", $model->removed_date),
        ),
    ),
)); ?>
