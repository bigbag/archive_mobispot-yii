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
                <div class="result_upload" id="result_<?php echo $data->discodes_id;?>">
                    <?php if (!empty($content->fayl_6)): ?>
                        <?php $file_name = explode('_', $content->fayl_6)?>
                        <?php echo $file_name[2];?><span class="cancel"></span>
                    <?php endif; ?>
                </div>
            </td>
        </tr>
    </table>

    <script type="text/javascript">
        $('body').delegate('#result_<?php echo $data->discodes_id; ?> span.cancel', 'click', function () {
            $('#spot_file_field_<?php echo $data->discodes_id; ?>').val('');
            $('#result_<?php echo $data->discodes_id; ?>').empty();
        });

        $(function () {
            $("#add_file_<?php echo($data->discodes_id)?>").uploadifive({
                'width':'110',
                'height':'30',
                'fileTypeExts':'*.pdf; *.gif; *.jpg; *.png',
                uploadScript:'/user/uploadFile/',
                'formData':{'spot_id':<?php echo($data->discodes_id)?>},
                'fileSizeLimit' : '10MB',
                'multi':false,
                'buttonClass':'uploadify_file',
                'buttonText':'<?php echo Yii::t('profile', 'Загрузить');?>',

                'onError':function (file, errorCode, errorMsg, errorString) {
                    $('#messages_modal div.messages').html('The file ' + file.name + ' could not be uploaded: ' + errorString);
                    $('#messages_modal').reveal({animation:'none'});
                },
                'onUploadComplete':function (file, data, response) {
                    var obj = jQuery.parseJSON(data);
                    var file_name = obj.file;
                    var error = obj.error;
                    if (error) alert(error);
                    if (file_name) {
                        $('#spot_file_field_<?php echo $data->discodes_id; ?>').val(file_name);
                        $('#result_<?php echo $data->discodes_id; ?>').html(file.name + '<span class="cancel"></span>');
                    }
                }
            });
        });
    </script>
</form>