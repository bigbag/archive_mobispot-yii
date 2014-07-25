<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" class="ng-app"  ng-app="mobispot" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8" class="ng-app" ng-app="mobispot" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9" class="ng-app" ng-app="mobispot" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" ng-app="mobispot" lang="en"> <!--<![endif]-->

<?php include('block/head.php');?>
<body ng-init="payment.token='<?php echo Yii::app()->request->csrfToken;?>'; user.token='<?php echo Yii::app()->request->csrfToken;?>'">

<div class="content-wrapper content-payment" ng-controller="PaymentController">
  <?php include('block/header.php');?>
  <?php echo $content; ?>
</div>

<?php include('block/footer.php');?>
<?php include('block/script.php');?>
</body>
</html>
