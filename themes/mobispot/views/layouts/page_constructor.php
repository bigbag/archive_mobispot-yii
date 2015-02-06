<!DOCTYPE html>
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8" ng-app="mobispot" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9" ng-app="mobispot" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" ng-app="mobispot" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <title><?php echo Yii::app()->params['siteTitle']; ?></title>

    <?php if (!$this->blockHeaderCeo): ?>
    <meta  property="og:site_name" content="Mobispot"/>
    <meta  property="og:title" content="Mobispot - Wearable NFC devices"/>
    <meta  property="og:type" content="website"/>
    <meta  property="og:url" content="http://mobispot.com"/>
    <meta  property="og:image" content="http://mobispot.com/themes/mobispot/img/og.jpg"/>
    <meta  property="og:description" content="We create lovely NFC wristbands and make smart applications for them: payments, transportation, web sharing, secure ID, discounts and membership. "/>

    <meta itemprop="name" content="Mobispot - Wearable NFC devices">
    <meta itemprop="description" content="We create lovely NFC wristbands and make smart applications for them: payments, transportation, web sharing, secure ID, discounts and membership.">
    <meta itemprop="image" content="http://mobispot.com/themes/mobispot/img/og.jpg">
    <meta name="description" content="We create lovely NFC wristbands and make smart applications for them: payments, transportation, web sharing, secure ID, discounts and membership.">
    <?php endif; ?>

    <link rel="icon" type="image/png" href="/themes/mobispot/images/favicon16.png">
    <link rel="icon" type="image/png" href="/themes/mobispot/images/favicon32.png">
    <link rel="icon" type="image/png" href="/themes/mobispot/images/favicon48.png">

    <link rel="stylesheet" href="/themes/mobispot/css/all.min.css" />
    <link rel="stylesheet" href="/themes/mobispot/css/spot.css" />
    <link rel="stylesheet" href="/themes/mobispot/css/image-crop-styles.css" />
    <link rel="stylesheet" href="/themes/mobispot/css/add.css" />

    <!--[if IE 8]>
        <html class="no-js lt-ie9" lang="en">
        <link rel="stylesheet" href="css/ie8.css">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <script src="/themes/mobispot/js/jquery.min.js"></script>
    <script src="/themes/mobispot/js/angular.min.js"></script>
    <script src="/themes/mobispot/js/jquery.form.js"></script>
</head>
    <body ng-controller="UserController"
        ng-cloak class="ng-cloak"
        ng-init="user.token='<?php echo Yii::app()->request->csrfToken ?>';modal='none'">
        <p style="display: block; height: 0; overflow: hidden; visibility: hidden; position: absolute;">We create lovely NFC wristbands and make smart applications for them: payments, transportation, web sharing, secure ID, discounts and membership.</p>
        <div class="spl-extra main<?php echo (empty($this->casingClass)?'':' '.$this->casingClass);?>" 
            ng-init="host_type='desktop'"
            <?php if (!empty($this->mainBackground)): ?>
                style="background-image: url(/themes/mobispot/img/<?php echo $this->mainBackground; ?>)"
            <?php endif; ?>
        >
        
        <?php include('block/header/page.php'); ?>

        <div ng-click="hideModal()">
            <?php echo $content; ?>
        </div>

        <?php if (!empty($this->mainBackground)): ?>
            </div>
        <?php endif; ?>
        
        <?php include('block/footer/page.php'); ?>
        <script src="/themes/mobispot/js/jquery-ui.min.js"></script>
        <script src="/themes/mobispot/js/slide-box.min.js"></script>
        <script src="/themes/mobispot/js/jquery.autosize-min.js"></script>
        <script src="/themes/mobispot/js/jquery.animate-enhanced.min.js"></script>
        <!--[if lt IE 9]>
            <script src="/themes/mobispot/js/jquery.placeholder.js"></script>

            <script>
                $(function () {
                    $('input, textarea').placeholder();
                });
            </script>

        <![endif]-->

        <script src="/themes/mobispot/angular/app.min.js"></script>

        <script src="/themes/mobispot/js/script.min.js"></script>
        <script src="/themes/mobispot/js/foundation.min.js"></script>
        <script src="/themes/mobispot/js/image-crop-custom.js"></script>
        <script>
            $(document).foundation();
            $(window).load(function () {
                $('textarea').autosize();
            });
        </script>

        </div>
    </body>
</html>
