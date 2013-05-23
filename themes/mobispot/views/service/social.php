<?php
 #$this->pageTitle=$title;

?>
<div id="changePassForm" class="row header-page recovery m-content-form">
  <div class="twelve columns">
    <div  class="row">
      <div class="seven columns centered">
        <h3><?php echo Yii::t('activate', 'Start using your spot right now');?></h3>
      </div>
    </div>
    <div class="row">
      <div class="five columns centered">
        <form action="" method="post">
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
            type="checkbox"
            name="RegistrationSocialForm[terms]"
            value="1">
            <?php echo Yii::t('user', 'I agree to Terms and Conditions');?>
          <input
            type="submit"
            value="<?php echo Yii::t('user', 'Activate spot');?>"/>
        </form>
      </div>
    </div>
  </div>
</div>