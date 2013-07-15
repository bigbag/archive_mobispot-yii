<?php
$this->pageTitle = Yii::t('profile', 'Personal data');
?>
<div class="row">
    <div class="singlebox-margin">
        <div class="five columns">
            <form class="custom">
                <h3><?php echo Yii::t('user', 'Profile info'); ?></h3>
                <input type="text" value="" placeholder="<?php echo Yii::t('user', 'Name'); ?>">
                <label for="radio1" class="label-custom left">
                    <input id="radio1" type="radio" checked="" style="display:none;" name="radio1">
                    <span class="custom radio checked"></span>
                    <?php echo Yii::t('user', 'Male'); ?>
                </label>
                <label for="radio2" class="label-custom left">
                    <input id="radio2" type="radio" style="display:none;" name="radio1">
                    <span class="custom radio"></span>
                    <?php echo Yii::t('user', 'Female'); ?>
                </label>
                <div class="date-input clear">
                    <input type="text" value="" placeholder="<?php echo Yii::t('user', 'Birthday'); ?>"><i>&#xe007;</i>
                </div>
                <input type="text" value="" placeholder="<?php echo Yii::t('user', 'City'); ?>">

                <div class="form-item-buton">
                    <a class="spot-button toggle-box"><?php echo Yii::t('user', 'Save'); ?></a>
                </div>
                <p class="form-item-30">
                    <?php echo Yii::t('user', 'Connect your Mobispot profile with your favourite social network accounts. This will make your sign in easy. If you connect several accounts you will be able to sign in with any of them.'); ?>
                </p>
                <span class="form-soc-link soc-link gray">
                    <?php $facebookStatus = (!empty($user->facebook_id)) ? 'active' : ''; ?>
                    <a href="/service/socialConnect?service=facebook" class="<?php echo $facebookStatus; ?>">&#xe000;</a>
                    
                    <?php $twitterStatus = (!empty($user->twitter_id)) ? 'active' : ''; ?>
                    <a href="/service/socialConnect?service=twitter" class="<?php echo $twitterStatus; ?>">&#xe001;</a>
                    
                    <?php $googleStatus = (!empty($user->google_oauth_id)) ? 'active' : ''; ?>
                    <a href="/service/socialConnect?service=google_oauth" class="<?php echo $googleStatus; ?>">&#xe002;</a>
                </span>
                <p class="sub-txt"><?php echo Yii::t('user', "Note: This action will not connect your spots' content with your social networks. Please make it separately when editing your spots."); ?></p>
            </form>
        </div>
        <div class="six columns" ng-controller="UserCtrl">
            <h3><?php echo Yii::t('user', 'Change password'); ?></h3>
            <form name="recoveryForm">
            <p class="sub-txt" ng-init="recovery.email='<?php echo $user->email?>'">
                <?php echo Yii::t('user', 'You can change your password following the instructions in a special email from us. Please click the button below to proceed.'); ?>
            </p>
            <div id="recPassForm">
            <a class="spot-button toggle-box" href="javascript:;" ng-click="recovery(recovery, recoveryForm.$valid)">
                <?php echo Yii::t('user', 'Send to email'); ?>
            </a>
            </div>
            </form>
        </div>
    </div>
</div>