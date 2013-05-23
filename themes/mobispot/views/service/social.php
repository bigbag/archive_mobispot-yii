<?php
 #$this->pageTitle=$title;

?>
<div class="row header-page recovery m-content-form"  ng-controller="UserCtrl" >
  <div class="twelve columns">
    <div  class="row">
      <div class="seven columns centered">
        <h3><?php echo Yii::t('activate', 'Start using your spot right now');?></h3>
      </div>
    </div>
    <div class="row">
      <div class="five columns centered">
        <form action="" method="post" name="socialForm">
          <input
            type="hidden"
            name="token"
            value="<?php echo Yii::app()->request->csrfToken?>">
          <?php if($service == 'twitter'):?>
            <input
              type="text"
              name="RegistrationSocialForm[email]"
              placeholder="<?php echo Yii::t('user', 'Email');?>"
              autocomplete="off">
          <?php else:?>
          <input
            type="hidden"
            name="RegistrationSocialForm[email]"
            value="<?php echo $email?>" >
          <?php endif?>

          <input
            type="text"
            name="RegistrationSocialForm[activ_code]"
            placeholder="<?php echo Yii::t('user', 'Spot activation code')?>"
            maxlength="10"
            autocomplete="off">
          <input
            style="display:none"
            type="text"
            name="RegistrationSocialForm[terms]"
            value="{{user.terms}}">
          <div class="toggle-active">
            <a class="checkbox agree"  href="javascript:;" ng-click="setTerms(user)"><i></i><?php echo Yii::t('user', 'I agree to Terms and Conditions');?></a>
          </div>
          <div class="form-control">
            <a class="spot-button activ" href="javascript:;" ng-click="social(user)">
              <?php echo Yii::t('user', 'Activate spot');?>
            </a>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>