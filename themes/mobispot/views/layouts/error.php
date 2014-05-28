<!DOCTYPE html>
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8" ng-app="mobispot" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9" ng-app="mobispot" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" ng-app="mobispot" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <title><?php echo Yii::app()->params['siteTitle']; ?></title>

    <link rel="icon" type="image/png" href="/themes/mobispot/img/favicon16.png">
    <link rel="icon" type="image/png" href="/themes/mobispot/img/favicon32.png">
    <link rel="icon" type="image/png" href="/themes/mobispot/img/favicon48.png">

    <!-- IE Fix for HTML5 Tags -->
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="/themes/mobispot/css/foundation3/foundation.min.css">
    <link rel="stylesheet" href="/themes/mobispot/css/foundation_actual/foundation.min.css" />
    <link rel="stylesheet" href="/themes/mobispot/css/style.css" />
    <link rel="stylesheet" href="/themes/mobispot/css/add.css" />
    <script src="/themes/mobispot/js/jquery.min.js"></script>
    <script src="/themes/mobispot/js/angular.min.js"></script>

</head>
<body >
    <div class="main error-page ng-cloak" ng-cloak>
        <div class="header-page">
            <div class="hat-bar content">
                <h1 class="logo">
                    <a href="/">
                        <img itemprop="logo" alt="Mobispot" src="/themes/mobispot/img/logo_x2.png">
                    </a>
                </h1>
            </div>
        </div>
        <?php echo $content; ?>
    </div>
    <script src="/themes/mobispot/js/angular-cookies.min.js"></script>
    <script src="/themes/mobispot/angular/app/app.js"></script>
    <script src="/themes/mobispot/angular/app/service.js"></script>
    <?php echo $this->blockFooterScript; ?>
</body>
</html>
