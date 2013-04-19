<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" ng-app="mobispot" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8" ng-app="mobispot" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9" ng-app="mobispot" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" ng-app="mobispot" lang="en"> <!--<![endif]-->

<?php include('block/head.php');?>
<body class="overflow-h" ng-init="user.token='<?php echo Yii::app()->request->csrfToken?>'">
<div class="content-wrapper">
	<?php include('block/header/all.php');?>
	<div class="row">
			<div class="twelve columns singlebox-margin">
				<?php echo $content; ?>
		</div>
	</div>
</div>

<?php include('block/footer/all.php');?>

<div class="m-preload-store m-cover-preload">
	<img src="/themes/mobispot/images/mobispot-loading%2040.gif">
</div>
<?php include('block/script/store.php');?>
</body>
</html>
