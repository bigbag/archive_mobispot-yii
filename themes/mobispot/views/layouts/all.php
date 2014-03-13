<!DOCTYPE html>
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8" ng-app="mobispot" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9" ng-app="mobispot" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" ng-app="mobispot" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <title><?php echo Yii::app()->par->load('siteTitle'); ?></title>

    <meta  property="og:site_name" content="Mobispot"/>
    <meta  property="og:title" content="Mobispot - Wearable NFC devices"/>
    <meta  property="og:type" content="website"/>
    <meta  property="og:url" content="http://mobispot.com"/>
    <meta  property="og:image" content="http://mobispot.com/themes/mobispot/new/img/og.jpg"/>
    <meta  property="og:description" content="We create lovely NFC wristbands and make smart applications for them: payments, transportation, web sharing, secure ID, discounts and membership. "/>

    <link rel="icon" type="image/png" href="/themes/mobispot/img/favicon16.png">
    <link rel="icon" type="image/png" href="/themes/mobispot/img/favicon32.png">
    <link rel="icon" type="image/png" href="/themes/mobispot/img/favicon48.png">

    <!-- IE Fix for HTML5 Tags -->
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
    <link rel="stylesheet" href="/themes/mobispot/new/css/foundation3/foundation.min.css">
    <link rel="stylesheet" href="/themes/mobispot/new/css/foundation_actual/foundation.min.css" />
    <link rel="stylesheet" href="/themes/mobispot/new/css/style.css" />
    <link rel="stylesheet" href="/themes/mobispot/new/css/add.css" /> 

    <!--[if IE 8]>
        <html class="no-js lt-ie9" lang="en">
        <link rel="stylesheet" href="css/ie8.css">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <script src="/themes/mobispot/new/js/jquery.min.js"></script>
    <script src="/themes/mobispot/new/js/angular.min.js"></script>

</head>
<body ng-controller="UserController" 
    ng-cloak class="ng-cloak"
    ng-init="user.token='<?php echo Yii::app()->request->csrfToken ?>';action='none'">

    <?php include('block/head_new.php'); ?>

    <?php if ($this->mainBackground):?>
        <div class="main wallpaper" style="background-image: url(/themes/mobispot/new/img/<?php echo $this->mainBackground;?>)">
    <?php endif;?>
    <div ng-click="action='none'">
        <?php echo $content; ?>
    </div>
    <?php if ($this->mainBackground):?>
        </div>
    <?php endif;?>

    <footer class="footer-page content">
        <ul class="left">
            <li><a href="/readers"><?php echo Yii::t('footer', 'Readers') ?></a></li>
            <li><a href="/help"><?php echo Yii::t('footer', 'Get Help') ?></a></li>
            <!-- <li><a href="javascript:;">Email us</a></li> -->
            <!-- <li class="lang">
                <ul class="lang-list">
                    <li class="current-lang"><img src="/themes/mobispot/new/img/lang-icon_en.png">English</li>
                    <li><img src="/themes/mobispot/new/img/lang-icon_ru.png">Russian</li>
                    <li><img src="/themes/mobispot/new/img/lang-icon_it.png">Italian</li>
                    <li><img src="/themes/mobispot/new/img/lang-icon_ch.png">Chinese</li>
                </ul>
                <span class="current"><img src="/themes/mobispot/new/img/lang-icon_en.png"></span>
            </li> -->
        </ul>
        <ul class="soc-link right">
            <li><a class="icon" href="https://twitter.com/heymobispot">&#xe001;</a></li>
            <li><a class="icon" href="http://www.facebook.com/heyMobispot">&#xe000;</a></li>

        </ul>
    </footer>

    <script src="/themes/mobispot/new/js/jquery-ui.min.js"></script>
    <script src="/themes/mobispot/new/js/jquery.slides.js"></script>

    <script src="/themes/mobispot/new/js/angular-cookies.min.js"></script>
    <script src="/themes/mobispot/new/angular/app/app.js"></script>
    <script src="/themes/mobispot/new/angular/app/service.js"></script>
    <script src="/themes/mobispot/new/angular/app/controllers/user.js"></script>
    <script src="/themes/mobispot/new/angular/app/controllers/help.js"></script>
    <script src="/themes/mobispot/new/angular/app/controllers/phone.js"></script>
    <script src="/themes/mobispot/new/js/script-add.js"></script>
    <script src="/themes/mobispot/new/js/script.js"></script>
    <script src="/themes/mobispot/new/js/foundation.min.js"></script>
    <script>
        $(document).foundation();
    </script>
</body>
</html>
