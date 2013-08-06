<div id="actSpotForm" ng-controller="UserCtrl" class="slide-box">
    <div class="row">
        <div class="large-7 large-centered columns text-center">
            <h3 class="color"><?php echo Yii::t('activate', 'Start using your spot right now'); ?></h3>
        </div>
        <a href="javascript:;" class="slide-box-close">&#xe00b;</a>
        <div class="large-4 large-centered columns">
            <form id="personSpotForm" name="activPersonForm">
                <input
                    name='email'
                    type="email"
                    ng-model="user.email"
                    placeholder="<?php echo Yii::t('user', 'E-mail') ?>"
                    autocomplete="off"
                    maxlength="300"
                    required >
                <input
                    name='password'
                    type="password"
                    ng-model="user.password"
                    placeholder="<?php echo Yii::t('user', 'Password') ?>"
                    autocomplete="off"
                    maxlength="300"
                    required >
                <input
                    name='code'
                    type="text"
                    ng-model="user.activ_code"
                    placeholder="<?php echo Yii::t('user', 'Spot activation code') ?>"
                    autocomplete="off"
                    maxlength="10"
                    ng-minlength="10";
                    ng-maxlength="10"
                    required >
                <div class="toggle-active">
                    <a class="checkbox agree"  href="javascript:;" ng-click="setTerms(user)"><i></i><?php echo Yii::t('user', 'I agree to Terms and Conditions'); ?></a>
                </div>
                <div class="form-control">
                    <a class="spot-button activ {{ activPersonForm.$valid || 'button-disable'}}" href="javascript:;" ng-click="registration(user, activPersonForm.$valid)">
                        <?php echo Yii::t('user', 'Activate spot'); ?>
                    </a>
                    <span class="right soc-link">
                        <a href="/service/social?service=facebook" class="i-soc-fac">&#xe000;</a>
                        <a href="/service/social?service=twitter" class="i-soc-twi">&#xe001;</a>
                        <a href="/service/social?service=google_oauth" class="i-soc-goo">&#xe002;</a>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>
