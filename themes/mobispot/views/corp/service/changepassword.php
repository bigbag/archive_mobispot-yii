<?php
$this->pageTitle=Yii::t('corp_user', 'Мобиспот. Восстановление пароля');

?>
<div id="changePassForm" class="row header-page recovery m-content-form" ng-controller="UserController" >
  <div class="twelve columns">
    <div  class="row">
      <div class="seven columns centered">
        <h3><?php echo Yii::t('corp_user', 'Восстановление пароля')?></h3>
      </div>
    </div>
    <div class="row">
      <div class="five columns centered">
        <form id="change-pass" name="changeForm" ng-init="user.email='<?php echo $email;?>'; user.activkey='<?php echo $activkey;?>'">
          <input
            name="password"
            type="password"
            ng-model="user.password"
            placeholder="<?php echo Yii::t('corp_user', 'Пароль')?>"
            autocomplete="off"
            maxlength="300"
            required >
          <input
            name="confirmPassword"
            type="password"
            ng-model="user.confirmPassword"
            placeholder="<?php echo Yii::t('corp_user', 'Подтверждение пароля')?>"
            autocomplete="off"
            maxlength="300"
            required >

          <div class="form-control">
            <a class="spot-button button-disable" href="javascript:;"  ng-click="change(user, changeForm.$valid)">
              <?php echo Yii::t('corp_user', 'Отправить')?>
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>