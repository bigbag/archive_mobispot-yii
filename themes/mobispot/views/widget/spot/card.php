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
<table class="visitInfoTbl" cellspacing="0">
    <tbody>
    <tr>
        <td class="field"><?php echo Yii::t('account', 'Название бизнеса');?></td>
        <td>
            <div class="txt-form">
                <div class="txt-form-cl">
                    <?php echo CHtml::activeTextField($content, 'nazvanie-biznesa_8', array('class' => 'text')); ?>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td class="field"><?php echo Yii::t('account', 'Веб сайт');?></td>
        <td>
            <div class="txt-form">
                <div class="txt-form-cl">
                    <?php echo CHtml::activeTextField($content, 'sayt_8', array('class' => 'text')); ?>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td class="field"><?php echo Yii::t('account', 'Контактное лицо');?></td>
        <td>
            <div class="txt-form">
                <div class="txt-form-cl">
                    <?php echo CHtml::activeTextField($content, 'kontaktnoe-litso_8', array('class' => 'text')); ?>
                    <input class="txt" name="inputtext" value="" placeholder=" " type="text">
                </div>
            </div>
        </td>
    </tr>
    </tbody>
</table>
<div class="action">
    <br/>
    <br/>
    <table class="visitInfoTbl" cellspacing="0">
        <tbody>
        <tr>
            <td class="field vatop" rowspan="4"><?php echo Yii::t('account', 'Интересное предложение');?></td>
            <td>
                <div class="txt-form">
                    <div class="txt-form-cl">
                        <?php echo CHtml::activeTextField(
                        $content,
                        'aktsiya-nazvanie_8[]',
                        array(
                            'class' => 'text',
                            'placeholder' => Yii::t('account', 'Название'),
                        ));
                        ?>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <input value="" class="spot_card_field_1" name="SpotModel[kartinka_8][]" type="hidden">
                <table>
                    <tr>
                        <td>
                            <div class="round-btn-upload">
                                <input type="submit" class="add_file"
                                       value="<?php echo Yii::t('account', 'Загрузить');?>" id="1"/>
                            </div>
                        </td>
                        <td>
                            <div class="result_upload file_1">
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
                        <?php echo CHtml::activeTextField(
                        $content,
                        'aktsiya-ssyilka_8[]',
                        array(
                            'class' => 'text',
                            'placeholder' => Yii::t('account', 'Ссылка на веб-страницу'),
                        ));
                        ?>
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<div class="action">
    <br/>
    <br/>
    <table class="visitInfoTbl" cellspacing="0">
        <tbody>
        <tr>
            <td class="field vatop" rowspan="4"><?php echo Yii::t('account', 'Интересное предложение');?></td>
            <td>
                <div class="txt-form">
                    <div class="txt-form-cl">
                        <?php echo CHtml::activeTextField(
                        $content,
                        'aktsiya-nazvanie_8[]',
                        array(
                            'class' => 'text',
                            'placeholder' => Yii::t('account', 'Название'),
                        ));
                        ?>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <input value="" class="spot_card_field_2" name="SpotModel[kartinka_8][]" type="hidden">
                <table>
                    <tr>
                        <td>
                            <div class="round-btn-upload">
                                <input type="submit" class="add_file"
                                       value="<?php echo Yii::t('account', 'Загрузить');?>" id="2"/>
                            </div>
                        </td>
                        <td>
                            <div class="result_upload file_2">

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
                        <?php echo CHtml::activeTextField(
                        $content,
                        'aktsiya-ssyilka_8[]',
                        array(
                            'class' => 'text',
                            'placeholder' => Yii::t('account', 'Ссылка на веб-страницу'),
                        ));
                        ?>
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<table class="visitInfoTbl" cellspacing="0">
    <tbody>
    <tr>
        <td>
            <a href="1" class="r-btn-30 copy" id="copy_action" rel=".action">
                <span><?php echo Yii::t('account', 'Добавить предложение');?></span>
            </a>
        </td>
    </tr>
    </tbody>
</table>

<div class="place">
    <br/>
    <br/>
    <table class="visitInfoTbl" cellspacing="0">
        <tbody>
        <tr>
            <td class="field vatop" rowspan="3"><?php echo Yii::t('account', 'Ближайшие точки продаж');?></td>
            <td>
                <div class="txt-form">
                    <div class="txt-form-cl">
                        <?php echo CHtml::activeTextField(
                        $content,
                        'tochka-nazvanie_8[]',
                        array(
                            'class' => 'text',
                            'placeholder' => Yii::t('account', 'Название и адрес'),
                        ));
                        ?>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="txt-form">
                    <div class="txt-form-cl">
                        <?php echo CHtml::activeTextField(
                        $content,
                        'tochka-karta_8[]',
                        array(
                            'class' => 'text',
                            'placeholder' => Yii::t('account', 'Ссылка на карту'),
                        ));
                        ?>
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<table class="visitInfoTbl" cellspacing="0">
    <tbody>
    <tr>
        <td>
            <a href="" class="r-btn-30 copy" rel=".place">
                <span><?php echo Yii::t('account', 'Добавить точку продаж');?></span>
            </a>
        </td>
    </tr>
    </tbody>
</table>
</form>
</div>
<div class="clear"></div>
<div>
    <script type="text/javascript">
        $(function () {
            $('body').delegate('.result_upload span.cancel', 'click', function () {
                var id = $(this).attr('key');
                if(id){
                    $('.file_' + id).empty();
                    $('.spot_card_field_' + id).val('');


                }

            });
            return false;
        });

        jQuery(".round-btn-upload .add_file").each(function () {
            jQuery(this).uploadifive({
                'width':'110',
                'height':'30',
                'fileTypeExts':'*.gif; *.jpg; *.png',
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
                        var id = $(this).attr('id');
                        if (id) {
                            $('.spot_card_field_' + id).val(file_name);
                            $('.file_' + id).html(file.name + '<span class="cancel" key=' + id +'></span>');
                        }

                    }
                }
            });
        });
    </script>