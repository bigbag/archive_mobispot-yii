<?php
$this->pageTitle = Yii::t('profile', 'Personal data');
?>
<div class="row">
<div class="five columns" ng-controller="UserController" >
    <form id="personInfo" name="setInfoForm" 
        ng-init="user.id='<?php echo $user->id;?>'; 
                user.name='<?php echo $profile->name;?>';
                user.city='<?php echo $profile->city;?>';
                user.birthday='<?php echo $profile->birthday;?>';
                user.sex=<?php echo $profile->sex;?>">
        <h3><?php echo Yii::t('user', 'Profile info'); ?></h3>
        <input 
            name='name'
            type="text" 
            ng-model="user.name"
            placeholder="<?php echo Yii::t('user', 'Name'); ?>"
            autocomplete="off"
            maxlength="300">

        <div class="sex-options"> 
            <ul class="add-active">
                <li <?php echo ($profile->sex==0)?'class="active"':''?>>
                    <a href="javascript:;" ng-click="user.sex=0" class="radio-link">
                        <i class="large"></i><?php echo Yii::t('user', 'Not specified'); ?>
                    </a>
                </li>
                <li <?php echo ($profile->sex==1)?'class="active"':''?>>
                    <a href="javascript:;" ng-click="user.sex=1" class="radio-link">
                        <i class="large"></i><?php echo Yii::t('user', 'Male'); ?>
                    </a>
                </li>
                <li <?php echo ($profile->sex==2)?'user.sex=2"':''?>>
                    <a href="javascript:;" ng-click="setSex(2)" class="radio-link">
                        <i class="large"></i><?php echo Yii::t('user', 'Female'); ?>
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="date-input clear">
            <input 
                id="birthday" 
                name='birthday'
                type="text"
                ng-model="user.birthday"
                value=''
                placeholder="<?php echo Yii::t('user', 'Birthday'); ?>"><i>&#xe007;</i>
        </div>
        <input 
            name='city'
            type="text" 
            maxlength="300"
            ng-model="user.city"
            placeholder="<?php echo Yii::t('user', 'City'); ?>">
        <div class="form-item-buton">
            <a class="spot-button toggle-box" ng-click="setProfile(user)"><?php echo Yii::t('user', 'Save'); ?></a>
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
<div id="recPassForm" class="six columns" ng-controller="UserController">
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
</div>