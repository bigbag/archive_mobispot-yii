<h2><?php echo Yii::t('general', 'Начните использовать Ваш спот<br /> прямо сейчас')?></h2>
<span class="error"></span>
<form action="#" method="post" id="registration">

    <div class="txt-form">
        <div class="txt-form-cl">
            <input type="text" id="email" style="width:325px;" class="txt"
                   name="RegistrationForm[email]"
                   value="" placeholder="<?php echo Yii::t('user', 'Email');?>"
                   autocomplete="off"/></div>
    </div>
    <div class="txt-form">
        <div class="txt-form-cl">
            <input type="text" id="password" style="width:325px;" class="txt"
                   name="RegistrationForm[password]"
                   value="" placeholder="<?php echo Yii::t('user', 'Пароль');?>" autocomplete="off"/>
        </div>
    </div>
    <div class="txt-form">
        <div class="txt-form-cl">
            <input type="text" id="verifyPassword" style="width:325px;" class="txt"
                   name="RegistrationForm[verifyPassword]"
                   value="" placeholder="<?php echo Yii::t('user', 'Подтверждение пароля');?>"
                   autocomplete="off"/></div>
    </div>
    <div class="txt-form">
        <div class="txt-form-cl">
            <input type="text" id="activ_code" style="width:325px;" class="txt"
                   name="RegistrationForm[activ_code]"
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
                       name="RegistrationForm[verifyCode]"
                       value=""/></div>
        </div>

    </div>
    <div id="terms" style="display: none;">
        <input type="checkbox" name="RegistrationForm[terms]" value="1" class="niceCheck">
                    <span class="dop-txt">
                        <?php echo Yii::t('user', 'Я согласен с условиями предоставления сервиса');?>
                    </span>
    </div>
    <span class="auth-service">
         <a class="auth-link facebook" href="/service/social?service=facebook" title="facebook"><img
             src="/themes/mobispot/images/auth_facebook.png" alt="fb"></a>
         <a class="auth-link twitter" href="/service/social?service=twitter" title="twitter"><img
             src="/themes/mobispot/images/auth_twitter.png" alt="tw"></a>
         <a class="auth-link google_oauth" href="/service/social?service=google_oauth" title="google"><img
             src="/themes/mobispot/images/auth_google.png" alt="g"></a>
    </span>
    <div class="btn-30">
        <input type="hidden" name="token" id="token"
               value="<?php echo Yii::app()->request->csrfToken?>">

        <div><input type="submit" value="<?php echo Yii::t('user', 'Зарегистрироваться');?>"/></div>
    </div>
</form>