<?php $this->pageTitle='Споты'; ?>
<?php
$this->breadcrumbs=array(
    'Админка'=>array('/admin/'),
    'Споты'=>array('/admin/spot/'),
    $model->discodes_id,
);
$menu=array();

if ($model->status == Spot::STATUS_GENERATED) {
  array_push($menu, array('label'=>'Активировать спот', 'url'=>array('activate', 'id'=>$model->discodes_id)));
}

array_push($menu, array('label'=>'Редактировать спот', 'url'=>array('update', 'id'=>$model->discodes_id)));

if ($model->status == Spot::STATUS_ACTIVATED or $model->status == Spot::STATUS_GENERATED) {
  array_push($menu, array('label'=>'Удалить спот', 'url'=>'#', 'linkOptions'=>array(
          'submit'=>array('delete', 'id'=>$model->discodes_id),
          'confirm'=>'Вы уверены что хотите удалить спот ID '.$model->discodes_id.'?')));
}

$this->menu=$menu;
?>

<h1>Информация о споте <?php echo $model->discodes_id; ?></h1>

<?php if (Yii::app()->user->hasFlash('spot')): ?>
  <div class="success">
    <?php echo Yii::app()->user->getFlash('spot'); ?>
  </div>
<?php endif; ?>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'name',
        'url',
        'discodes_id',
        array(
            'name'=>'spot_type_id',
            'type'=>'raw',
            'value'=>($model->spot_type) ? $model->spot_type->name : "",
        ),
        array(
            'name'=>'user_id',
            'type'=>'raw',
            'value'=>($model->user) ? $model->user->email : "",
        ),
        array(
            'name'=>'premium',
            'type'=>'raw',
            'value'=>$model->getPremium(),
        ),
        array(
            'name'=>'status',
            'type'=>'raw',
            'value'=>$model->getStatus(),
        ),
        array(
            'name'=>'generated_date',
            'type'=>'raw',
            'value'=>Yii::app()->dateFormatter->format("dd.MM.yy hh:mm", $model->generated_date),
        ),
        array(
            'name'=>'registered_date',
            'type'=>'raw',
            'value'=>Yii::app()->dateFormatter->format("dd.MM.yy hh:mm", $model->registered_date),
        ),
        array(
            'name'=>'removed_date',
            'type'=>'raw',
            'value'=>Yii::app()->dateFormatter->format("dd.MM.yy hh:mm", $model->removed_date),
        ),
    ),
));
?>
