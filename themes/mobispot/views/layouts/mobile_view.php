<!DOCTYPE html>
<html class="no-js" ng-app="mobispot" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <title><?php echo Yii::app()->params['siteTitle']; ?></title>

    <link rel="icon" type="image/png" href="/themes/mobile/images/favicon16.png">
    <link rel="icon" type="image/png" href="/themes/mobile/images/favicon32.png">
    <link rel="icon" type="image/png" href="/themes/mobile/images/favicon48.png">

    <meta name="viewport" content="width=device-width" />

    <link rel="stylesheet" href="/themes/mobile/stylesheets/style.css">

    <script src="https://maps.google.com/maps/api/js?key=<?php echo Yii::app()->eauth->services['google_oauth']['key']; ?>&sensor=true"></script>
    <script src="/themes/mobispot/js/jquery.min.js"></script>
    <script src="/themes/mobispot/js/angular.min.js"></script>
    <script src="/themes/mobile/js/mobile.js"></script>
    <script src="/themes/mobile/js/app.js"></script>
    <script src="/themes/mobile/js/controllers.js"></script>
</head>
<body>
    <div class="content-wrapper bg-gray">
        <div class="spot-content_row" ng-controller="MobileCtrl" ng-init="token='<?php echo Yii::app()->request->csrfToken; ?>'">
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
