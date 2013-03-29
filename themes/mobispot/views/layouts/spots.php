<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" ng-app="mobispot" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8" ng-app="mobispot" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9" ng-app="mobispot" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" ng-app="mobispot" lang="en"> <!--<![endif]-->

<?php include('block/head.php');?>
<body>
<div class="content-wrapper" ng-controller="SpotCtrl" ng-init="spot.user=<?php echo Yii::app()->user->id;?>; spot.token='<?php echo Yii::app()->request->csrfToken?>'">
<?php include('block/header/spots.php');?>
<?php echo $content; ?>

</div>

<?php include('block/footer.php');?>
<?php include('block/script/all.php');?>
</body>
</html>