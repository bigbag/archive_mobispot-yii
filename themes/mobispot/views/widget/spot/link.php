<form action="" method="post" class="spot_edit_content" id="spot_edit_content_<?php echo $content->spot_id?>">
    <?php echo CHtml::activeHiddenField($content, 'spot_id'); ?>
    <?php echo CHtml::activeHiddenField($content, 'spot_type_id'); ?>
    <p>
        <?php echo Yii::t('account', ' Разместите здесь ссылку на веб-страницу,<br/>которую Вы хотите показать
    кому-нибудь при помощи своего спота<br/>');?>
    </p>
    <table class="urlInfoTbl" cellspacing="0">
        <tr>
            <td class="field"><?php echo Yii::t('account', 'Название ссылки');?></td>
            <td>
                <div class="txt-form">
                    <div class="txt-form-cl">
                        <?php echo CHtml::activeTextField($content, 'nazvanie_5', array('class' => 'text')); ?>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td class="field"><?php echo Yii::t('account', 'Веб адрес');?></td>
            <td>
                <div class="txt-form">
                    <div class="txt-form-cl">
                        <?php echo CHtml::activeTextField($content, 'adres_5', array('class' => 'text')); ?>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</form>