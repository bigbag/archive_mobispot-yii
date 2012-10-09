<?php
/**
 * /tmp/phptidy-sublime-buffer.php
 *
 * @package default
 */


?>
<div class="page">
    <div class="title"><?php echo Yii::t('faq', 'Личные данные');?></div>
    <?php echo CHtml::beginForm('', 'post'); ?>
    <div class="profile">
        <div class="row">
            <div class="four columns">
                <div class="photo-cont">
                    <?php if (!empty($profile->photo)): ?>
                    <img src="/uploads/images/<?php echo $profile->photo?>" width="200px" alt="personal"/>
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
            <div class="seven columns body">
                <div class="row name">
                    <div class="four columns">
                        <label class="left inline"><?php echo Yii::t('profile', 'Имя');?></label>
                    </div>
                    <div class="eight columns">
                        <?php echo CHtml::activeTextField($profile, 'name', array('class' => 'nine' )); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="four columns">
                        <label class="left inline"><?php echo Yii::t('profile', 'Дата рождения');?></label>
                    </div>
                    <div class="row">
                        <div class="six columns">
                        <div class="three columns birthday">
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
                        </div>

                        <div class="five columns" />
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
                        </div>
                        <div class="four columns">
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
                        </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="four columns">
                        <label class="left inline"><?php echo Yii::t('profile', 'Город');?></label>
                    </div>
                    <div class="eight columns">
                        <?php echo CHtml::activeTextField($profile, 'place', array('class' => 'nine' )); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="four columns">
                        <label class="left inline"><?php echo Yii::t('profile', 'Пол');?></label>
                    </div>
                    <div class="eight columns sex">
                        <input type="hidden" value="0" name="UserProfile[sex][]" />
                        <input value="1" type="checkbox" name="UserProfile[sex][]" />&nbsp;
                        <?php echo Yii::t('profile', 'Male');?>&nbsp;&nbsp;
                        <input value="2" type="checkbox" name="UserProfile[sex][]" />&nbsp;
                        <?php echo Yii::t('profile', 'Female');?>
                    </div>
                </div>
            </div>
        </div>

        <div class="save">

                <input type="submit" class="m-button" value="<?php echo Yii::t('profile', 'Сохранить');?>"/>

        </div>

    </div>
    <?php echo CHtml::endForm(); ?>
</div>


<?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/js/jquery.uploadifive.min.js'); ?>
<script type="text/javascript">
    $(function () {
        $("#add_photo").uploadifive({
            'width':'120',
            'height':'28',
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
