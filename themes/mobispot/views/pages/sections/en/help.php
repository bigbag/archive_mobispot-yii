<div class="row">
  <div class="twelve columns">
    <h5>Have a question? Need a hand? Anything bugging you? Please stick
    your details in this form and we’ll get back to you. Pronto. If not sooner.</h5>
  </div>
</div>
<div class="row">
  <div class="six columns">
    <form id="help-in" name="helpForm">
      <input name='email' type="email" placeholder="<?php echo Yii::t('help', 'First Name');?>" required >
      <input name='email' type="email" placeholder="<?php echo Yii::t('help', 'Last name');?>">
      <input name='email' type="email" placeholder="<?php echo Yii::t('help', 'Email');?>" required >
      <input name='email' type="email" placeholder="<?php echo Yii::t('help', 'Mobile');?>">
      <textarea rows="5" placeholder="<?php echo Yii::t('help', 'Question');?>"></textarea>
      <input name="token" type="hidden" value="<?php echo Yii::app()->request->csrfToken?>">
      <div class="form-control">
        <a class="spot-button" href="javascript:;"><?php echo Yii::t('help', 'Send');?></a>
      </div>
    </form>
  </div>
</div>
<div class="row">
  <div class="twelve columns">
    <h5>Or if you want, we can connect on</h5>
    <ul>
      <li>Email – <a href="mailto:helpme@mobispot.com">helpme@mobispot.com</a></li>
      <li>Skype – xxxx</li>
      <li class="soc-link">Keep up at Twitter <a href="#" class="i-soc-fac">&nbsp;</a></li>
      <li class="soc-link">Hook up at Facebook <a href="#" class="i-soc-twi">&nbsp;</a></li>
    </ul>
  </div>
</div>