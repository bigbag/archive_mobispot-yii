<div id="actSpotForm" ng-controller="UserCtrl" class="slide-box">
  <div class="row">
    <div class="seven columns centered">
      <h3><?php echo Yii::t('activate', 'Start using your spot right now');?></h3>
    </div>
    <a href="javascript:;" class="slide-box-close">&#xe00b;</a>
    <div class="five columns centered">
      <div class="choose-type">
        <h6><?php echo Yii::t('activate', 'Are you:');?></h6>
        <div class="columns centered">
          <a id="personSpot" class="radio-link six columns toggle-box toggle-box__sub" href="javascript:;"><i></i><?php echo Yii::t('activate', 'A person?');?></a>
          <a id="companySpot" class="radio-link six columns toggle-box toggle-box__sub" href="javascript:;"><i></i><?php echo Yii::t('activate', 'A business?');?></a>
        </div>
      </div>
    </div>
  </div>
  <div id="personSpotForm" class="bg-gray sub-slide-box">
    <div class="row">
      <div class="five columns centered">
          <form name="activPersonForm">
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
              placeholder="<?php echo Yii::t('user', 'Password')?>"
              autocomplete="off"
              maxlength="300"
              required >
            <input
              name='code'
              type="text"
              ng-model="user.activ_code"
              placeholder="<?php echo Yii::t('user', 'Spot activation code')?>"
              autocomplete="off"
              maxlength="10"
              ng-minlength="10";
              ng-maxlength="10"
              required >
            <div class="toggle-active">
              <a class="checkbox agree"  href="javascript:;" ng-click="setTerms(user)"><i></i><?php echo Yii::t('activate', 'I agree to Terms and Conditions');?></a>
            </div>
            <div class="form-control">
              <a class="spot-button activ button-disable" href="javascript:;" ng-click="registration(user, activPersonForm.$valid)">
                <?php echo Yii::t('activate', 'Activate spot');?>
              </a>
              <span class="right soc-link">
                <a href="/service/social?service=facebook" class="i-soc-fac"></a>
                <a href="/service/social?service=twitter" class="i-soc-twi"></a>
                <a href="/service/social?service=google_oauth" class="i-soc-goo"></a>
              </span>
            </div>
          </form>
      </div>
    </div>
  </div>
  <div id="companySpotForm" class="bg-gray sub-slide-box">
    <div class="row">
      <div class="five columns centered">
        <form name="activCompanyForm">
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
            placeholder="<?php echo Yii::t('user', 'Password')?>"
            autocomplete="off"
            maxlength="300"
            required >
          <input
            name='code'
            type="text"
            ng-model="user.activ_code"
            placeholder="<?php echo Yii::t('user', 'Spot activation code')?>"
            autocomplete="off"
            maxlength="10"
            ng-minlength="10";
            ng-maxlength="10"
            required >
          <div class="toggle-active">
            <a class="checkbox agree" href="javascript:;" ng-click="setTerms(user)"><i></i>
              <?php echo Yii::t('activate', 'I agree to Mobispot Pages Terms');?>
            </a>
          </div>
          <div class="form-control">
            <a class="spot-button button-disable" href="javascript:;" ng-click="registration(user, activCompanyForm.$valid)">
              <?php echo Yii::t('activate', 'Activate spot');?>
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>