'use strict';

angular.module('mobispot').controller('HelpController',
  function($scope, $http, contentService) {

  $scope.error = {};

  $scope.send = function(user, valid){
    if (!valid) return false;
    user.email = user.help_email;
    $http.post('/service/sendQuestion', user).success(function(data) {
        $scope.user.name = '';
        $scope.user.help_email = '';
        $scope.user.question = '';
        $scope.user.phone = '';

        $scope.result.message = data.content;
        contentService.viewModal('message');
    });
  };
});