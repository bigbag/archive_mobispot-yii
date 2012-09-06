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
                <div class="result">
                </div>
            </td>
        </tr>
    </table>
</form>

<script type="text/javascript">
    $(function () {
        var i = 1;

        $('body').delegate('.result_upload span.cancel', 'click', function () {
            var id = this.id;
            if (id){
                $('#spot_send_field' + id + '_<?php echo $data->discodes_id; ?>').val('');
                $('#file_' + id).empty();
            }
        });

        $("#add_file_<?php echo($data->discodes_id)?>").uploadifive({
            'width':'110',
            'height':'30',
            uploadScript:'/user/uploadFile/',
            'formData':{'spot_id':<?php echo($data->discodes_id)?>},
            'fileSizeLimit' : '10MB',
            'multi':true,
            'uploadLimit':5,
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
                    $('#spot_send_field' + i + '_<?php echo $data->discodes_id; ?>').val(file_name);
                    $('.result').prepend('<div class="result_upload" id="file_' + i + '">' + file.name + '<span class="cancel" id="' + i +'"></span></div>');
                    i = i + 1;
                }
            }
        });
    });
</script>