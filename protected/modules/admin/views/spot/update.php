<?php $this->pageTitle = 'Споты'; ?>
<?php
$this->breadcrumbs = array(
    'Админка' => array('/admin/'),
    'Споты' => array('/admin/spot/'),
    'Редактировать',
    $model->discodes_id,
);

$menu = array();

if ($model->status == Spot::STATUS_GENERATED) {
    array_push($menu, array('label' => 'Активировать спот', 'url' => array('activate', 'id' => $model->id)));
}

if (!$model->nfc) {
    array_push($menu, array('label' => 'Сгенерировать NFC', 'url' => array('nfc', 'id' => $model->id)));
}

if ($model->status == Spot::STATUS_ACTIVATED or $model->status == Spot::STATUS_GENERATED) {
    array_push($menu, array('label' => 'Удалить спот', 'url' => '#', 'linkOptions' => array(
        'submit' => array('delete', 'id' => $model->id),
        'confirm' => 'Вы уверены что хотите удалить спот ID ' . $model->discodes_id . '?')));
}

$this->menu = $menu;
?>

<h1>Редактировать спот ID <?php echo $model->discodes_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>