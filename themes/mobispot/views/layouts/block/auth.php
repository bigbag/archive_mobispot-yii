<div class="auth-hint">

    <input type="text" name="LoginForm[email]" style="width:100%;" class="txt"
           placeholder="<?php echo Yii::t('user', 'E-mail')?>"/>
    <input type="hidden" name="token" value="<?php echo Yii::app()->request->csrfToken?>">

    <input type="password" name="LoginForm[password]" style="width:100%;"
           placeholder="<?php echo Yii::t('user', 'Пароль')?>"/>


    <div class="remember-me">
        <input name="LoginForm[rememberMe]" type="checkbox">
        <?php echo Yii::t('user', 'Запомнить меня')?>
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

            <input class="button-auth" type="submit" id="hint-button-auth"
                   value="<?php echo Yii::t('user', 'Отправить');?>"/>
        </div>
    </div>
    <div class="forget-pass"><?php echo Yii::t('user', 'Забыли пароль?')?></div>

</div>