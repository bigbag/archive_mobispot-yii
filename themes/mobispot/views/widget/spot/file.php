<p>
<?php echo Yii::t('account', 'Загрузите в этот спот любой графический файл (pdf, jpg, png, gif), и пользователи,<br />
отсканировавшие Ваш спот увидят его в браузере своего мобильного телефона.');?>
</p>
<?php echo CHtml::activeHiddenField($content, 'fayl_6', array('id'=>'spot_file_field')); ?>
<div class="send">
<button class="m-button add_file">
<i class="icon-upload"></i>&nbsp;<?php echo Yii::t('account', 'Загрузить');?>
</button>
</div>

<div class="result_upload">
<?php if (!empty($content->fayl_6)): ?>
<?php $file_name=explode('_', $content->fayl_6) ?>
<?php echo $file_name[2]; ?><span class="cancel"></span>
<?php endif; ?>
</div>

<script type="text/javascript">

$(function () {
    $('body').delegate('.result_upload span.cancel', 'click', function () {
        $('#spot_file_field_<?php echo $data->discodes_id; ?>').val('');
        $('.result_upload').empty();
    });
    return false;
});

$(function () {
    $(".add_file").uploadifive({
        'width':'120px',
        'height':'30px',
        'fileTypeExts':'*.pdf; *.gif; *.jpg; *.png',
        uploadScript:'/user/uploadFile/',
        'formData':{'spot_id':<?php echo($data->discodes_id)?>},
        'fileSizeLimit':'10MB',
        'multi':false,
        'buttonClass':'m-button',
        'buttonText':'<i class="icon-upload"></i>&nbsp;<?php echo Yii::t('profile', 'Загрузить');?>',
        
        'onError':function (errorType) {
          $('#messages_modal div.messages').html('The file could not be uploaded: ' + errorType);
          $('#messages_modal').reveal({animation:'none'});
        },
        'onUploadComplete':function (file, data, response) {
          var obj=jQuery.parseJSON(data);
          var file_name=obj.file;
          var error=obj.error;
          if (error) alert(error);
          if (file_name) {
            $('#spot_file_field').val(file_name);
            $('.result_upload').html(file.name + '<span class="cancel"></span>');
          }
        }
    });
    return false;
});
</script>