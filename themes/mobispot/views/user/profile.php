<?php
  $this->pageTitle= Yii::t('profile', 'Personal data');
?>
<div class="row" ng-controller="HelpCtrl">
  <div class="twelve columns singlebox-margin">
    <div class="row">
      <div class="six columns">
        <span class="soc-connect">
          <?php $facebookStatus=(!empty($user->facebook_id))?'active':'';?>
          <a class="spot-button six <?php echo $facebookStatus;?>" href="javascript:;">
            &#xe000; <?php echo Yii::t('profile', 'Facebook');?>
          </a>

          <?php $twitterStatus=(!empty($user->twitter_id))?'active':'';?>
          <a class="spot-button six <?php echo $twitterStatus;?>" href="javascript:;">
            &#xe001; <?php echo Yii::t('profile', 'Twitter');?>
          </a>

          <?php $googleStatus=(!empty($user->google_oauth_id))?'active':'';?>
          <a class="spot-button six <?php echo $googleStatus;?>" href="javascript:;">
            &#xe002; <?php echo Yii::t('profile', 'Google');?>
          </a>
        </span>




      </div>
      <div class="six columns">

      </div>
    </div>
  </div>
</div>