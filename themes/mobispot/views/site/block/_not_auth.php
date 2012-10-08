<div class="title"><?php echo Yii::t('general', 'Начните использовать Ваш спот<br /> прямо сейчас')?></div>
<div class="area">
    <form action="#" method="post" id="registration">
        <input type="text" id="email"
               name="RegistrationForm[email]"
               value="" placeholder="<?php echo Yii::t('user', 'Email');?>"
               autocomplete="off"/>
        <input type="password" id="password"
               name="RegistrationForm[password]"
               value="" placeholder="<?php echo Yii::t('user', 'Пароль');?>" autocomplete="off"/>

        <input type="password" id="verifyPassword"
               name="RegistrationForm[verifyPassword]"
               value="" placeholder="<?php echo Yii::t('user', 'Подтверждение пароля');?>"
               autocomplete="off"/>
        <input type="text" id="activ_code"
               name="RegistrationForm[activ_code]"
               value="" placeholder="<?php echo Yii::t('user', 'Код активации спота');?>"
               autocomplete="off"/>

        <div class="terms" style="display: none;">
            <span class="dop-txt">
                <?php echo Yii::t('user', 'Я согласен с условиями предоставления сервиса');?>
                <input type="checkbox" name="RegistrationForm[terms]" value="1">
            </span>

        </div>
        <div class="block">
            <div class="social">
                <a class="auth-link facebook" href="/service/social?service=facebook" title="facebook"><img
                        src="/themes/mobispot/images/auth_facebook.png" alt="facebook"></a>
                <a class="auth-link twitter" href="/service/social?service=twitter" title="twitter"><img
                        src="/themes/mobispot/images/auth_twitter.png" alt="twitter"></a>
                <a class="auth-link google_oauth" href="/service/social?service=google_oauth" title="google"><img
                        src="/themes/mobispot/images/auth_google.png" alt="google"></a>
            </div>
            <div class="reg-button">
                <input type="hidden" name="token" id="token"
                       value="<?php echo Yii::app()->request->csrfToken?>">
                <input type="submit" class="m-button" value="<?php echo Yii::t('user', 'Зарегистрироваться');?>"/>
            </div>
        </div>
    </form>
</div>