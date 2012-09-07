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
            <p><?php echo Yii::t('account', 'Загрузите в этот спот любой графический файл (pdf, jpg, png, gif), и пользователи,<br />
        отсканировавшие Ваш спот увидят его в браузере своего мобильного телефона.');?>

            </p>
            <?php echo CHtml::activeHiddenField($content, 'fayl_6', array('id' => 'spot_file_field_' . $data->discodes_id)); ?>
            <table>
                <tr>
                    <td>
                        <div class="round-btn-upload">
                            <input type="submit" id="add_file_<?php echo($data->discodes_id)?>" class=""
                                   value="<?php echo Yii::t('account', 'Загрузить');?>"/>
                        </div>
                    </td>
                    <td>
                        <div class="result_upload">
                            <?php if (!empty($content->fayl_6)): ?>
                            <?php $file_name = explode('_', $content->fayl_6) ?>
                            <?php echo $file_name[2]; ?><span class="cancel"></span>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            </table>


        </form>
    </div>
    <div class="clear"></div>
    <div>
        <script type="text/javascript">
            $('body').delegate('.result_upload span.cancel', 'click', function () {
                $('#spot_file_field_<?php echo $data->discodes_id; ?>').val('');
                $('.result_upload').empty();
            });

            $(function () {
                $("#add_file_<?php echo($data->discodes_id)?>").uploadifive({
                    'width':'110',
                    'height':'30',
                    'fileTypeExts':'*.pdf; *.gif; *.jpg; *.png',
                    uploadScript:'/user/uploadFile/',
                    'formData':{'spot_id':<?php echo($data->discodes_id)?>},
                    'fileSizeLimit':'10MB',
                    'multi':false,
                    'buttonClass':'uploadify_file',
                    'buttonText':'<?php echo Yii::t('profile', 'Загрузить');?>',

                    'onError':function (errorType) {
                        $('#messages_modal div.messages').html('The file could not be uploaded: ' + errorType);
                        $('#messages_modal').reveal({animation:'none'});
                    },
                    'onUploadComplete':function (file, data, response) {
                        var obj = jQuery.parseJSON(data);
                        var file_name = obj.file;
                        var error = obj.error;
                        if (error) alert(error);
                        if (file_name) {
                            $('#spot_file_field_<?php echo $data->discodes_id; ?>').val(file_name);
                            $('.result_upload').html(file.name + '<span class="cancel"></span>');
                        }
                    }
                });
            });
        </script>