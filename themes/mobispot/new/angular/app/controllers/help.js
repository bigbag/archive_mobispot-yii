'use strict';

angular.module('mobispot').controller('HelpController', 
  function($scope, $http, $compile, $timeout) {

  $scope.send = function(user, valid){
    if (!valid) return false;
    user.email = user.help_email
    $http.post('/service/sendQuestion', user).success(function(data) {
      if(data.error == 'no') {
        $scope.user.name = '';
        $scope.user.help_email = '';
        $scope.user.question = '';
        $scope.user.phone = '';
      }
    });
  };

});