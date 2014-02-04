<div id="recPassForm" class="slide-box"  ng-controller="UserController">
  <div class="row">
    <a  class="slide-box-close">&#xe00b;</a>
    <div class="large-3 columns">
      &nbsp;
    </div>
    <div class="large-6 columns small-centered text-center">
      <h3 class="color text-center">
        <?php echo Yii::t('corp_user', 'Восстановление пароля')?>
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
      <form id="recovery-pass" name="recoveryForm">
      <input
        name='email'
        type="email"
        ng-model="recovery.email"
        placeholder="<?php echo Yii::t('corp_user', 'E-mail')?>"
        ng-keypress="($event.keyCode == 13)?recovery(recovery, recoveryForm.$valid):''"
        autocomplete="off"
        maxlength="300"
        required >
        <div class="form-control">
          <a class="spot-button  button-disable"  ng-click="recovery(recovery, recoveryForm.$valid)">
            <?php echo Yii::t('corp_user', 'Отправить')?>
          </a>
        </div>
      </form>
    </div>
    <div class="large-4 columns">
      &nbsp;
    </div>
  </div>
</div>
