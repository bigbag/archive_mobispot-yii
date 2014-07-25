<header class="header-page">
  <?php if (Yii::app()->user->isGuest): ?>
  <div class="m-page-hat">
    <div id="signInForm" ng-controller="UserController" class="slide-box">
      <div class="row">
        <a href="javascript:;" class="slide-box-close">&#xe00b;</a>
        <div class="large-3 columns">
          &nbsp;
        </div>
        <div class="large-6 columns small-centered text-center">
          <h3 class="color text-center">
            <?php echo Yii::t('user', 'Авторизация')?>
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
              placeholder="<?php echo Yii::t('user', 'E-mail')?>"
              ng-keypress="($event.keyCode == 13)?login(user, signForm.$valid):''"
              maxlength="300"
              ng-class="{error: error.email}"
              required >
            <input
              name='password'
              type="password"
              ng-model="user.password"
              placeholder="<?php echo Yii::t('user', 'Пароль')?>"
              ng-keypress="($event.keyCode == 13)?login(user, signForm.$valid):''"
              ng-class="{error: error.email}"
              maxlength="300"
              required >
            <div class="form-control">
              <a class="spot-button opacity login button-disable" href="javascript:;" ng-click="login(user, signForm.$valid)">
                <?php echo Yii::t('user', 'Войти')?>
              </a>
            </div>
          </form>
        </div>
        <div class="large-4 columns">
          &nbsp;
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>

  <div class="row">
      <div class="twelve">
        <div class="header-top">
          <div class="large-4 columns">
            <h1 class="logo"><a href="/"><img src="/themes/mobispot/images/logo.png" /></a></h1>
          </div>
          <div class="large-8 columns">
            <ul class="nav-bar">
              <?php if (Yii::app()->user->isGuest): ?>
              <li>
                <a id="signIn" class="spot-button toggle-box opacity" href="#signInForm">
                  <?php echo Yii::t('general', 'Войти')?>
                </a>
              </li>
              <?php else:?>
              <li>
                <a class="spot-button opacity" href="/corp/wallet/">
                  <?php echo Yii::t('general', 'Мои карты')?>
                </a>
              </li>
              <li>
                <a class="spot-button opacity" href="/corp/site/logout/">
                  <?php echo Yii::t('general', 'Выйти')?>
                </a>
              </li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
</header>
