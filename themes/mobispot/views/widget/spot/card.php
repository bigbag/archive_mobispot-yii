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
                    <?php echo CHtml::activeHiddenField($content, 'aktsiya-kartinka_8', array('id' => 'spot_card_field_' . $data->discodes_id)); ?>
                    <div class="round-btn-upload">
                        <input type="submit" id="add_file_<?php echo($data->discodes_id)?>" class=""
                               value="<?php echo Yii::t('account', 'Загрузить');?>"/>
                    </div>
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
            <td><a href="" class="r-btn-30 copy"
                   rel=".action"><span><?php echo Yii::t('account', 'Добавить предложение');?></span></a>
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
            $('a.copy').relCopy();
        });


        $('body').delegate('.result_upload span.cancel', 'click', function () {
            $('#spot_card_field_<?php echo $data->discodes_id; ?>').val('');
            $('.result_upload').empty();
        });

        $(function () {
            $("#add_file_<?php echo($data->discodes_id)?>").uploadifive({
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
                        $('#spot_file_field_<?php echo $data->discodes_id; ?>').val(file_name);
                        $('.result_upload').html(file.name + '<span class="cancel"></span>');
                    }
                }
            });
        });
    </script>