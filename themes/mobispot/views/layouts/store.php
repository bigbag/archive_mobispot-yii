<!DOCTYPE html>
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8" ng-app="mobispot" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9" ng-app="mobispot" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" ng-app="mobispot" lang="en"> <!--<![endif]-->
<head>
    <?php $this->blockHeaderCeo = true;?>
    <?php include('block/head/store.php'); ?>
</head>
<body ng-controller="UserController"
    ng-cloak class="ng-cloak"
    ng-init="user.token='<?php echo Yii::app()->request->csrfToken ?>';modal='none'"
    <?php if ($this->mainBackground):?>
    style="background-image: url(/themes/mobispot/img/<?php echo $this->mainBackground;?>)"
    <?php endif;?>
    >
    <div class="main spot spot-all">
        <?php include('block/header/all.php'); ?>
        <div ng-click="hideModal()">
            <?php echo $content; ?>
        </div>
    </div>

    <?php include('block/footer/all.php'); ?>
    <?php include('block/script/store.php'); ?>

</body>
</html>
