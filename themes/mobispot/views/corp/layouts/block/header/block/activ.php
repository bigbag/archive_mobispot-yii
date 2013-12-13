<div id="actSpotForm"  ng-controller="UserController" class="slide-box">
  <div class="row">
    <a href="javascript:;" class="slide-box-close">&#xe00b;</a>
    <div class="large-3 columns">
      &nbsp;
    </div>
    <div class="large-6 columns small-centered text-center">
      <h3 class="color text-center">
        <?php echo Yii::t('user', 'Регистрация')?>
      </h3>
    </div>
    <div class="large-3 columns">
      &nbsp;
    </div>
  </div>
  <div class="row">
    <div class="large-4 columns">
      &nbsp;
    </div>
    <div class="large-4 columns small-centered">
      <div class="choose-type">
        <form id="personSpotForm" name="activForm">
          <input
            name='email'
            type="email"
            ng-model="user.email"
            placeholder="<?php echo Yii::t('user', 'E-mail')?>"
            autocomplete="off"
            maxlength="300"
            required >
          <input
            name='password'
            type="password"
            ng-model="user.password"
            placeholder="<?php echo Yii::t('user', 'Пароль')?>"
            autocomplete="off"
            maxlength="300"
            required >
          <input
            name='code'
            type="text"
            ng-model="user.activ_code"
            placeholder="<?php echo Yii::t('user', 'Код активации')?>"
            autocomplete="off"
            maxlength="10"
            ng-minlength="10";
            ng-maxlength="10"
            required >
          <div class="toggle-active">
            <a class="checkbox agree" href="javascript:;" ng-click="setTerms(user)"><i></i>
              <?php echo Yii::t('user', 'Я согласен с условиями использования сервиса')?>
            </a>
          </div>
          <div class="form-control">
            <a class="spot-button opacity activ button-disable" href="javascript:;" ng-click="registration(user, activForm.$valid)"><?php echo Yii::t('user', 'Зарегистрироваться')?></a>
          </div>
        </form>
      </div>
    </div>
    <div class="large-4 columns">
      &nbsp;
    </div>
  </div>
</div>