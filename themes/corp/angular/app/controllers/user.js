'use strict';

angular.module('mobispot').controller('UserController',
  function($scope, $http, $compile, $timeout, contentService) {

  $scope.error = {};
  $scope.result = {};

  //Меняем статус активности кнопки войти в зависимости от валидности формы
  $scope.$watch('user.email + user.password', function(user) {

    if ($scope.user) {
      var loginButton = angular.element('#sign-in .form-control a.login');
      if ($scope.user.email && $scope.user.password){
        loginButton.removeClass('button-disable');
      }
      else {
        loginButton.addClass('button-disable');
      }
    }
  });

  //Авторизация
  $scope.login = function(user, valid) {
    if (!valid) return false;
    $http.post('/corp/site/login', user).success(function(data) {
      if (data.error == 'yes') {
        contentService.setModal(data.content, 'error');
          $scope.error.email = true;
      }
      else if (data.error == 'no'){
        $(location).attr('href','/corp/wallet/');
      }
      else {
        $(location).attr('href','/corp/');
      }
    });
  };

  $scope.$watch('user.email + user.password ', function() {
    $scope.error.email = false;
    $scope.error.password = false;
  });
});