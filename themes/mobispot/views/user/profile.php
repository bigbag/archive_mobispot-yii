<?php
  $this->pageTitle= Yii::t('profile', 'Personal data');
?>
<div class="row" ng-controller="HelpCtrl">
  <div class="twelve columns singlebox-margin">
    <div class="row">
      <div class="six columns">
        <form id="sign-in" name="signForm">
          <input
            type="text"
            ng-model="user.name"
            placeholder="<?php echo Yii::t('user', 'Name');?>">
          <input
            type="text"
            ng-model="user.city"
            placeholder="<?php echo Yii::t('user', 'City');?>">
          <div class="spot-content_row toggle-active">
            <a class="checkbox agree" href="javascript:;">
              <i class="large"></i>
              Name
            </a>
            <a class="checkbox agree" href="javascript:;">
              <i class="large"></i>
              Phone
            </a>

          </div>
          <div class="form-control">
            <a class="spot-button" href="javascript:;" ng-click="login(user, signForm.$valid)" >
              <?php echo Yii::t('profile', 'Save');?>
            </a>
          </div>
        </form>
      </div>
      <div class="six columns">
        <h4><?php echo Yii::t('profile', 'Connect with:');?></h4>
        <span class="soc-connect">
          <?php $facebookStatus=(!empty($user->facebook_id))?'active':'';?>
          <a class="spot-button eight <?php echo $facebookStatus;?>" href="/service/socialConnect?service=facebook">
            <span>&#xe000;</span> <?php echo Yii::t('profile', 'Facebook');?>
          </a>
          <?php $twitterStatus=(!empty($user->twitter_id))?'active':'';?>
          <a class="spot-button eight <?php echo $twitterStatus;?>" href="/service/socialConnect?service=twitter">
            <span>&#xe001;</span> <?php echo Yii::t('profile', 'Twitter');?>
          </a>

          <?php $googleStatus=(!empty($user->google_oauth_id))?'active':'';?>
          <a class="spot-button eight <?php echo $googleStatus;?>" href="/service/socialConnect?service=google_oauth">
            <span>&#xe002;</span> <?php echo Yii::t('profile', 'Google');?>
          </a>
        </span>
      </div>
    </div>
  </div>
</div>