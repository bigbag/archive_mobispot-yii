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
<body >
    <div class="main error-page">
        <div class="header-page">
            <div class="hat-bar content">
                <h1 class="logo">
                    <a href="/">
                        <img itemprop="logo" alt="Mobispot" src="/themes/mobispot/new/images/logo_x2.png"> 
                    </a>
                </h1>
            </div>
        </div>
        <?php echo $content; ?>
    </div>
</body>
</html>