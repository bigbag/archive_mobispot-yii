<div class="auth-hint" ng-controller="LoginController" ng-init="user.token='<?php echo Yii::app()->request->csrfToken?>'">
<form class="login-form" name="form" action="" method="post">

    <input type="email" autocomplete="off" ng-model="user.email" name="LoginForm[email]" placeholder="<?php echo Yii::t('user', 'E-mail')?>" required />
    <input type="hidden" value="<?php echo Yii::app()->request->csrfToken?>" name="token"/>

    <input type="password" autocomplete="off" ng-model="user.password" name="LoginForm[password]" placeholder="<?php echo Yii::t('user', 'Пароль')?>" required />


    <div class="remember-me">
        <input type="checkbox" ng-model="user.rememberMe" name="LoginForm[rememberMe]" ng-init="user.rememberMe=false"/>
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
             <button class="m-button" ng-click="login(user)" ng-disabled="form.$invalid">
                <?php echo Yii::t('user', 'Отправить'); ?>
            </button>
        </div>
    </div>
    <div class="forget-pass"><?php echo Yii::t('user', 'Забыли пароль?')?></div>

</form>
</div>