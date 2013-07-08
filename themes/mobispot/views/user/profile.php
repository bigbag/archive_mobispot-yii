<?php
$this->pageTitle = Yii::t('profile', 'Personal data');
?>
<div class="row">
    <div class="singlebox-margin">
        <div class="six columns">
            <form class="custom">
                <h3><?php echo Yii::t('user', 'Profile info'); ?></h3>
                <input type="text" placeholder="<?php echo Yii::t('user', 'Name'); ?>">
                <label for="radio1" class="label-custom left">
                    <input id="radio1" type="radio" checked="" style="display:none;" name="radio1">
                    <span class="custom radio checked"></span>
                    Male
                </label>
                <label for="radio2" class="label-custom left">
                    <input id="radio2" type="radio" style="display:none;" name="radio1">
                    <span class="custom radio"></span>
                    Female
                </label>
                <div class="date-input clear">
                    <input type="text" value="24.04.1984" placeholder="Birthday"><i>&#xe007;</i>
                </div>
                <input type="text" value="Minsk" placeholder="City">

                <input type="email" value="dmitry.smolog@gmail.com" placeholder="Email">
                <ul class="m-soc-linking clearfix">
                    <li class="m-switch-case left">
                        <h5>Facebook</h5>
                        <div class="small-4 switch radius">
                            <input id="c" type="radio" checked="" name="switch-c1">
                            <label onclick="" for="c">Off</label>
                            <input id="c1" type="radio" name="switch-c1">
                            <label onclick="" for="c1">On</label>
                            <span></span>
                        </div>
                    </li>
                    <li class="m-switch-case left">
                        <h5>Google +</h5>
                        <div class="small-4 switch radius">
                            <input id="c2" type="radio" checked="" name="switch-c2">
                            <label onclick="" for="c2">Off</label>
                            <input id="c3" type="radio" name="switch-c2">
                            <label onclick="" for="c3">On</label>
                            <span></span>
                        </div>
                    </li>
                    <li class="m-switch-case left">
                        <h5>Twitter</h5>
                        <div class="small-4 switch radius">
                            <input id="c4" type="radio" checked="" name="switch-c3">
                            <label onclick="" for="c4">Off</label>
                            <input id="c5" type="radio" name="switch-c3">
                            <label onclick="" for="c5">On</label>
                            <span></span>
                        </div>
                    </li>
                </ul>
            </form>
        </div>
        <div class="six columns">
            <h3><?php echo Yii::t('user', 'Change password'); ?></h3>
            <a class="spot-button toggle-box"><?php echo Yii::t('user', 'Send to email'); ?></a>
        </div>
    </div>
</div>
<!-- <div class="row" ng-controller="HelpCtrl">
    <div class="twelve columns singlebox-margin">
        <div class="row">
            <div class="six columns">
                <form id="sign-in" name="signForm">
                    <input
                        type="text"
                        ng-model="user.name"
                        placeholder="<?php echo Yii::t('user', 'Name'); ?>">
                    <input
                        type="text"
                        ng-model="user.city"
                        placeholder="<?php echo Yii::t('user', 'City'); ?>">
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
                            <?php echo Yii::t('profile', 'Save'); ?>
                        </a>
                    </div>
                </form>
            </div>
            <div class="six columns">
                <h4><?php echo Yii::t('profile', 'Connect with:'); ?></h4>
                <span class="soc-connect">
                    <?php $facebookStatus = (!empty($user->facebook_id)) ? 'active' : ''; ?>
                    <a class="spot-button eight <?php echo $facebookStatus; ?>" href="/service/socialConnect?service=facebook">
                        <span>&#xe000;</span> <?php echo Yii::t('profile', 'Facebook'); ?>
                    </a>
                    <?php $twitterStatus = (!empty($user->twitter_id)) ? 'active' : ''; ?>
                    <a class="spot-button eight <?php echo $twitterStatus; ?>" href="/service/socialConnect?service=twitter">
                        <span>&#xe001;</span> <?php echo Yii::t('profile', 'Twitter'); ?>
                    </a>

                    <?php $googleStatus = (!empty($user->google_oauth_id)) ? 'active' : ''; ?>
                    <a class="spot-button eight <?php echo $googleStatus; ?>" href="/service/socialConnect?service=google_oauth">
                        <span>&#xe002;</span> <?php echo Yii::t('profile', 'Google'); ?>
                    </a>
                </span>
            </div>
        </div>
    </div>
</div> -->