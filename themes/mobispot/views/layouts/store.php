<!DOCTYPE html>
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8" ng-app="mobispot" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9" ng-app="mobispot" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" ng-app="mobispot" lang="en"> <!--<![endif]-->
<head>
    <?php include('block/head/all.php'); ?>
</head>

    <body ng-controller="ProductController"
        ng-cloak class="ng-cloak"
        ng-init="user.token='<?php echo Yii::app()->request->csrfToken ?>';modal='none'"
        >
    
        <?php include('block/header/all.php'); ?>
        
        <div class="row">
            <div class="large-12 columns singlebox-margin">
            <?php echo $content; ?>
            </div>
        </div>

        <div class="m-preload-store m-cover-preload">
            <img src="/themes/mobispot/images/mobispot-loading%2040.gif">
        </div>

        <?php include('block/footer/all.php'); ?>
        <div class="m-result">
            <p></p>
        </div>
        <?php include('block/script/store.php'); ?>
    </body>
</html>
