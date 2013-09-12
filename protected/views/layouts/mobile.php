<!DOCTYPE html>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  	<meta http-equiv="Content-Type" content="text/html; charset=cp1251"/>
   	<title><?php echo Yii::app()->par->load('siteTitle'); ?></title>
   	
   	<link rel="icon" type="image/png" href="/themes/mobile/images/favicon16.png">
	<link rel="icon" type="image/png" href="/themes/mobile/images/favicon32.png">
	<link rel="icon" type="image/png" href="/themes/mobile/images/favicon48.png">

  	<meta name="viewport" content="width=device-width" />
  
  	<link rel="stylesheet" href="/themes/mobile/stylesheets/style.css">
	
	<?php Yii::app()->getClientScript()->registerScriptFile('https://maps.google.com/maps/api/js?key='.Yii::app()->eauth->services['google_oauth']['key'].'&sensor=true'); ?>
	<?php Yii::app()->getClientScript()->registerScriptFile('http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'); ?>
	<?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobile/js/mobile.js'); ?>
</head>
<body>
	<div class="content-wrapper bg-gray">
		<div class="spot-content_row">
			<?php echo $content; ?>
		</div>
	</div>
  <!-- Footer -->
  <footer class="footer-page">
	  <a href="#">
     	<span>Powered by</span> <img width="100" src="/themes/mobile/images/logo.png">
	  </a>
  </footer>
</body>
</html>
