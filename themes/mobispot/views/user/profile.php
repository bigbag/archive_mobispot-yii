<div id="main-container">
    <div id="cont-block" class="center">
        <div id="cont-block-760" class="center">
            <div id="zag-cont-block"><?php echo Yii::t('profile', 'Личные данные');?></div>
            <?php echo CHtml::beginForm('', 'post'); ?>
            <div id="lf-block">
                <div class="photo-cont">
                    <?php if (!empty($profile->photo)): ?>
                    <img src="/uploads/images/<?php echo $profile->photo?>" alt="personal"/>
                    <?php else: ?>
                    <img src="/themes/mobispot/images/personal_no_photo.jpg" alt="personal"/>
                    <?php endif;?>
                    <noscript>
                        <p>Please enable JavaScript to use file uploader.</p>
                    </noscript>
                </div>
                <div class="round-btn-new"><input type="submit" id="add_photo"
                                                  value="<?php echo Yii::t('profile', 'Загрузить');?>"/>
                </div>
                <div class="clear"></div>
                <?php echo CHtml::activeCheckBox($profile, 'use_photo', array('class' => 'niceCheck')); ?>
                <span class="dop-txt">
                        <?php echo Yii::t('profile', 'Использовать фото<br/>в моих личных спотах');?>
                </span>
                <a href="" class="btn-30">
                    <span class="fb-ico ico"></span>
                    <span class="btn-30-txt"><?php echo Yii::t('profile', 'Connect with Facebook');?></span></a>
                <a href="" class="btn-30">
                    <span class="tw-ico ico"></span>
                    <span class="btn-30-txt"><?php echo Yii::t('profile', 'Connect with Twitter');?></span></a>
            </div>
            <div id="ld-block">
                <?php if (Yii::app()->user->hasFlash('profile')): ?>
                <br/>
                <span class="error">
                    <?php echo Yii::app()->user->getFlash('profile'); ?>
                    </span>
                <?php endif; ?>
                <table id="ld-block-form">
                    <tr>
                        <td class="field">Имя</td>
                        <td>
                            <div class="txt-form">
                                <div class="txt-form-cl">
                                    <?php echo CHtml::activeTextField($profile, 'name', array('style' => 'width:100%;')); ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="field"><?php echo Yii::t('profile', 'Дата рождения');?></td>
                        <td>

                            <select name="UserProfile[birthday_day]">
                                <option></option>
                                <?php for ($i = 1; $i <= 31; $i++): ?>
                                <?php if (!empty($profile->birthday_day) and $i == $profile->birthday_day): ?>
                                    <option value="<?php echo $i?>" selected><?php echo $i?></option>
                                    <?php else: ?>
                                    <option value="<?php echo $i?>"><?php echo $i?></option>
                                    <?php endif; ?>
                                <?php endfor;?>
                            </select>
                            <select name="UserProfile[birthday_month]">
                                <option></option>
                                <?php foreach (MDate::month() as $key => $value): ?>
                                <?php if (!empty($profile->birthday_month) and $key == $profile->birthday_month): ?>
                                    <option value="<?php echo $key?>" selected><?php echo $value?></option>
                                    <?php else: ?>
                                    <option value="<?php echo $key?>"><?php echo $value?></option>
                                    <?php endif; ?>
                                <?php endforeach;?>
                            </select>
                            <select name="UserProfile[birthday_year]">
                                <option></option>
                                <?php for ($i = date("Y") - 100; $i <= date("Y"); $i++): ?>
                                <?php if (!empty($profile->birthday_year) and $i == $profile->birthday_year): ?>
                                    <option value="<?php echo $i?>" selected><?php echo $i?></option>
                                    <?php else: ?>
                                    <option value="<?php echo $i?>"><?php echo $i?></option>
                                    <?php endif; ?>
                                <?php endfor;?>
                            </select>

                        </td>
                    </tr>
                    <tr>
                        <td class="field"><?php echo Yii::t('profile', 'Город');?></td>
                        <td>
                            <div class="txt-form">
                                <div class="txt-form-cl">
                                    <?php echo CHtml::activeTextField($profile, 'place', array('style' => 'width:100%;')); ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="field"><?php echo Yii::t('profile', 'Пол');?></td>
                        <td>
                            <?php echo CHtml::activeCheckBoxList($profile, 'sex', UserProfile::getSexList(), array(
                            'class' => 'niceCheck',
                            'separator' => '',
                            'template' => '{input}&nbsp;{label}&nbsp;&nbsp;'
                        )); ?>

                        </td>
                    </tr>
                </table>
            </div>
            <div class="clear"></div>
            <div id="foot-cont-block">
                <div class="btn-30">
                    <div><input type="submit" class="" value="<?php echo Yii::t('profile', 'Сохранить');?>"/></div>
                </div>
            </div>
            <?php echo CHtml::endForm(); ?>

            <div class="clear"></div>
        </div>
    </div>
</div>

<?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/js/jquery.uploadifive.min.js'); ?>
<script type="text/javascript">
    $(function () {
        $("#add_photo").uploadifive({
            'width':'120',
            'height':'28',
            swf:'/themes/mobispot/js/uploadify.swf',
            uploadScript:'/site/upload/',
            'formData':{'action':'personal', 'user_id':<?php echo Yii::app()->user->id;?>},
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
                    $('.photo-cont').html('<img src="/uploads/images/' + file_name + '" />');
                    $('#photo-cont').hide();
                }
                if (error) alert(error);
            }
        });
    });
</script>