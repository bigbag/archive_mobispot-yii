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
            <p><?php echo Yii::t('account', 'Отправьте важные файлы тому, кто просканирует Ваш спот. Ему будет <br />
    достаточно ввести свой адрес элетронной почты, и он их незамедлительно получит.<br />
    Загрузите до 5 разных файлов (общий размер - до 10 Мб), и они будут отправлены тому, кто об этом попросит.<br />');?>
            </p>
            <table>
                <tr>
                    <td>
                        <input type="hidden" class="file_count" value="<?php echo count($content->fayl_10);?>">
                        <div class="round-btn-upload">
                            <input type="submit" id="add_file" class=""
                                   value="<?php echo Yii::t('account', 'Загрузить');?>"/>
                        </div>
                    </td>
                    <td>
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
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div class="clear"></div>
    <div>

        <script type="text/javascript">
            $(document).ready(function () {
                var count = $('.file_count').val();
                if (count > 4) $('.round-btn-upload').hide();

            });

            $(function () {
                $('.result_upload span.cancel').live("click", function () {
                    $(this).parent().remove();
                    var count = $('.file_count').val();
                    if (count){
                        $('.file_count').val(count - 1);
                        if (count == 5) $('.round-btn-upload').show();
                    }
                });
                return false;
            });

            $(function () {
                var count = $('.file_count').val();
                if (count == 5) $('.round-btn-upload').hide();

                $("#add_file").uploadifive({
                    'width':'110',
                    'height':'30',
                    uploadScript:'/user/uploadFile/',
                    'formData':{'spot_id':<?php echo($data->discodes_id)?>},
                    'fileSizeLimit':'10MB',
                    'multi':false,
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
