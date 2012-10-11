<form action="" method="post" class="spot-edit-content" id="spot_edit_content_<?php echo $content->spot_id?>">
    <?php echo CHtml::activeHiddenField($content, 'spot_id'); ?>
    <?php echo CHtml::activeHiddenField($content, 'spot_type_id'); ?>
    <p>
        <?php echo Yii::t('account', ' Разместите здесь ссылку на веб-страницу,<br/>которую Вы хотите показать
    кому-нибудь при помощи своего спота');?>
    </p>
    <div class="row">
        <div class="two mobile-one columns">
            <label class="left inline"><?php echo Yii::t('account', 'Название ссылки');?></label>
        </div>
        <div class="ten mobile-three columns">
            <?php echo CHtml::activeTextField($content, 'nazvanie_5', array('class' => 'five')); ?>
        </div>
    </div>
    <div class="row">
        <div class="two mobile-one columns">
            <label class="left inline"><?php echo Yii::t('account', 'Веб адрес');?></label>
        </div>
        <div class="ten mobile-three columns">
            <?php echo CHtml::activeTextField($content, 'adres_5', array('class' => 'five')); ?>
        </div>
    </div>
</form>
