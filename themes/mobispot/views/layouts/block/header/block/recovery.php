<div id="recPassForm" class="slide-box"  ng-controller="UserCtrl">
    <div class="row">
      <div class="seven columns centered">
        <h3><?php echo Yii::t('user', 'Recovery')?></h3>
      </div>
      <a href="javascript:;" class="slide-box-close">&#xe00b</a>
    </div>
    <div class="row">
      <div class="five columns centered">
       <form id="sign-in" name="recoveryForm">
        <input
          name='email'
          type="email"
          ng-model="user.email"
          placeholder="<?php echo Yii::t('user', 'E-mail')?>"
          ui-keypress="{enter: 'login(user, signForm.$valid)'}"
          autocomplete="off"
          maxlength="300"
          required >
          <div class="form-control">
            <a class="spot-button  button-disable" href="javascript:;" ng-click="recovery(user, recoveryForm.$valid)"><?php echo Yii::t('user', 'Send')?></a></a>
          </div>
        </form>
      </div>
    </div>
  </div>