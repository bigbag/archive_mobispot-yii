<div class="contSpot" id="spot_content_<?php echo $data->discodes_id;?>">
    <span class="message" id="message_<?php echo $data->discodes_id;?>"></span>

    <div class="btn-30">
        <div><input type="submit" class="" value="<?php echo Yii::t('account', 'Сохранить');?>"
                    form="spot_edit_content_<?php echo $data->discodes_id;?>"/></div>
    </div>
    <a href="#" class="btn-30">
        <span class="preview-ico ico"></span>
        <span class="btn-30-txt"><?php echo Yii::t('account', 'Предпросмотр');?></span>
    </a>

    <div class="oneSpotInfo">
        <form action="" method="post" class="spot_edit_content" id="spot_edit_content_<?php echo $content->spot_id?>">
            <?php echo CHtml::activeHiddenField($content, 'spot_id'); ?>
            <?php echo CHtml::activeHiddenField($content, 'spot_type_id'); ?>
            <p>
                <?php echo Yii::t('account', ' Разместите здесь ссылку на веб-страницу,<br/>которую Вы хотите показать
    кому-нибудь при помощи своего спота');?><br/>
            </p>
            <table class="urlInfoTbl" cellspacing="0">
                <tr>
                    <td class="field"><?php echo Yii::t('account', 'Название ссылки');?></td>
                    <td>
                        <div class="txt-form">
                            <div class="txt-form-cl">
                                <?php echo CHtml::activeTextField($content, 'nazvanie_5', array('class' => 'txt')); ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="field"><?php echo Yii::t('account', 'Веб адрес');?></td>
                    <td>
                        <div class="txt-form">
                            <div class="txt-form-cl">
                                <?php echo CHtml::activeTextField($content, 'adres_5', array('class' => 'txt')); ?>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div class="clear"></div>
    <div>

        <script type="text/javascript">
            $('input.txt').bind('focus', function () {
                $(this).parent().css('background-position', '100% -105px');
                $(this).parent().parent().css('background-position', '0 -70px');
            });
            $('input.txt').bind('blur', function () {
                $(this).parent().css('background-position', '100% -35px');
                $(this).parent().parent().css('background-position', '0 0');
            });
        </script>