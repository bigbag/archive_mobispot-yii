<?php $this->pageTitle = 'Пользователи'; ?>
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
    'id' => 'user-grid',
    'dataProvider' => $model->search(),
    'selectableRows' => 2,
    'filter' => $model,
    'afterAjaxUpdate'=>"function(){jQuery('#creation_date_search').datepicker({'dateFormat': 'yy-mm-dd'})}",
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
            'name' => 'type',
            'type' => 'raw',
            'value' => '$data->getType()',
            'filter' => $model->getTypeList(),
        ),
        array(
            'name' => 'status',
            'type' => 'raw',
            'value' => '$data->getStatus()',
            'filter' => $model->getStatusList(),
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{update} {delete}',
        ),
    ),
));
?>

<button id="activate_btn" type="button">Активировать</button>
<button id="banned_btn" type="button">Заблокировать</button>
<script type="text/javascript">
    $("#activate_btn, #banned_btn").click(function () {

        var url;
        var action = $(this).attr('id');
        var selected = $("#user-grid").selGridView("getAllSelection");
        var id = selected.join("|");

        if (action === 'activate_btn') url = '/admin/user/activate/';
        else if (action === 'banned_btn') url = '/admin/user/banned/';

        if (id[0]) {
            $.ajax({
                url:url,
                dataType:"json",
                type:'GET',
                data:{id:id, ajax:1},
                success:function (data, textStatus) {
                    $().redirect('/admin/user/');
                }
            });
        }
        return false;
    });
</script>
