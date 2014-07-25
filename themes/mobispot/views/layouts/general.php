<!DOCTYPE html>
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8" ng-app="mobispot" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9" ng-app="mobispot" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" ng-app="mobispot" lang="en"> <!--<![endif]-->
<head>
    <?php include('block/head/all.php'); ?>
</head>
    <body ng-controller="UserController"
        class="splash"
        ng-cloak class="ng-cloak"
        ng-init="user.token='<?php echo Yii::app()->request->csrfToken ?>';modal='none'">
        <p style="display: block; height: 0; overflow: hidden; visibility: hidden; position: absolute;">We create lovely NFC wristbands and make smart applications for them: payments, transportation, web sharing, secure ID, discounts and membership.</p>
        <?php include('block/header/all.php'); ?>
        <div ng-click="modal='none'">
            <?php echo $content; ?>
        </div>
    <?php include('block/script/all.php'); ?>
    </body>
</html>
