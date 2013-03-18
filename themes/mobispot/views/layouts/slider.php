<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en" ng-app="mobispot" ng-csp> <![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8" lang="en" ng-app="mobispot" ng-csp> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en" ng-app="mobispot" ng-csp> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" ng-app="mobispot" ng-csp> <!--<![endif]-->

<?php include('block/head.php');?>
<body>
<div class="content-wrapper">
	<?php include('block/header/slider.php');?>
	<?php echo $content; ?>
</div>

<?php include('block/footer.php');?>
<?php include('block/script.php');?>
</body>
</html>
