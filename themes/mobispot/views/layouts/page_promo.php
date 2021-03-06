<!DOCTYPE html>
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8" ng-app="mobispot" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9" ng-app="mobispot" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" ng-app="mobispot" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <?php if (!empty($this->pageTitle)): ?>
        <title><?php echo $this->pageTitle; ?></title>
    <?php endif; ?>
    
    <link rel="icon" type="image/png" href="themes/mobispot/images/favicon16.png">
    <link rel="icon" type="image/png" href="themes/mobispot/images/favicon32.png">
    <link rel="icon" type="image/png" href="themes/mobispot/images/favicon48.png">

    <link rel="stylesheet" href="themes/mobispot/css/all.min.css" />
    <link rel="stylesheet" href="themes/mobispot/css/troika.css" />
    <link rel="stylesheet" href="themes/mobispot/css/add.css" />
    
    <meta  property="og:site_name" content="Mobispot"/>
    <meta  property="og:title" content="<?php echo Yii::t('general', 'Кампусная карта Тройка от Мобиспот'); ?>"/>
    <meta  property="og:type" content="website"/>
    <meta  property="og:url" content="http://mobispot.com/troika"/>
    <meta  property="og:image" content="http://mobispot.com/themes/mobispot/img/troika/2screenpic.png"/>
    <meta  property="og:description" content="<?php echo Yii::t('general', 'Пользуйтесь городским транспортом, открывайте двери в офисе, делайте покупки и получайте скидки с помощью вашей кампусной карты'); ?>"/>
    
    <meta itemprop="name" content="<?php echo Yii::t('general', 'Кампусная карта Тройка от Мобиспот'); ?>">
    <meta itemprop="image" content="http://mobispot.com/themes/mobispot/img/troika/2screenpic.png">
    <meta itemprop="description" content="<?php echo Yii::t('general', 'Пользуйтесь городским транспортом, открывайте двери в офисе, делайте покупки и получайте скидки с помощью вашей кампусной карты'); ?>">
    <meta name="description" content="<?php echo Yii::t('general', 'Пользуйтесь городским транспортом, открывайте двери в офисе, делайте покупки и получайте скидки с помощью вашей кампусной карты'); ?>">
    
    <meta name='yandex-verification' content='736bb65e80939b1d' />
    
    <!--[if IE 8]>
        <html class="no-js lt-ie9" lang="en">
        <link rel="stylesheet" href="css/ie8.css">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <script src="themes/mobispot/js/jquery.min.js"></script>
    <script src="themes/mobispot/js/angular.min.js"></script>
</head>
<body class="splash troika"
    ng-controller="UserController"
    ng-init="user.token='<?php echo Yii::app()->request->csrfToken; ?>';modal='none'"
>

    <?php echo $content; ?>

    <script src="themes/mobispot/js/jquery-ui.min.js"></script>
    <script src="themes/mobispot/js/jquery.animate-enhanced.min.js"></script>
    <script src="themes/mobispot/js/jquery-lazyloadanything.js"></script>
    <script src="themes/mobispot/angular/app.min.js"></script>
    <script src="themes/mobispot/js/script.min.js"></script>
    <script src="themes/mobispot/js/foundation.min.js"></script>
    
    <?php if (!empty($this->blockFooterScript)): ?>
        <?php echo $this->blockFooterScript; ?>
    <?php endif; ?>
</body>
</html>


