<h2><?php echo Yii::t('general', 'Начните использовать Ваш спот<br /> прямо сейчас')?></h2>
<span class="error"><?php echo CHtml::errorSummary($model); ?></span>
<form action="" method="post">
    <div class="txt-form">
        <div class="txt-form-cl">
            <input type="text" id="email" style="width:325px;" class="txt"
                   name="RegistrationSocialForm[email]"
                   value="<?php echo $email?>" placeholder="<?php echo Yii::t('user', 'Email');?>"
                   autocomplete="off"/></div>
    </div>
    <div class="txt-form">
        <div class="txt-form-cl">
            <input type="text" id="activ_code" style="width:325px;" class="txt"
                   name="RegistrationSocialForm[activ_code]"
                   value="" placeholder="<?php echo Yii::t('user', 'Код активации спота');?>"
                   autocomplete="off"/></div>
    </div>
    <div id="registration_captcha" style="display: none">
        <?php echo Yii::t('user', 'Введите код показанный на картинке');?>
        <div id="img-capt">

        </div>
        <div class="txt-form">
            <div class="txt-form-cl">
                <input type="text" id="verifyCode" style="width:325px;" class="txt"
                       name="RegistrationSocialForm[verifyCode]"
                       value=""/></div>
        </div>
    </div>
    <div id="terms">
        <input type="checkbox" name="RegistrationSocialForm[terms]" value="1" class="niceCheck">
                    <span class="dop-txt">
                        <?php echo Yii::t('user', 'Я согласен с условиями предоставления сервиса');?>
                    </span>
    </div>

    <div class="btn-30">
        <input type="hidden" name="token" id="token"
               value="<?php echo Yii::app()->request->csrfToken?>">

        <div><input type="submit" value="<?php echo Yii::t('user', 'Зарегистрироваться');?>"/></div>
    </div>
</form>
