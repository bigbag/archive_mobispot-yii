<!DOCTYPE html>
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8" ng-app="mobispot" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9" ng-app="mobispot" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" ng-app="mobispot" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <title><?php echo Yii::app()->par->load('siteTitle'); ?></title>

    <link rel="icon" type="image/png" href="/themes/mobispot/images/favicon16.png">
    <link rel="icon" type="image/png" href="/themes/mobispot/images/favicon32.png">
    <link rel="icon" type="image/png" href="/themes/mobispot/images/favicon48.png">

    <!-- IE Fix for HTML5 Tags -->
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
    <link rel="stylesheet" href="/themes/mobispot/new/css/reset.css">
    <link rel="stylesheet" href="/themes/mobispot/new/css/foundation.css" />
    <link rel="stylesheet" href="/themes/mobispot/new/css/style.css" />
    <link rel="stylesheet" href="/themes/mobispot/new/css/add.css" />
    
</head>
<body ng-controller="UserController" 
    ng-init="user.token='<?php echo Yii::app()->request->csrfToken ?>';action='none'">

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
    <div ng-click="action='none'">
        <ul id="slides" class="slides-container">
            <li style="background-image:url(/themes/mobispot/new/images/m11.jpg); ">
                <div class="container">
                    <h1>Connect<br> digital & real </h1>
                    <p>

                        Share your links & proﬁles easily.<br>
                        Be rewarded in real life for your<br>
                        Likes & Tweets on the web
                    </p>
                </div>
            </li>
            <li style="background-image:url(/themes/mobispot/new/images/m21.jpg);">
                <div class="container blue">
                    <h1>
                        Pay with<br>
                        a single tap
                    </h1>
                    <p>
                        Get rid of coins. Make purchase<br>
                        with real money or corporate one
                    </p>
                </div>
            </li>
            <li style="background-image:url(/themes/mobispot/new/images/m31.jpg);">
                <div class="container">
                    <h1>
                        Make it an<br>
                        easy ride
                    </h1>
                    <p>
                        Store tickets inside your spot. <br>
                        You will not lose or forget<br>
                        them anymore
                    </p>
                </div>
            </li>
            <li style="background-image:url(/themes/mobispot/new/images/m41.jpg);">
                <div class="container blue">
                    <h1>
                        Sign in faster
                    </h1>
                    <p>
                        Be recognized with a tap.<br>
                        Get rewards, discounts and <br>
                        personal services even faster

                    </p>
                </div>
            </li>
        </ul>
    </div>
    <div class="slides-navigation">
        <a class="next" onclick="$('.slidesjs-next').click();">&#xe603;</a>
        <a class="prev" onclick="$('.slidesjs-previous').click();">&#xe602;</a>
    </div>
    <footer class="footer-page content">
        <ul class="left">
            <li><a href="javascript:;">Phones</a></li>
            <li><a href="javascript:;">Get Help</a></li>
            <li><a href="javascript:;">Email us</a></li>
            <li class="lang">
                <ul class="lang-list">
                    <li class="current-lang"><img src="/themes/mobispot/new/images/lang-icon_en.png">English</li>
                    <li><img src="/themes/mobispot/new/images/lang-icon_ru.png">Russian</li>
                    <li><img src="/themes/mobispot/new/images/lang-icon_it.png">Italian</li>
                    <li><img src="/themes/mobispot/new/images/lang-icon_ch.png">Chinese</li>
                </ul>
                <span class="current"><img src="/themes/mobispot/new/images/lang-icon_en.png"></span>
            </li>
        </ul>
        <ul class="soc-link right">
            <li><a class="icon" href="javascript:;">&#xe001;</a></li>
            <li><a class="icon" href="javascript:;">&#xe000;</a></li>

        </ul>
    </footer>
<script src="/themes/mobispot/new/js/jquery.min.js"></script>
<script src="/themes/mobispot/new/js/angular.min.js"></script>
<script src="/themes/mobispot/new/js/jquery.slides.js"></script>

<script src="/themes/mobispot/new/js/angular-animate.min.js"></script>
<script src="/themes/mobispot/new/angular/app/app.js"></script>
<script src="/themes/mobispot/new/angular/app/controllers/user.js"></script>
<script src="/themes/mobispot/new/js/script-add.js"></script>
<script src="/themes/mobispot/new/js/script.js"></script>
</body>
</html>
