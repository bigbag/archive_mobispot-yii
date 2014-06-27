'use strict';

angular.module('mobispot').controller('SpotController',
  function($scope, $http, $compile, $timeout) {

/* Инициализация переменных */

  $scope.keys = [];

  $scope.error = {};
  $scope.result = {};

  $scope.spot = {};
  $scope.spot.discodes = 0;

  $scope.general = {};
  $scope.general.views = false;

  //Управление основными блоками спот, кошелек, купоны.
  $scope.$watch('general.views + spot.discodes', function() {
    if ($scope.general.views == 'spot'){
      $scope.viewSpot($scope.spot);
    } else if ($scope.general.views == 'wallet'){
      $scope.viewWallet($scope.spot);
    } else if ($scope.general.views == 'coupon'){
      $scope.viewCoupons($scope.spot);
    } else if ($scope.general.views == 'settings'){
      $scope.viewsSettings($scope.spot);
    }
  });
  
  // Отображение контента спота
  $scope.viewSpot = function (spot) {
    if (spot.discodes === 0) return false;

    var spot_block = angular.element('#spot-block');
    
    $http.post('/mobile/spot/spotContent', spot).success(function(data) {
      if(data.error == 'no') {
        spot_block.empty();
        spot_block.html($compile(data.content)($scope));
      }
    }).error(function(error){alert(error)});
  };
  
  // Отображение кошелька
  $scope.viewWallet = function (spot) {
  
  };

    // Отображение купонов
  $scope.viewCoupons = function (spot) {

  };
  
  // Отображение настроек
  $scope.viewsSettings = function (spot) {
    
  };
  
  //подгрузка блока с контентом соцсети
  $scope.loadSocContent = function(key)
  {
    var data = {discodes:$scope.spot.discodes, key:key, token:$scope.spot.token};

    $http.post('/mobile/spot/socNetContent', data).success(function(data) {
      if(data.error == 'no'){
            var spotEdit = angular.element('#block-' + data.key);
            spotEdit.before($compile(data.content)($scope));
            spotEdit.remove();
        }
      }).error(function(error){alert(error)});
  };
  
});