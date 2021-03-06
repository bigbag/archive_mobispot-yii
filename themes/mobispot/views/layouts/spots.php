<!DOCTYPE html>
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8" ng-app="mobispot" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9" ng-app="mobispot" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" ng-app="mobispot" lang="en"> <!--<![endif]-->
<head>
    <?php $this->blockHeaderCeo = true;?>
    <?php include('block/head/spots.php'); ?>
</head>
<body ng-controller="UserController"
    ng-cloak class="ng-cloak"
    ng-init="user.token='<?php echo Yii::app()->request->csrfToken ?>';modal='none'"
    <?php if ($this->mainBackground):?>
    style="background-image: url(/themes/mobispot/img/<?php echo $this->mainBackground;?>)"
    <?php endif;?>
    >
    <div class="main spot">
        <?php include('block/header/spots.php'); ?>
        <?php echo $content; ?>
    </div>

    <?php include('block/footer/spots.php'); ?>
    <?php include('block/script/spots.php'); ?>
    <div id="dialog-confirm" style="display:none" title="<?php echo Yii::t('spot', 'Подтвердите действие'); ?>">
      <p><span id="dialog-question"></span></p>
    </div>
</body>
</html>
