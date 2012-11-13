<?php $photo_gallery = UserPersonalPhoto::getPhoto(Yii::app()->user->id)?>
<?php $select_field = UserPersonalField::getField($data->discodes_id); ?>

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
    <span class="view_gallery"></span>
    <form action="" method="post" class="spot_edit_content" id="spot_edit_content_<?php echo $content->spot_id?>">
        <?php echo CHtml::activeHiddenField($content, 'spot_id'); ?>
        <?php echo CHtml::activeHiddenField($content, 'spot_type_id'); ?>
        <div class="yourPhoto">
            <?php echo CHtml::activeHiddenField($content, 'fotografiya_3', array('id' => 'personal_photo')); ?>
            <div class="photo-cont">
                <?php if (!empty($content->fotografiya_3)): ?>
                <img width="130" src="/uploads/spot/<?php echo $content->fotografiya_3?>" alt="personal"/>
                <?php else: ?>
                <?php $profile = UserProfile::model()->findByPk($content->user_id)?>
                <?php if ($profile->use_photo == 1 and (!empty($profile->photo))):?>
                    <img width="130" src="/uploads/images/<?php echo $profile->photo?>" alt="personal"/>
                <?php else:?>
                    <img width="130" src="/themes/mobispot/images/personal_no_photo.jpg" alt="personal"/>
                <?php endif;?>

                <?php endif;?>
                <noscript>
                    <p>Please enable JavaScript to use file uploader.</p>
                </noscript>
            </div>
            <div class="round-btn-new" style="text-align: center">
                <input type="submit" id="add_photo"
                       value="<?php echo Yii::t('profile', 'Загрузить');?>"/>
                <div class="get_gallery" style="<?php echo (count($photo_gallery) > 0)?'':'display: none;';?>">
                    <a id="get_gallery" class="link"><?php echo Yii::t('account', 'Показать все');?></a>
                </div>
            </div>
        </div>
        <div class="yourName">
            <div class="txt-form">
                <div class="txt-form-cl">
                    <?php echo CHtml::activeTextField($content, 'imya_3', array('placeholder' => 'Your Name', 'class' => 'txt')); ?>
                </div>
            </div>
        </div>
        <div class="oneBlockSpotInfo">
            <div class="top-border ">
                <?php echo Yii::t('account', 'Контактные данные');?>
                <?php foreach (SpotPersonalField::getPersonalField(0) as $row): ?>
                <?php if (in_array($row['id'], $select_field)): ?>
                    <div class="txt-form">
                        <div class="txt-form-cl">
                            <span><img src="/uploads/ico/<?php echo $row['ico']?>" alt="" width="23"
                                       height="23"> </span>
                            <?php echo CHtml::activeTextField(
                            $content,
                            'kontaktyi_3[' . $row['id'] . ']',
                            array(
                                'placeholder' => $row['placeholder'],
                                'class' => 'txt',
                                'maxlength' => 60,
                            )); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endforeach;?>
                <div class="add_field">
                    <a href="0" class="r-btn-30">
                        <span><?php echo Yii::t('account', 'Добавить');?></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="oneBlockSpotInfo">
            <div class="top-border ">
                <?php echo Yii::t('account', 'Социальные сети');?>
                <?php foreach (SpotPersonalField::getPersonalField(1) as $row): ?>
                <?php if (in_array($row['id'], $select_field)): ?>
                    <div class="txt-form">
                        <div class="txt-form-cl">
                            <span><img src="/uploads/ico/<?php echo $row['ico']?>" alt="" width="23"
                                       height="23"> </span>
                            <?php echo CHtml::activeTextField(
                            $content,
                            'sotsseti_3[' . $row['id'] . ']',
                            array(
                                'placeholder' => $row['placeholder'],
                                'class' => 'txt',
                                'maxlength' => 60,
                            )); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endforeach;?>
                <div class="add_field">
                    <a href="1" class="r-btn-30">
                        <span><?php echo Yii::t('account', 'Добавить');?></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="oneBlockSpotInfo" style="width:431px;margin:0">
            <div class="top-border ">
                <table class="oneBlockSpotInfoTbl" cellspacing="0">
                    <?php foreach (SpotPersonalField::getPersonalField(2) as $row): ?>
                    <?php if (in_array($row['id'], $select_field)): ?>
                        <tr>
                            <td class="field"><?php echo Yii::t('account', $row['name']);?></td>
                            <td>
                                <div class="txt-form">
                                    <div class="txt-form-cl">
                                        <?php echo CHtml::activeTextField(
                                        $content,
                                        'opisanie_3[' . $row['id'] . ']',
                                        array(
                                            'placeholder' => $row['placeholder'],
                                            'class' => 'txt',
                                            'maxlength' => 150,
                                        )); ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    <?php endforeach;?>
                </table>

                <div class="add_field">
                    <a href="2" class="r-btn-30">
                        <span><?php echo Yii::t('account', 'Добавить');?></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="oneBlockSpotInfo">
            <div class="top-border ">
                <table class="oneBlockSpotInfoTbl">
                    <tr>
                        <td><?php echo Yii::t('account', 'Разрешить комментарии к споту');?></td>
                        <td>
                            <input type="hidden" name="SpotModel[razreshit-kommentarii_3]" value=""
                                   checked="checked">
                            <?php if (isset($content['razreshit-kommentarii_3'][0])): ?>
                            <input type="checkbox" name="SpotModel[razreshit-kommentarii_3]" value="1"
                                   class="niceCheck" checked="checked">
                            <?php else: ?>
                            <input type="checkbox" name="SpotModel[razreshit-kommentarii_3]" value="1"
                                   class="niceCheck">
                            <?php endif;?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo Yii::t('account', 'Разрешить скачивать визитку');?></td>
                        <td>
                            <input type="hidden" name="SpotModel[razreshit-skachivat-vizitku_3]" value=""
                                   checked="checked">
                            <?php if (isset($content['razreshit-skachivat-vizitku_3'][0])): ?>
                            <input type="checkbox" name="SpotModel[razreshit-skachivat-vizitku_3]" value="1"
                                   class="niceCheck" checked="checked">
                            <?php else: ?>
                            <input type="checkbox" name="SpotModel[razreshit-skachivat-vizitku_3]" value="1"
                                   class="niceCheck">
                            <?php endif;?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </form>
</div>
<div class="clear"></div>
<div id="gallery_modal" class="reveal-modal">
    <div class="cont-pop">
        <a class="close-reveal-modal"><?php echo Yii::t('user', 'Закрыть')?></a>

        <form action="post.php" method="POST">
            <div id="galleryPhoto">
                <span id="numPhoto">3/10</span>
                <a href="" id="left" class="navGallery"></a>
                <a href="" id="right" class="navGallery"></a>
                <?php foreach (UserPersonalPhoto::getPhoto(Yii::app()->user->id) as $key => $value): ?>


                <?php endforeach;?>
            </div>
            <div id="galleryOption">
                <a href="" class="btn-30">
                    <span class="upload-ico ico"></span>
                    <span class="btn-30-txt"><?php echo Yii::t('account', 'Загрузить фото'); ?></span>
                </a>
                <a href="" class="btn-30">
                    <span class="star-ico ico"></span>
                    <span class="btn-30-txt"><?php echo Yii::t('account', 'Сделать основной'); ?></span>
                </a>
                <br/><br/>
                <a href="" class="btn-30">
                    <span class="del-ico ico"></span>
                    <span class="btn-30-txt"><?php echo Yii::t('account', 'Удалить'); ?></span>
                </a>
            </div>
            <div class="clear"></div>
        </form>


    </div>
</div>

<script type="txt/javascript">
    $("select").selectBox('create');
    $('input.txt').bind('focus', function () {
        $(this).parent().css('background-position', '100% -105px');
        $(this).parent().parent().css('background-position', '0 -70px');
    });

    $('input.txt').bind('blur', function () {
        $(this).parent().css('background-position', '100% -35px');
        $(this).parent().parent().css('background-position', '0 0');
    });

    $(document).ready(function () {
        $('.add_field').click(function () {
            var id = <?php echo $data->discodes_id;?>;
            var type_id = $(this).children('a').attr("href");

            if (id && type_id) {
                $.ajax({
                    url:'/ajax/spotPersonalContent',
                    type:'POST',
                    data:{discodes_id:id, type_id:type_id},
                    success:function (result) {
                        $('#spot_content_' + id).html(result);
                    }
                });
            }
            return false;
        });
    });

    $(document).ready(function () {
        $('a#get_gallery').click(function () {
            $.ajax({
                url:'/ajax/spotGetGallery',
                type:'POST',
                data:{user_id:<?php echo Yii::app()->user->id;?>},
                success:function (result) {
                    $('.view_gallery').html(result);
                    $('#gallery_modal').reveal({animation:'none'});
                }
            });
        });
    });

    $(function () {
        $("#add_photo").uploadifive({
            'width':'120',
            'height':'28',
            uploadScript:'/user/upload/',
            'formData':{'action':'spot_personal', 'user_id':<?php echo Yii::app()->user->id;?>},
            'removeTimeout':10,
            'multi':false,
            'buttonClass':'uploadify_personal',
            'buttonText':'<?php echo Yii::t('profile', 'Загрузить');?>',

            'onError':function (errorType) {
                $('#messages_modal div.messages').html('The file could not be uploaded: ' + errorType);
                $('#messages_modal').reveal({animation:'none'});
            },
            'onUploadComplete':function (file, data, response) {
                var obj = jQuery.parseJSON(data);
                var file_name = obj.file;
                var error = obj.error;
                if (file_name) {
                    $('#personal_photo').val(file_name);
                    $('.photo-cont').html('<img width="130" src="/uploads/spot/' + file_name + '" />');
                    $('.get_gallery').show();

                    $.ajax({
                        url:'/ajax/spotPersonalPhoto',
                        type:'POST',
                        data:{user_id:<?php echo Yii::app()->user->id?>, file_name:file_name}
                    });
                }
                if (error) alert(error);
            }
        });
    });
</script>