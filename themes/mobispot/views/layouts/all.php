<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<?php include('block/head.php');?>
<body  ng-app="mobispotApp">
<div class="content-wrapper">
	<?php include('block/header/all.php');?>
	<div class="row">
			<div class="twelve columns singlebox-margin">
				<?php echo $content; ?>
		</div>
	</div>
</div>

<?php include('block/footer.php');?>
<?php include('block/script.php');?>
</body>
</html>
