<table class="visitInfoTbl" cellspacing="0">
<tbody>
<tr>
<td class="field vatop" rowspan="4"><?php echo Yii::t('account', 'Добавить предложение');?></td>
<td>
<div class="txt-form">
<div class="txt-form-cl">
<input class="text name" placeholder="<?php echo Yii::t('account', 'Название');?>" type="text"
value="<?php echo $data['name']?>">
</div>
</div>
</td>
</tr>
<tr>
<td>
<input class="spot_card_file" type="hidden" value="<?php echo $data['file']?>">
<input class="spot_card_file_view" type="hidden" value="<?php echo $data['file_view']?>">
<table>
<tr>
<td>
<div class="round-btn-upload">
<input type="submit" class="add_file"
value="<?php echo Yii::t('account', 'Загрузить'); ?>"/>
</div>
</td>
<td>
<div class="result_upload">
<?php if (isset($data['file_view'][1])): ?>
<?php echo $data['file_view'] ?><span class="cancel"></span>
<?php endif;?>
</div>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td>
<div class="txt-form">
<div class="txt-form-cl">
<input class="text link" placeholder="<?php echo Yii::t('account', 'Ссылка на веб-страницу');?>"
type="text" value="<?php echo $data['link']?>">
</div>
</div>
</td>
</tr>
<tr>
<td>
<div>
<a class="r-btn-30" id="save_action">
<span><?php echo Yii::t('account', 'Сохранить');?></span>
</a>
<a class="r-btn-30" id="remove_action">
<span><?php echo Yii::t('account', 'Удалить');?></span>
</a>
</div>
</td>
</tr>
</tbody>
</table>

<script type="text/javascript">
$(function () {
    $('body').delegate('.result_upload span.cancel', 'click', function () {
        $('.result_upload').empty();
        $('.spot_card_file').val('');
        $('.spot_card_file_view').val('');
    });
    return false;
});

jQuery(".add_file").each(function () {
    jQuery(this).uploadifive({
        'width':'120px',
        'height':'30px',
        'fileTypeExts':'*.gif; *.jpg; *.png',
        uploadScript:'/user/uploadFile/',
        'formData':{'spot_id':<?php echo $discodes_id;?>},
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
            $('.spot_card_file').val(file_name);
            $('.spot_card_file_view').val(file.name);
            $('.result_upload').html(file.name + '<span class="cancel"></span>');
          }
        }
    });
});
</script>