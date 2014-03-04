<div class="header-page">
    <div class="hat-bar content">
        <h1 class="logo">
            <a href="/">
                <img itemprop="logo" alt="Mobispot" src="/themes/mobispot/new/images/logo_x2.png"> 
            </a>
        </h1>
        <ul class="right">
            <?php if (Yii::app()->user->isGuest): ?>
            <li><a class="show" href="#b_signIn" 
                    ng-click="action=(action != 'sign')?'sign':'none'">
                <?php echo Yii::t('menu', 'Sign in') ?>
            </a></li>
            <li><a class="show" href="#b_regSpot" 
                    ng-click="action=(action != 'activation')?'activation':'none'">
                <?php echo Yii::t('menu', 'Activate spot') ?>
            </a></li>
            <?php else: ?>
            <li><a class="show" href="/user/personal/">
                <?php echo Yii::t('menu', 'My Spots') ?>
            </a></li>
            <li><a class="show" href="/service/logout/">
                <?php echo Yii::t('menu', 'Logout') ?>
            </a></li>
            <?php endif; ?>
        </ul>
    </div>
    <div id="b_signIn" class="show-block">
        <div class="form-block">
            <form name="loginForm" class="colum-form custom">
                <div class="wrapper check"> 
                    <input
                        type="email"
                        ng-model="user.email"
                        placeholder="<?php echo Yii::t('user', 'Email address'); ?>"
                        ng-keypress="($event.keyCode == 13)?login(user, loginForm.$valid):''"
                        maxlength="300"
                        required >
                        <span class="f-hint" ng-show="error.email">
                            {{error.content}}
                        </span>
                </div>
                <div class="wrapper help"> 
                    <input name='password'
                        type="password"
                        ng-model="user.password"
                        placeholder="<?php echo Yii::t('user', 'Password'); ?>"
                        ng-keypress="($event.keyCode == 13)?login(user, loginForm.$valid):''"
                        maxlength="300"
                        required >

                    <span class="f-hint">
                        <a class="show" href="#b_forgot"
                            ng-show="loginForm.password.$error.required || error.email"
                            ng-click="action=(action != 'forgot')?'forgot':'none'">
                            <?php echo Yii::t('user', 'Forgot password?'); ?>
                        </a>
                    </span>
                </div>  
                <footer class="form-footer">
                    <a href="#"
                        class="left form-button" 
                        ng-click="login(user, loginForm.$valid)">
                        <?php echo Yii::t('user', 'Sign in'); ?>
                    </a>
                    <div class="soc-login right">
                        <a href="/service/social?service=google_oauth">
                            <img src='/themes/mobispot/new/images/google-i_x2.png'>
                        </a>
                        <a href="/service/social?service=twitter">
                            <img src='/themes/mobispot/new/images/twi-i_x2.png'>
                        </a>
                        <a href="/service/social?service=facebook">
                            <img src='/themes/mobispot/new/images/fb-i_x2.png'>
                        </a>
                    </div>
                </footer>
            </form>
        </div>
    </div>
    <div id="b_regSpot" class="show-block">
        <div class="form-block">
            <form class="colum-form custom" name="activForm">
                <div class="wrapper check">
                     <input
                        name='email'
                        type="email"
                        ng-model="user.email"
                        placeholder="<?php echo Yii::t('user', 'E-mail') ?>"
                        autocomplete="off"
                        maxlength="300"
                        required >
                    <span class="f-hint" ng-show="error.activ.email">
                        <?php echo Yii::t('user', 'Check your email spelling'); ?>
                    </span>
                </div>
                <div class="wrapper">
                    <input name='password'
                        type="password"
                        ng-model="user.password"
                        placeholder="<?php echo Yii::t('user', 'Password') ?>"
                        autocomplete="off"
                        maxlength="300"
                        required >
                </div>
                <div class="wrapper">
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
                    <span class="f-hint" ng-show="error.activ.code">
                        <?php echo Yii::t('user', 'You`ve made a mistake in spot activation code'); ?>
                    </span>
                </div>
                <div class="checkbox">  
                <input 
                    id="formReg_agree" 
                    type="checkbox" 
                    name="formReg_agree" 
                    ng-model="user.terms"
                    ng-true-value="1"
                    ng-false-value="0">  
                    <label for="formReg_agree"><?php echo Yii::t('user', 'I agree to Terms and Conditions'); ?></label>  
                </div>
                <footer class="form-footer">
                    <a class="left form-button" 
                        ng-click="activation(user, activPersonForm.$valid)"
                        href="javascript:;">
                        <?php echo Yii::t('user', 'Activate spot'); ?>
                    </a>
                    <div class="soc-login right">
                        <a href="/service/social?service=google_oauth">
                            <img src='/themes/mobispot/new/images/google-i_x2.png'>
                        </a>
                        <a href="/service/social?service=twitter">
                            <img src='/themes/mobispot/new/images/twi-i_x2.png'>
                        </a>
                        <a href="/service/social?service=facebook">
                            <img src='/themes/mobispot/new/images/fb-i_x2.png'>
                        </a>
                    </div>
                </footer>
            </form>
        </div>
    </div>
    <div id="b_forgot" class="show-block">
        <div class="form-block">
            <form class="colum-form custom" name="recoveryForm">
            <label class="h-label" for="forgotPass">
                <?php echo Yii::t('user', 'Forgot password?'); ?>
            </label>
                <div class="wrapper check">
                    <input
                        name='email'
                        type="email"
                        ng-model="user.email"
                        placeholder="<?php echo Yii::t('user', 'E-mail') ?>"
                        ng-keypress="($event.keyCode == 13)?recovery(user, recoveryForm.$valid):''"
                        autocomplete="off"
                        maxlength="300"
                        required >
                    <span class="f-hint" ng-show="error.email">
                        {{error.content}}
                    </span>
                </div>
                <footer class="form-footer">
                    <a class="left form-button show"
                        ng-click="recovery(user, recoveryForm.$valid)">
                        <?php echo Yii::t('user', 'Send') ?>
                    </a>
                </footer>
            </form>
        </div>
    </div>
    <div id="b_message" class="show-block b-message">
            <p>A letter with instructions has been sent <br>
                to your email address
            </p>
    </div>
</div>