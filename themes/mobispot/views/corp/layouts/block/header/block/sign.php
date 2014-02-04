<div id="signInForm" ng-controller="UserController" class="slide-box">
  <div class="row">
    <a  class="slide-box-close">&#xe00b;</a>
    <div class="large-3 columns">
      &nbsp;
    </div>
    <div class="large-6 columns small-centered text-center">
      <h3 class="color text-center">
        <?php echo Yii::t('corp_user', 'Авторизация')?>
      </h3>
    </div>
    <div class="large-3 columns">
      &nbsp;
    </div>
  </div>
  <div  class="row">
    <div class="large-4 columns">
      &nbsp;
    </div>
    <div class="large-4 columns small-centered">
      <form id="sign-in" name="signForm">
        <input
          name='email'
          type="email"
          ng-model="user.email"
          placeholder="<?php echo Yii::t('corp_user', 'E-mail')?>"
          ng-keypress="($event.keyCode == 13)?login(user, signForm.$valid):''"
          autocomplete="off"
          maxlength="300"
          required >
        <input
          name='password'
          type="password"
          ng-model="user.password"
          placeholder="<?php echo Yii::t('corp_user', 'Пароль')?>"
          ng-keypress="($event.keyCode == 13)?login(user, signForm.$valid):''"
          autocomplete="off"
          maxlength="300"
          required >
        <a id="recPass" href="javascripts:;" class="form-link toggle-box">
          <?php echo Yii::t('corp_user', 'Забыли пароль?');?>
        </a>
        <div class="form-control">
          <a class="spot-button opacity login button-disable"  ng-click="login(user, signForm.$valid)">
            <?php echo Yii::t('corp_user', 'Войти')?>
          </a>
        </div>
      </form>
    </div>
    <div class="large-4 columns">
      &nbsp;
    </div>
  </div>
</div>
