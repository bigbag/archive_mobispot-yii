'use strict';
angular.module('mobispot').controller('PhonesController',
  function($scope) {
    $scope.initPhones = function(initValue)
    {
        $scope.phonesList = initValue;
    };

    $scope.initDevices = function(initValue)
    {
        $scope.devicesList = initValue;
    };

    $scope.phonesList = [];

    $scope.devicesList = [];
});
