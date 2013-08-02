<?php
$this->pageTitle = Yii::t('profile', 'Personal data');
?>

<div class="large-5 columns" ng-controller="UserCtrl" >
    <form class="custom" in="personInfo" name="setInfoForm">
        <h3><?php echo Yii::t('user', 'Profile info'); ?></h3>
        <input 
            name='name'
            type="text" 
            ng-model="user.name"
            placeholder="<?php echo Yii::t('user', 'Name'); ?>"
            autocomplete="off"
            maxlength="300">
        <label for="radio1" class="label-custom left">
            <input 
                id="radio1" 
                type="radio" 
                ng-model="user.sex"
                value="0" 
                style="display:none;" 
                name="radio1">
            <span class="custom radio checked"></span>
            <?php echo Yii::t('user', 'Male'); ?>
        </label>
        <label for="radio2" class="label-custom left">
            <input 
                id="radio2" 
                type="radio"
                ng-model="user.sex" 
                ng-change="{alert(1)}" 
                value="1" 
              
                name="radio1">
            <span class="custom radio"></span>
            <?php echo Yii::t('user', 'Female'); ?>
        </label>
        <div class="date-input clear">
            <input 
                ui-date="dateOptions" 
                id="birthday" 
                name='birthday'
                type="text" 
                ng-model="user.birthday"
                placeholder="<?php echo Yii::t('user', 'Birthday'); ?>"><i>&#xe007;</i>
        </div>
        <input 
            name='city'
            type="text" 
            maxlength="300"
            ng-model="user.city"
            placeholder="<?php echo Yii::t('user', 'City'); ?>">
        {{user}}
        <div class="form-item-buton">
            <a class="spot-button toggle-box"><?php echo Yii::t('user', 'Save'); ?></a>
        </div>
        <h3 class="form-item-30"><?php echo Yii::t('user', 'Easy sign in')?></h3>
        <p class="form-item-30">
            <?php echo Yii::t('user', 'Connect your Mobispot profile with your favourite social network accounts. This will make your sign in easy. If you connect several accounts you will be able to sign in with any of them.'); ?>
        </p>
        <span class="form-soc-link soc-link gray">
            <?php $facebookStatus = (!empty($socnet['facebook'])) ? 'active' : ''; ?>
            <a href="/service/socialConnect?service=facebook" class="i-round-fb <?php echo $facebookStatus; ?>">&#xe000;</a>
            
            <?php $twitterStatus = (!empty($socnet['twitter'])) ? 'active' : ''; ?>
            <a href="/service/socialConnect?service=twitter" class="<?php echo $twitterStatus; ?>">&#xe001;</a>
            
            <?php $googleStatus = (!empty($socnet['google_oauth'])) ? 'active' : ''; ?>
            <a href="/service/socialConnect?service=google_oauth" class="<?php echo $googleStatus; ?>">&#xe002;</a>
        </span>
        <p class="sub-txt"><?php echo Yii::t('user', "Note: This action will not connect your spots' content with your social networks. Please make it separately when editing your spots."); ?></p>
    </form>
</div>
<div id="recPassForm" class="large-6 columns" ng-controller="UserCtrl">
    <h3><?php echo Yii::t('user', 'Change password'); ?></h3>
    <form name="recoveryForm">
    <p class="sub-txt" ng-init="recovery.email='<?php echo $user->email?>'">
        <?php echo Yii::t('user', 'You can change your password following the instructions in a special email from us. Please click the button below to proceed.'); ?>
    </p>
    <a class="spot-button toggle-box" href="javascript:;" ng-click="recovery(recovery, recoveryForm.$valid)">
        <?php echo Yii::t('user', 'Send to email'); ?>
    </a>
    </form>
</div>