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

    <script src="/themes/mobispot/new/js/jquery.min.js"></script>
    <script src="/themes/mobispot/new/js/angular.min.js"></script>
    <script src="/themes/mobispot/new/js/jquery.slides.js"></script>

    <script src="/themes/mobispot/new/js/angular-animate.min.js"></script>
    <script src="/themes/mobispot/new/angular/app/app.js"></script>
    <script src="/themes/mobispot/new/angular/app/controllers/user.js"></script>
    <script src="/themes/mobispot/new/angular/app/controllers/help.js"></script>
    <script src="/themes/mobispot/new/angular/app/controllers/phone.js"></script>
    <script src="/themes/mobispot/new/js/script-add.js"></script>
    <script src="/themes/mobispot/new/js/script.js"></script>

    <script>document.cookie='resolution='+Math.max(screen.width,screen.height)+'; path=/';</script>
</head>
<body ng-controller="UserController" 
    ng-cloak class="ng-cloak"
    ng-init="user.token='<?php echo Yii::app()->request->csrfToken ?>';action='none'">

    <?php include('block/head_new.php'); ?>

    <?php if ($this->mainBackground):?>
        <div class="main" style="background-image: url(/themes/mobispot/new/images/<?php echo $this->main_background;?>)">
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
                    <li class="current-lang"><img src="/themes/mobispot/new/images/lang-icon_en.png">English</li>
                    <li><img src="/themes/mobispot/new/images/lang-icon_ru.png">Russian</li>
                    <li><img src="/themes/mobispot/new/images/lang-icon_it.png">Italian</li>
                    <li><img src="/themes/mobispot/new/images/lang-icon_ch.png">Chinese</li>
                </ul>
                <span class="current"><img src="/themes/mobispot/new/images/lang-icon_en.png"></span>
            </li> -->
        </ul>
        <ul class="soc-link right">
            <li><a class="icon" href="https://twitter.com/heymobispot">&#xe001;</a></li>
            <li><a class="icon" href="http://www.facebook.com/heyMobispot">&#xe000;</a></li>

        </ul>
    </footer>
    
    <script src="/themes/mobispot/new/js/foundation.min.js"></script>
    <script>
        $(document).foundation();
    </script>
</body>
</html>
