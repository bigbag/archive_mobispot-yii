'use strict';
angular.module('mobispot').controller('PhonesController', 
  function($scope) {
    $scope.initPhones = function(initValue)
    {
        $scope.phonesList = initValue;
        //$scope.parents = initValue;
        //var herher = $scope.parents.models;
    }

    $scope.initDevices = function(initValue)
    {
        $scope.devicesList = initValue;
    }
    
    $scope.phonesList = [];

    $scope.devicesList = [];
});
