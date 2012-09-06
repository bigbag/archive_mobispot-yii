<form action="" method="post" class="spot_edit_content" id="spot_edit_content_<?php echo $content->spot_id?>">
    <?php echo CHtml::activeHiddenField($content, 'spot_id'); ?>
    <?php echo CHtml::activeHiddenField($content, 'spot_type_id'); ?>
    <p><?php echo Yii::t('account', 'Отправьте важные файлы тому, кто просканирует Ваш спот. Ему будет <br />
    достаточно ввести свой адрес элетронной почты, и он их незамедлительно получит.<br />
    Загрузите до 5 разных файлов (общий размер - до 10 Мб), и они будут отправлены тому, кто об этом попросит.<br />');?>
    </p>
    <?php echo CHtml::activeHiddenField($content, 'fayl-1_10', array('id' => 'spot_send_field1_' . $data->discodes_id)); ?>
    <?php echo CHtml::activeHiddenField($content, 'fayl-2_10', array('id' => 'spot_send_field2_' . $data->discodes_id)); ?>
    <?php echo CHtml::activeHiddenField($content, 'fayl-3_10', array('id' => 'spot_send_field3_' . $data->discodes_id)); ?>
    <?php echo CHtml::activeHiddenField($content, 'fayl-4_10', array('id' => 'spot_send_field4_' . $data->discodes_id)); ?>
    <?php echo CHtml::activeHiddenField($content, 'fayl-5_10', array('id' => 'spot_send_field5_' . $data->discodes_id)); ?>

    <table>
        <tr>
            <td>
                <div class="round-btn-upload">
                    <input type="submit" id="add_file_<?php echo($data->discodes_id)?>" class=""
                           value="<?php echo Yii::t('account', 'Загрузить');?>"/>
                </div>
            </td>
            <td>
                <div class="result_upload" id="result_<?php echo $data->discodes_id;?>"></div>
            </td>
        </tr>
    </table>
</form>

<script type="text/javascript">
    $(function () {
        var i = 1;
        $("#add_file_<?php echo($data->discodes_id)?>").uploadify({
            'width':'110',
            'height':'30',
            swf:'/themes/mobispot/js/uploadify.swf',
            uploader:'/user/uploadFile/',
            'formData':{'spot_id':<?php echo($data->discodes_id)?>},
            'fileSizeLimit' : '10MB',
            'multi':true,
            'uploadLimit':5,
            'buttonClass':'uploadify_file',
            'buttonText':'<?php echo Yii::t('profile', 'Загрузить');?>',

            'onUploadError':function (file, errorCode, errorMsg, errorString) {
                $('#messages_modal div.messages').html('The file ' + file.name + ' could not be uploaded: ' + errorString);
                $('#messages_modal').reveal({animation:'none'});
            },
            'onUploadSuccess':function (file, data, response) {
                var obj = jQuery.parseJSON(data);
                var file_name = obj.file;
                var error = obj.error;
                if (error) alert(error);
                if (file_name) {
                    $('#spot_send_field' + i + '_<?php echo $data->discodes_id; ?>').val(file_name);
                    $('#result_<?php echo $data->discodes_id; ?>').html(file.name + '<span class="cancel"></div>');
                    i = i + 1;
                }
            }
        });
    });
</script>