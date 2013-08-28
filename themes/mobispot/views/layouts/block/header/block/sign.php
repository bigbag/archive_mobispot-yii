<div id="signInForm" ng-controller="UserCtrl" class="slide-box">
    <div  class="row">
        <div class="seven columns centered text-center">
            <h3 class="color"><?php echo Yii::t('user', 'Sign in'); ?></h3>
        </div>
        <a href="javascript:;" class="slide-box-close">&#xe00b;</a>
    </div>
    <div class="row">
        <div class="five columns centered">
            <form id="sign-in" name="signForm">
                <input
                    name='email'
                    type="email"
                    ng-model="user.email"
                    placeholder="<?php echo Yii::t('user', 'Email address'); ?>"
                    ui-keypress="{enter: 'login(user, signForm.$valid)'}"
                    autocomplete="off"
                    maxlength="300"
                    required >
                <input
                    name='password'
                    type="password"
                    ng-model="user.password"
                    placeholder="<?php echo Yii::t('user', 'Password'); ?>"
                    ui-keypress="{enter: 'login(user, signForm.$valid)'}"
                    autocomplete="off"
                    maxlength="300"
                    required >
                <a id="recPass" href="javascripts:;" class="form-link toggle-box">
                    <?php echo Yii::t('user', 'Forgot password?'); ?>
                </a>
           
                <div class="form-control">
                    <a 
                        class="spot-button login {{ signForm.$valid || 'button-disable'}}" 
                        href="javascript:;" 
                        ng-click="login(user, signForm.$valid)" 
                        >
                        <?php echo Yii::t('user', 'Sign in'); ?>
                    </a>
                    <span class="right soc-link">
                        <a href="/service/social?service=facebook">&#xe000;</a>
                        <a href="/service/social?service=twitter">&#xe001;</a>
                        <a href="/service/social?service=google_oauth">&#xe002;</a>
                    </span>
                </div>

            </form>
        </div>
    </div>
</div>