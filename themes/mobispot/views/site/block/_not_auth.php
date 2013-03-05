<div class="title"><?php echo Yii::t('general', 'Начните использовать Ваш спот<br /> прямо сейчас')?></div>
<div class="login alert-box alert messages" style="display: none;">
<?php echo Yii::t('user', 'Введённые данные не верны.')?>
</div>
<div class="area registration-form" ng-controller="UserController" ng-init="rUser.token='<?php echo Yii::app()->request->csrfToken?>'">
<form name="regUserForm">
<input type="text"
name="name"
value="" placeholder=""
autocomplete="off"
style="display: none;"/>
<input type="email"
ng-model="rUser.email"
name="email"
value=""
placeholder="<?php echo Yii::t('user', 'Email');?>"
autocomplete="off"
ng-required="true" />
<input type="password"
ng-model="rUser.password"
name="password"
class="password-form"
value=""
placeholder="<?php echo Yii::t('user', 'Пароль');?>"
autocomplete="off"
ng-minlength="6"
ng-required="true" />
<input type="password"
ng-model="rUser.verifyPassword"
name="verifyPassword"
value=""
placeholder="<?php echo Yii::t('user', 'Подтверждение пароля');?>"
autocomplete="off"
ng-minlength="6"
ng-required="true"
data-equal="rUser.password"/>
<input type="text"
ng-model="rUser.activ_code"
name="activ_code"
value=""
placeholder="<?php echo Yii::t('user', 'Код активации спота');?>"
autocomplete="off"
ng-minlength="10"
ng-maxlength="10"
ng-required="true"/>

<div class="terms"  ng-show="rUser.email && rUser.password && rUser.verifyPassword && rUser.activ_code">
<span class="dop-txt">
<?php echo Yii::t('user', 'Я согласен с условиями предоставления сервиса');?>
<input ng-model="rUser.terms" type="checkbox" name="RegistrationForm[terms]" value="1" ng-required="true">
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
<button class="m-button" ng-click="registration(rUser)" ng-disabled="regUserForm.$invalid">
<?php echo Yii::t('user', 'Зарегистрироваться');?>
</button>
</div>
</div>
</form>
</div>