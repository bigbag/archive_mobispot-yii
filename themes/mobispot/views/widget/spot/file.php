<form action="" method="post" class="spot_edit_content" id="spot_edit_content_<?php echo $content->spot_id?>">
    <?php echo CHtml::activeHiddenField($content, 'spot_id'); ?>
    <?php echo CHtml::activeHiddenField($content, 'spot_type_id'); ?>
<p><?php echo Yii::t('account', 'Загрузите в этот спот любой графический файл (pdf, jpg, png, gif), и пользователи,<br />
        отсканировавшие Ваш спот увидят его в браузере своего мобильного телефона.');?>

</p>
<?php echo CHtml::activeHiddenField($content, 'fayl_6', array('id' => 'spot_file_field_'.$data->discodes_id)); ?>

<div class="round-btn-upload">
    <input type="submit" id="add_file_<?php echo($data->discodes_id)?>" class="" value="<?php echo Yii::t('account', 'Загрузить');?>"/>
</div>


<script type="text/javascript">
    $(function () {
        $("#add_file_<?php echo($data->discodes_id)?>").uploadify({
            'width':'110',
            'height':'30',
            swf:'/themes/mobispot/js/uploadify.swf',
            uploader:'/user/uploadFile/',
            'formData':{'spot_id':<?php echo($data->discodes_id)?>},
            'removeTimeout':10,
            'multi':false,
            'buttonClass':'uploadify_file',
            'buttonText':'<?php echo Yii::t('profile', 'Загрузить');?>',

            'onUploadError':function (file, errorCode, errorMsg, errorString) {
                alert('The file ' + file.name + ' could not be uploaded: ' + errorString);
            },
            'onUploadSuccess':function (file, data, response) {
                var obj = jQuery.parseJSON(data);
                var file_name = obj.file;
                var error = obj.error;
                if (error) alert(error);
                if (file_name) {
                    $('#spot_file_field_<?php echo $data->discodes_id; ?>').val(file_name);
                }
            }
        });
    });
</script>
</form>