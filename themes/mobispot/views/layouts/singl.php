<!DOCTYPE html>
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8" ng-app="mobispot" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9" ng-app="mobispot" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" ng-app="mobispot" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <title><?php echo Yii::app()->params['siteTitle']; ?></title>

    <link rel="icon" type="image/png" href="/themes/mobispot/images/favicon16.png">
    <link rel="icon" type="image/png" href="/themes/mobispot/images/favicon32.png">
    <link rel="icon" type="image/png" href="/themes/mobispot/images/favicon48.png">

    <link rel="stylesheet" href="/themes/mobispot/css/all.min.css" />

    <!--[if IE 8]>
        <html class="no-js lt-ie9" lang="en">
        <link rel="stylesheet" href="css/ie8.css">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <script src="/themes/mobispot/js/jquery.min.js"></script>
    <script src="/themes/mobispot/js/angular.min.js"></script>

</head>
<body class="ofert-page">
    <?php echo $content; ?>

    <script src="/themes/mobispot/js/angular-cookies.min.js"></script>
    <script>angular.module('mobispot', ['ngCookies']);</script>
    <script src="/themes/mobispot/angular/app/service.js"></script>
    <?php echo $this->blockFooterScript; ?>
    <script>$(document).foundation();</script>

</body>
</html>
