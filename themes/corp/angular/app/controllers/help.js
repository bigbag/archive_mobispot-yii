'use strict';

angular.module('mobispot').controller('HelpController', 
  function($scope, $http, $compile, $timeout, contentService) {

  $scope.$watch('user.email + user.name + user.question', function(user) {
    if ($scope.user.name && $scope.user.email && $scope.user.question) {
      angular.element('#help-in .form-control a').removeClass('button-disable');
    }
  });


  $scope.send = function(user, valid){
    if (!valid) return false;

    $http.post('/help/sendQuestion', user).success(function(data) {
      if(data.error == 'no') {
        $scope.user.name = '';
        $scope.user.email = '';
        $scope.user.question = '';
        $scope.user.phone = '';

        contentService.setModal(data.message, 'none');
      }
    });
  };
});