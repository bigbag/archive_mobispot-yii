'use strict';

angular.module('mobispot').controller('HelpController', 
  function($scope, $http, $compile, $timeout) {

  $scope.send = function(user, valid){
    if (!valid) return false;

    $http.post('/service/sendQuestion', user).success(function(data) {
      if(data.error == 'no') {
        $scope.user.name = '';
        $scope.user.email = '';
        $scope.user.question = '';
        $scope.user.phone = '';
      }
    });
  };

});