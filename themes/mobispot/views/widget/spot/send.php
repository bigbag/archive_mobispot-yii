<p>
    <?php echo Yii::t('account', 'Отправьте важные файлы тому, кто просканирует Ваш спот.<br /> Ему будет
    достаточно ввести свой адрес элетронной почты, и он их незамедлительно получит.<br />
    Загрузите до 5 разных файлов (общий размер - до 10 Мб), и они будут отправлены тому, кто об этом попросит.<br />');?>
</p>
<input type="hidden" class="file_count" value="<?php echo count($content->fayl_10);?>">
<input name="SpotModel[fayl_10][]" type="hidden" value="">
    <?php if (!empty($content->fayl_10)): ?>
        <?php foreach ($content->fayl_10 as $file): ?>
            <?php if (!empty($file)): ?>
                <div class="result_upload">
                    <input name="SpotModel[fayl_10][]" type="hidden" value="<?php echo $file ?>">
                    <?php $file_name = explode('_', $file) ?>
                    <?php $file_name = (isset($file_name[2])) ? $file_name[2] : '' ?>
                    <?php echo $file_name; ?>
                    <span class="cancel"></span>

                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif;?>
    <span class="view_file"></span>

<div class="send">
    <button class="m-button">
        <i class="icon-upload"></i>&nbsp;<?php echo Yii::t('account', 'Загрузить');?>
    </button>
</div>

<script type="text/javascript">
            $(document).ready(function () {
                var count = $('.file_count').val();
                if (count > 5) $('.round-btn-upload').hide();
                return false;

            });

            $(function () {
                $('.result_upload span.cancel').live("click", function () {
                    $(this).parent().remove();
                    var count = $('.file_count').val();
                    if (count) {
                        $('.file_count').val(count - 1);
                        if (count == 5) $('.round-btn-upload').show();
                    }
                });
                return false;
            });

            $(function () {
                var count = <?php echo count($content->fayl_10);?>;
                if (count == 6) $('.round-btn-upload').hide();
                count = count + 1;

                $("#add_file").uploadifive({
                    'width':'120px',
                    'height':'30px',
                    uploadScript:'/user/uploadFile/',
                    'formData':{'spot_id':<?php echo($data->discodes_id)?>},
                    'fileSizeLimit':'10MB',
                    'multi':false,
                    'uploadLimit':5,
                    'buttonClass':'m-button',
                    'buttonText':'<i class="icon-upload"></i>&nbsp;<?php echo Yii::t('profile', 'Загрузить');?>',

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
                            if (count == 6) $('.round-btn-upload').hide();
                            var txt = '';
                            txt += '<div class="result_upload">';
                            txt += '<input name="SpotModel[fayl_10][]" type="hidden" value="' + file_name + '">';
                            txt += file.name;
                            txt += '<span class="cancel"></span></div>';
                            $('.view_file').before(txt);
                        }
                    }
                });
            });
        </script>