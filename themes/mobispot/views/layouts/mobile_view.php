<!DOCTYPE html>
<html class="no-js" ng-app="mobispot" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <title><?php echo Yii::app()->params['siteTitle']; ?></title>

    <link rel="icon" type="image/png" href="/themes/mobile/images/favicon16.png">
    <link rel="icon" type="image/png" href="/themes/mobile/images/favicon32.png">
    <link rel="icon" type="image/png" href="/themes/mobile/images/favicon48.png">

    <meta name="viewport" content="width=device-width" />

    <link rel="stylesheet" href="/themes/mobispot/css/style_mobile_view.min.css">

    <script src="https://maps.google.com/maps/api/js?key=<?php echo Yii::app()->eauth->services['google_oauth']['key']; ?>&sensor=true"></script>
    <script src="/themes/mobispot/js/jquery.min.js"></script>
    <script src="/themes/mobispot/js/angular.min.js"></script>

    <script src="/themes/mobile/js/mobile.js"></script>
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
  <script>
  angular.module('mobispot', [])
    .controller('MobileCtrl',
    function($scope, $http) {
      $scope.followSocial = function(service, param, idBlock){
        var data = {service: service, param:param, token:$scope.token};
        var pathname = '/spot/';
        if (window.location.pathname.toLowerCase().indexOf('/mobile/spot') != -1)
            pathname = '/mobile/spot/';

        $http.post((pathname + 'FollowSocial'), data).success(function(data) {
          if (!data.LoggedIn){
            window.location = 'http://' + window.location.hostname
              + pathname
              + 'SocLogin?service='
              + service
              + '&return_url='
              + escape(window.location.hostname + window.location.pathname + window.location.search)
              + '&follow_param=' + escape(param);
          }
          else if (data.error == 'no' && typeof (data.message) != 'undefined'){
            angular.element('#' + idBlock + ' a.spot-button.soc-link').text(data.message);
          }
        });
      }
    });
  </script>
</body>
</html>
