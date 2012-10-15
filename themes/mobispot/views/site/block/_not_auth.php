<div class="title"><?php echo Yii::t('general', 'Начните использовать Ваш спот<br /> прямо сейчас')?></div>
<div class="area registration-form" ng-controller="RegistrationController" ng-init="user.token='<?php echo Yii::app()->request->csrfToken?>'">
    <form action=""  name="form">
        <input type="email"
                ng-model="user.email"
                name="RegistrationForm[email]"
                value="" placeholder="<?php echo Yii::t('user', 'Email');?>"
                autocomplete="off" required />
        <input type="password"
                ng-model="user.password"
                name="RegistrationForm[password]"
                value="" placeholder="<?php echo Yii::t('user', 'Пароль');?>" autocomplete="off" required />

        <input type="password"
                ng-model="user.verifyPassword"
                name="RegistrationForm[verifyPassword]"
                value="" placeholder="<?php echo Yii::t('user', 'Подтверждение пароля');?>"
                autocomplete="off" required />
        <input type="text"
                ng-model="user.activ_code"
                name="RegistrationForm[activ_code]"
                value="" placeholder="<?php echo Yii::t('user', 'Код активации спота');?>"
                autocomplete="off"  activation-code />

        <div class="terms"  ng-show="user.email && user.password && user.verifyPassword && user.activ_code">
            <span class="dop-txt">
                <?php echo Yii::t('user', 'Я согласен с условиями предоставления сервиса');?>
                <input ng-model="user.terms" type="checkbox" name="RegistrationForm[terms]" value="1" required>
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
              <button class="m-button" ng-click="registration(user)" ng-disabled="form.$invalid">
                  <?php echo Yii::t('user', 'Зарегистрироваться');?>
              </button>
            </div>
        </div>
    </form>
</div>