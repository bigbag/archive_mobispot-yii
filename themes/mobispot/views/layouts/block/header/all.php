<header class="header-page">
    <div class="hat-bar content">
        <h1 class="logo">
            <a href="/">
                <img itemprop="logo" alt="Mobispot" src="/themes/mobispot/img/logo_x2.png">
            </a>
        </h1>
        <ul class="right">
            <li>
            <?php if (Yii::app()->controller->action->id == 'demoKit'): ?>
                <span class="right-menu">
                <?php echo Yii::t('general', 'Get our demo-kit') ?>
                </span>
            </li>
            <?php else: ?>
                <a href="/pages/demoKit" class="show">
                    <?php echo Yii::t('general', 'Get our demo-kit') ?>
                </a>
            </li>
            <?php endif; ?>
            <?php if (Yii::app()->user->isGuest): ?>
            <li>
                <a ng-click="modal=(modal != 'activation')?'activation':'none'"
                    ng-class="{active: (modal=='activation')}">
                    <?php echo Yii::t('general', 'Activate spot') ?>
                </a>
            </li>
            <li>
                <a ng-click="modal=(modal != 'sign')?'sign':'none'"
                    ng-class="{active: (modal=='sign')}">
                    <?php echo Yii::t('general', 'Sign in') ?>
                </a>
            </li>
            <?php else: ?>
            <li>
                <a href="/spot/list/" class="show">
                    <?php echo Yii::t('general', 'My Spots') ?>
                </a>
            </li>
            <li>
                <a href="/service/logout/" class="show">
                <?php echo Yii::t('general', 'Sign Out') ?>
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
    <?php if (Yii::app()->user->isGuest):?>
    <div id="sign" class="show-block" ng-class="{active: (modal=='sign')}">
        <div class="form-block">
            <form name="loginForm" class="colum-form custom">
                <div class="wrapper check">
                    <input
                        type="email"
                        ng-model="user.email"
                        placeholder="<?php echo Yii::t('user', 'Email address'); ?>"
                        ng-keypress="($event.keyCode == 13)?login(user, loginForm.$valid):''"
                        maxlength="300"
                        ng-class="{error: error.email}"
                        required>
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
                        ng-class="{error: error.email}"
                        required >

                    <span class="f-hint">
                        <a ng-show="loginForm.password.$error.required || error.email"
                            ng-click="modal=(modal != 'forgot')?'forgot':'none'">
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
                            <img src='/themes/mobispot/img/google-i_x2.png'>
                        </a>
                        <a href="/service/social?service=twitter">
                            <img src='/themes/mobispot/img/twi-i_x2.png'>
                        </a>
                        <a href="/service/social?service=facebook">
                            <img src='/themes/mobispot/img/fb-i_x2.png'>
                        </a>
                    </div>
                </footer>
            </form>
        </div>
    </div>
    <div id="activation" class="show-block" ng-class="{active: (modal=='activation')}">
        <div class="form-block">
            <form class="colum-form custom" name="activForm">
                <div class="wrapper check">
                     <input
                        name='email'
                        type="email"
                        ng-model="user.email"
                        placeholder="<?php echo Yii::t('user', 'E-mail') ?>"
                        ng-keypress="($event.keyCode == 13)?activation(user, activForm.$valid):''"
                        autocomplete="off"
                        maxlength="300"
                        ng-class="{error: error.email}"
                        required >
                    <span class="f-hint" ng-show="error.email">
                        {{error.content}}
                    </span>
                </div>
                <div class="wrapper">
                    <input name='password'
                        type="password"
                        ng-model="user.password"
                        ng-keypress="($event.keyCode == 13)?activation(user, activForm.$valid):''"
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
                        ng-keypress="($event.keyCode == 13)?activation(user, activForm.$valid):''"
                        placeholder="<?php echo Yii::t('user', 'Spot activation code') ?>"
                        autocomplete="off"
                        maxlength="10"
                        ng-minlength="10";
                        ng-maxlength="10"
                        ng-class="{error: error.code}"
                        required >
                    <span class="f-hint" ng-show="error.code">
                        {{error.content}}
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
                        ng-click="activation(user, activForm.$valid)"
                        href="javascript:;">
                        <?php echo Yii::t('user', 'Activate spot'); ?>
                    </a>
                    <div class="soc-login right">
                        <a href="/service/social?service=google_oauth">
                            <img src='/themes/mobispot/img/google-i_x2.png'>
                        </a>
                        <a href="/service/social?service=twitter">
                            <img src='/themes/mobispot/img/twi-i_x2.png'>
                        </a>
                        <a href="/service/social?service=facebook">
                            <img src='/themes/mobispot/img/fb-i_x2.png'>
                        </a>
                    </div>
                </footer>
            </form>
        </div>
    </div>
    <div id="forgot" class="show-block" ng-class="{active: (modal=='forgot')}">
        <div class="form-block">
            <form class="colum-form custom" name="recoveryForm">
            <label class="h-label" for="forgotPass">
                <?php echo Yii::t('user', 'Forgot password?'); ?>
            </label>
                <div class="wrapper check">
                    <input
                        name='email'
                        type="text"
                        ng-model="user.email"
                        placeholder="<?php echo Yii::t('user', 'E-mail') ?>"
                        ng-keypress="($event.keyCode == 13)?recovery(user, recoveryForm.$valid):''"
                        autocomplete="off"
                        maxlength="300"
                        ng-class="{error: error.email}"
                        ng-pattern="/@+/"
                        required >
                    <span class="f-hint" ng-show="error.email">
                        {{error.content}}
                    </span>
                </div>
                <footer class="form-footer">
                    <a class="left form-button"
                        ng-click="recovery(user, recoveryForm.$valid)">
                        <?php echo Yii::t('user', 'Send') ?>
                    </a>
                </footer>
            </form>
        </div>
    </div>
    <?php endif;?>
    <div id="message" class="show-block b-message" ng-class="{active: (modal=='message')}">
        <p>{{result.message}}
        </p>
    </div>
</header>
