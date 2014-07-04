<div class="wrapper" ng-controller="UserController" ng-init="user.token='<?php echo Yii::app()->request->csrfToken; ?>'">
    <header>
        <h1><a href="/"><img width="140" src="/themes/mobispot/img/logo_x2.png"></a></h1>
        <a class="full-size" href="http://mobispot.com"><i class="icon">&#xf108;</i><?php echo Yii::t('spot', 'Full size version'); ?></a>
    </header>
    <section class="content author tabs">
        <nav>
            <a class="active" href="javascript:;"><?php echo Yii::t('user', 'Sign in'); ?></a>
            <a href="javascript:;"><?php echo Yii::t('user', 'Register spot'); ?></a>
        </nav>
        <section class="author-block tabs-content">
            <article class="active">
                <form name="loginForm">
                    <input
                        name='email'
                        type="email"
                        ng-model="user.email"
                        placeholder="<?php echo Yii::t('user', 'Email address'); ?>"
                        ng-keypress="($event.keyCode == 13)?login(user, loginForm.$valid):''"
                        maxlength="300"
                        ng-class="{error: error.email}"
                        required
                    >
                    <input
                        name='password'
                        type="password"
                        ng-model="user.password"
                        placeholder="<?php echo Yii::t('user', 'Password'); ?>"
                        ng-keypress="($event.keyCode == 13)?login(user, loginForm.$valid):''"
                        maxlength="300"
                        ng-class="{error: error.email}"
                        required
                    >
                    <a class="form-link" href="#b_forgot"><?php echo Yii::t('user', 'Forgot password?'); ?></a>
                        <div class="soc-login">
                        <p><?php echo Yii::t('user', 'login with'); ?></p>
                            <a href="/service/social?service=google_oauth"><img src='/themes/mobile/images/icons/google-i_x2.png'></a>
                            <a href="/service/social?service=twitter"><img src='/themes/mobile/images/icons/twi-i_x2.png'></a>
                            <a href="/service/social?service=facebook"><img src='/themes/mobile/images/icons/fb-i_x2.png'></a>
                        </div>
                    <a class="form-button" href="javascript:;" ng-click="login(user, loginForm.$valid)"><?php echo Yii::t('user', 'Enter'); ?></a>
                </form>
            </article>
            <article>
                <form name="activForm">
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
                    <input name='password'
                        type="password"
                        ng-model="user.password"
                        ng-keypress="($event.keyCode == 13)?activation(user, activForm.$valid):''"
                        placeholder="<?php echo Yii::t('user', 'Password') ?>"
                        autocomplete="off"
                        maxlength="300"
                        required >
                    <div class="checkbox">
                        <input
                            id="formReg_agree"
                            type="checkbox"
                            name="formReg_agree"
                            ng-model="user.terms"
                            ng-true-value="1"
                            ng-false-value="0"
                        >
                        <label for="formReg_agree"><?php echo Yii::t('user', 'I agree to Terms and Conditions'); ?></label>
                    </div>
                    <a
                        class="form-button"
                        ng-click="activation(user, activForm.$valid)"
                        href="javascript:;"
                    >
                    <?php echo Yii::t('user', 'Activate spot'); ?>
                    </a>
                </form>
            </article>
        </section>
    </section>
    <div class="fc"></div>
</div>
