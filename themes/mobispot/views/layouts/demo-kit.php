<!DOCTYPE html>
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8" ng-app="mobispot" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9" ng-app="mobispot" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" ng-app="mobispot" lang="en"> <!--<![endif]-->
<head>
    <?php $this->blockHeaderCeo = true;?>
    <?php include('block/head/all.php'); ?>
</head>
<body ng-controller="UserController"
    ng-cloak class="ng-cloak"
    ng-init="user.token='<?php echo Yii::app()->request->csrfToken ?>';modal='none'"
    >
    
    <?php if (!empty($this->casingClass)): ?>
        <div class="<?php echo $this->casingClass; ?>">
    <?php endif; ?>
    
        <?php include('block/header/all.php'); ?>
        <div ng-click="hideModal()">
            <?php echo $content; ?>
        </div>
        
    <?php include('block/footer/page.php'); ?>
    <?php include('block/script/all.php'); ?>
    <script>
        $(document).foundation();
    </script>
    <?php if (!empty($this->casingClass)): ?>
        </div>
    <?php endif; ?>
    
</body>
</html>
