<!DOCTYPE html>
<html ng-app="mobispot">
<head>
    <meta charset="utf-8">
        <title><?php echo Yii::app()->params['siteTitle']; ?></title>

    <link rel="icon" type="image/png" href="/themes/mobispot/images/favicon16.png">
    <link rel="icon" type="image/png" href="/themes/mobispot/images/favicon32.png">
    <link rel="icon" type="image/png" href="/themes/mobispot/images/favicon48.png">

    <link rel="stylesheet" href="/themes/mobispot/css/reset.css" />
    <link rel="stylesheet" href="/themes/mobispot/css/foundation_actual/foundation.min.css" />
    <link rel="stylesheet" href="/themes/mobispot/css/front-page-slider.css" />
    <link rel="stylesheet" href="/themes/mobispot/css/style.css">

    <script src="/themes/mobispot/js/jquery.min.js"></script>
    <script src="/themes/mobispot/js/angular.min.js"></script>
    <script src="/themes/mobispot/js/jquery-ui.min.js"></script>
    <script src="/themes/mobispot/js/jquery.easing.1.3.js"></script>
    <script src="/themes/mobispot/js/jquery.animate-enhanced.min.js"></script>
    <script src="/themes/mobispot/js/scrollIt.min.js"></script>
    <script src="/themes/mobispot/js/script.js" ></script>
    
    <script src="/themes/mobispot/js/angular-cookies.min.js"></script>
    <script>angular.module('mobispot', ['ngCookies']);</script>
    <script src="/themes/mobispot/angular/app/app.js"></script>
    <script src="/themes/mobispot/angular/app/service.js"></script>
    <script src="/themes/mobispot/angular/modules/sortable/sortable.js"></script>
    
    <script src="/themes/mobispot/angular/app/controllers/user.js"></script>
    <script src="/themes/mobispot/angular/app/controllers/main.js"></script>
    <script src="/themes/mobispot/angular/app/controllers/slide.js"></script>
</head>
    <body class="splash" ng-controller="UserController" ng-init="user.token='<?php echo Yii::app()->request->csrfToken ?>';modal='none'">
        <header class="header-page">
        <div class="hat-bar content">
            <h1 class="logo">
            <a href="/"><img itemprop="logo" alt="Mobispot" src="/themes/mobispot/img/logo_x2.png"></a>
                
            </h1>
            <ul class="right">
            <?php if (Yii::app()->user->isGuest): ?>
                <li><a class="show" href="#b_signIn"><?php echo Yii::t('user', 'Sign in'); ?></a></li>
                <li><a class="show" href="#b_regSpot"><?php echo Yii::t('general', 'Activate spot') ?></a></li>
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
                        ng-class="{error: error.email}"
                        required>
                        <span class="f-hint" ng-show="error.email">{{error.content}}</span>
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
                        <span class="f-hint"><a class="show" href="#b_forgot"><?php echo Yii::t('user', 'Forgot password?'); ?></a></span>
                    </div>
                    <footer class="form-footer">
                        <a class="left form-button" href="#" ng-click="login(user, loginForm.$valid)"><?php echo Yii::t('user', 'Sign in'); ?></a>
                        <div class="soc-login right">
                            <a href="/service/social?service=google_oauth"><img src='/themes/mobispot/img/google-i_x2.png'></a>
                            <a href="/service/social?service=twitter"><img src='/themes/mobispot/img/twi-i_x2.png'></a>
                            <a href="/service/social?service=facebook"><img src='/themes/mobispot/img/fb-i_x2.png'></a>
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
                        ng-keypress="($event.keyCode == 13)?activation(user, activForm.$valid):''"
                        autocomplete="off"
                        maxlength="300"
                        ng-class="{error: error.email}"
                        required >
                        <span class="f-hint" ng-show="error.email">{{error.content}}</span>
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
                        <span class="f-hint"></span>
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
                        <a class="left form-button" href="#" ng-click="activation(user, activForm.$valid)"><?php echo Yii::t('user', 'Activate spot'); ?></a>
                    </footer>
                </form>
            </div>
        </div>
        <div id="b_forgot" class="show-block">
            <div class="form-block">
                <form class="colum-form custom">
                    <p class="sub-txt">
                            You can change your password following the instructions in a special email from us. Please click the button below to proceed.
                    </p>
                    <div class="wrapper check">
                        <input id="forgotPass" type="text" placeholder="Email">
                        <span class="f-hint hide">Сheck your email spelling</span>
                    </div>
                    <footer class="form-footer">
                        <a class="left form-button show" href="#b_message">Send</a>
                    </footer>
                </form>
            </div>
        </div>
        <div id="b_message" class="show-block b-message">
                <p>A letter with instructions has been sent <br>
                    to your email address
                </p>
        </div>
    </header>
        <?php echo $content; ?>
        <script>
        $(function(){
            $.scrollIt();
        });
        </script>
    </body>
</html>
