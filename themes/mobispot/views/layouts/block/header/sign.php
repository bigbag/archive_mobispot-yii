<div id="signInForm" class="slide-box" ng-init="user.token='<?php echo Yii::app()->request->csrfToken?>'">
<div  class="row">
<div class="seven columns centered">
<h3><?php echo Yii::t('sign', 'Sign in');?></h3>
</div>
<a href="javascript:;" class="slide-box-close"></a>
</div>
<div class="row">
<div class="five columns centered">
<form id="sign-in" name="signForm">
<input name='email' type="email" ng-model="user.email" placeholder="<?php echo Yii::t('sign', 'Email address');?>" required >
<input name='password' type="password" ng-model="user.password" placeholder="<?php echo Yii::t('sign', 'Password');?>" required >
<input name="token" type="hidden" value="<?php echo Yii::app()->request->csrfToken?>">
{{user.email}}
{{user.password}}
<div class="form-control">
<a class="spot-button login" href="javascript:;" ng-show="!signForm.$invalid" ng-click="login(user)" ><?php echo Yii::t('sign', 'Sign in');?></a>
<span class="right soc-link">
<a href="/service/social?service=facebook" class="i-soc-fac">&nbsp;</a>
<a href="/service/social?service=twitter" class="i-soc-twi">&nbsp;</a>
<a href="/service/social?service=google_oauth" class="i-soc-goo">&nbsp;</a>
</span>
</div>
</form>
</div>
</div>
</div>