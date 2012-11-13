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
                <?php echo Yii::t('account', 'Используйте этот спот, чтобы получить жалобу, вопрос или похвалу от
    Вашего клиента. <br />Отметьте ниже, какие поля ему нужно заполнить, а также
    поясните,<br /> зачем Вы собираете эту информацию.<br />');?>
            </p>
            <table class="feedbackInfoTbl" cellspacing="0">
                <tr>
                    <td colspan="2">
                        <div class="txt-form">
                            <div class="txt-form-cl">
                                <?php echo CHtml::activeTextField($content, 'poyasneniya_9',
                                array(
                                    'class' => 'txt',
                                    'placeholder' => Yii::t('account', 'Введите здесь поясняющий текст к Вашему споту'),
                                )); ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="field"><?php echo Yii::t('account', 'Имя');?></td>
                    <td><?php echo CHtml::activeCheckBox($content, 'imya_9', array('class' => 'niceCheck')); ?></td>
                </tr>
                <tr>
                    <td class="field"><?php echo Yii::t('account', 'Телефон');?></td>
                    <td><?php echo CHtml::activeCheckBox($content, 'telefon_9', array('class' => 'niceCheck')); ?></td>
                </tr>
                <tr>
                    <td class="field"><?php echo Yii::t('account', 'Электронная почта');?></td>
                    <td><?php echo CHtml::activeCheckBox($content, 'email_9', array('class' => 'niceCheck')); ?></td>
                </tr>
                <tr>
                    <td class="field"><?php echo Yii::t('account', 'Комментарий');?></td>
                    <td><?php echo CHtml::activeCheckBox($content, 'kommentariy_9', array('class' => 'niceCheck')); ?></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div id="feedback_content">
                            <a href="<?php echo $data->discodes_id;?>" class="btn-30">
                            <span
                                    class="btn-30-txt"><?php echo Yii::t('account', 'Смотреть отзывы к этому споту');?></span>
                            </a>
                        </div>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div class="clear"></div>
    <div>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#feedback_content').click(function () {
                    var id = $('#feedback_content a').attr("href");

                    if (id) {
                        $.ajax({
                            url:'/ajax/spotFeedbackContent',
                            type:'POST',
                            data:{discodes_id:id},
                            success:function (result) {
                                $('#spot_content_' + id).html(result);
                            }
                        });
                    }
                    return false;
                });
            });

            $('input.txt').bind('focus', function () {
                $(this).parent().css('background-position', '100% -105px');
                $(this).parent().parent().css('background-position', '0 -70px');
            });
            $('input.txt').bind('blur', function () {
                $(this).parent().css('background-position', '100% -35px');
                $(this).parent().parent().css('background-position', '0 0');
            });
        </script>