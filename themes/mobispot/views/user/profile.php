<?php $this->pageTitle = Yii::t('profile', 'Personal data'); ?>
<?php $this->mainBackground = 'skulls.png'?>
<div class="content-wrapper">
    <div class="content-block form-block">
        <div class="row">
            <div class="large-4 columns">
                <span ng-init="user.id='<?php echo $user->id;?>'; 
                            user.sex=<?php echo $profile->sex;?>"></span>
                <form id="personInfo" name="setInfoForm" class="custom">
                    <h3 class="single-form-h">
                        <?php echo Yii::t('user', 'Profile info'); ?>
                    </h3>
                    <input 
                        name='name'
                        ng-init="user.name='<?php echo $profile->name;?>'"
                        type="text" 
                        ng-model="user.name"
                        placeholder="<?php echo Yii::t('user', 'Name'); ?>"
                        autocomplete="off"
                        maxlength="300">
                    <span ng-init="user.sex='<?php echo $profile->sex;?>'"></span>
                    <label for="radio1" class="label-custom left">
                        <input id="radio1" 
                            checked="" 
                            type="radio" 
                            style="display:none;" 
                            ng-model="user.sex"
                            ng-value="0"
                            name="radio1">
                        <span class="custom radio"></span>
                        <?php echo Yii::t('user', 'Not specified'); ?>
                    </label>
                    <label for="radio2" class="label-custom left">
                        <input id="radio2" 
                        type="radio" 
                        style="display:none;" 
                        ng-model="user.sex"
                        ng-value="1"
                        name="radio2">
                        <span class="custom radio checked"></span>
                        <?php echo Yii::t('user', 'Male'); ?>
                    </label>
                    <label for="radio3" class="label-custom left">
                        <input id="radio3" 
                        type="radio" 
                        style="display:none;"
                        ng-model="user.sex"
                        ng-value="3" 
                        name="radio3">
                        <span class="custom radio"></span>
                        <?php echo Yii::t('user', 'Female'); ?>
                    </label>

                    <div class="date-input clear">
                        <input 
                            id="birthday" 
                            name='birthday'
                            type="text"
                            ng-model="user.birthday"
                            ng-init="user.birthday='<?php echo $profile->birthday;?>'"
                            value=''
                            placeholder="<?php echo Yii::t('user', 'Birthday'); ?>"><i>&#xe007;</i>
                    </div>
                    <input 
                        name='city'
                        type="text" 
                        maxlength="300"
                        ng-model="user.city"
                        ng-init="user.city='<?php echo $profile->city;?>'"
                        placeholder="<?php echo Yii::t('user', 'City'); ?>">

                    <div class="form-item-buton">
                        <a class="form-button toggle-box" ng-click="setProfile(user)">
                            <?php echo Yii::t('user', 'Save'); ?>
                        </a>
                    </div>
                </form>
            </div>
            <div class="large-8 columns" id="recPassForm">
                <h3 class="single-form-h"><?php echo Yii::t('user', 'Change password'); ?></h3>
                <form name="recoveryForm">
                    <span 
                        ng-init="recUser.email='<?php echo $user->email?>';
                            recUser.token=user.token"
                        ></span>
                    <p class="sub-txt">
                        <?php echo Yii::t('user', 'You can change your password following the instructions in a special email from us. Please click the button below to proceed.'); ?>
                    </p>
                    <a class="form-button toggle-box"  ng-click="recovery(recUser, recoveryForm.$valid)">
                        <?php echo Yii::t('user', 'Send to email'); ?>
                    </a>
                </form>
            </div>
            <div class="large-8 columns">
                <h3 class="single-form-h">
                    <?php echo Yii::t('user', 'Easy sign in')?>
                </h3>
                <p>
                    <?php echo Yii::t('user', 'Connect your Mobispot profile with your favourite social network accounts. This will make your sign in easy. If you connect several accounts you will be able to sign in with any of them.'); ?>
                </p>
                <?php var_dump($socnet)?>
                <span class="form-soc-link soc-link gray">
                    <?php $facebookStatus = (!empty($socnet['facebook'])) ? 'active' : ''; ?>
                    <a href="/service/socialConnect?service=facebook" class="i-round-fb <?php echo $facebookStatus; ?>">&#xe000;</a>
                    
                    <?php $twitterStatus = (!empty($socnet['twitter'])) ? 'active' : ''; ?>
                    <a href="/service/socialConnect?service=twitter" class="<?php echo $twitterStatus; ?>">&#xe001;</a>
                    
                    <?php $googleStatus = (!empty($socnet['google_oauth'])) ? 'active' : ''; ?>
                    <a href="/service/socialConnect?service=google_oauth" class="<?php echo $googleStatus; ?>">&#xe002;</a>
                </span>
                <p class="sub-txt"><?php echo Yii::t('user', "Note: This action will not connect your spots' content with your social networks. Please make it separately when editing your spots."); ?></p>
            </div>
        </div>
    </div>
</div>
<div class="fc"></div>