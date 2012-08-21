<?php $this->pageTitle = 'Споты'; ?>
<?php
$this->breadcrumbs = array(
    'Админка' => array('/admin/'),
    'Пользователи' => array('/admin/user/'),
    'Управление'
);
?>
<?php if (Yii::app()->user->hasFlash('user')): ?>
<div class="success">
    <?php echo Yii::app()->user->getFlash('user'); ?>
</div>
<?php endif; ?>

<?
$this->widget('ext.selgridview.SelGridView', array(
    'id' => 'гыук-grid',
    'dataProvider' => $model->search(),
    'selectableRows' => 2,
    'filter' => $model,
    'columns' => array(
        array(
            'class' => 'CCheckBoxColumn',
        ),
        'email',
        array(
            'name' => 'creation_date',
            'type' => 'raw',
            'value' => 'Yii::app()->dateFormatter->format("dd.MM.yy hh:mm", $data->creation_date)',
        ),
        array(
            'name' => 'lastvisit',
            'type' => 'raw',
            'value' => 'Yii::app()->dateFormatter->format("dd.MM.yy hh:mm", $data->lastvisit)',
        ),
        array(
            'class' => 'CButtonColumn',
           // 'template' => '{view} {update}',
        ),
    ),
));
?>
