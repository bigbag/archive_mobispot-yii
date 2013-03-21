<div ng-controller="HelpCtrl" ng-init="user.token='<?php echo Yii::app()->request->csrfToken?>'">
<div class="row">
  <div class="twelve columns">
    <h5><?php echo Yii::t('help', 'Have a question? Need a hand? Anything bugging you? Please stick your details in this form and we’ll get back to you. Pronto. If not sooner.');?></h5>
  </div>
</div>
<div class="row">
  <div class="six columns">
    <form id="help-in" name="helpForm">
      <input name='fName' type="text" ng-model="user.fName" placeholder="<?php echo Yii::t('help', 'First Name');?>" required >
      <input name='lname' type="text" ng-model="user.lname" placeholder="<?php echo Yii::t('help', 'Last name');?>">
      <input name='email' type="email" ng-model="user.email" placeholder="<?php echo Yii::t('help', 'Email');?>" required >
      <input name='phone' type="text" ng-model="user.phone" placeholder="<?php echo Yii::t('help', 'Mobile');?>">
      <textarea name="question" ng-model="user.question" rows="5" placeholder="<?php echo Yii::t('help', 'Question');?> (<?php echo Yii::t('help', 'If you have a suggested answer, please let us know.');?>)"></textarea>

      <div class="form-control">
        <a class="spot-button" href="javascript:;" ng-show="!helpForm.$invalid" ng-click="login(user)"><?php echo Yii::t('help', 'Send');?></a>
      </div>
    </form>
  </div>
</div>
<div class="row">
  <div class="twelve columns">
    <h5><?php echo Yii::t('help', 'Or if you want, we can connect on');?></h5>
    <ul>
      <li><?php echo Yii::t('help', 'Email');?> – <a href="mailto:helpme@mobispot.com">helpme@mobispot.com</a></li>
      <li><?php echo Yii::t('help', 'Skype');?> – mobispot</li>
      <li class="soc-link"><?php echo Yii::t('help', 'Keep up at Twitter');?> <a href="#" class="i-soc-fac">&nbsp;</a></li>
      <li class="soc-link"><?php echo Yii::t('help', 'Hook up at Facebook');?> <a href="#" class="i-soc-twi">&nbsp;</a></li>
    </ul>
  </div>
</div>
</div>