'use strict';

angular.module('mobispot').controller('UserCtrl',
  function($scope, $http, contentService) {

  $scope.user = {};
  $scope.error = {};
  
  //Авторизация
  $scope.login = function(user, valid) {
   if (!valid) {
     $scope.error.email = true;
     return false;
   }
   
   user.terms = 1;
   
   $http.post('/service/login', user).success(function(data) {
      if (data.error == 'yes') {
          $scope.error.email = true;
      }
      else if (data.error == 'no'){
        $(location).attr('href','/spot/list/');
      }
      else {
        $(location).attr('href','/');
      }
    }).error(function(error){alert(error)});
  }
  
  //Тригер на снятие ошибки при изменении поля
  $scope.$watch('user.password + user.email', function() {
    $scope.error.email = false;
  });
  
  // Регистрация
  $scope.activation = function(user, valid){

    if (!valid) return false;
    if (user.terms === 0) return false;

    $http.post('/service/registration', user).success(function(data) {

      if (data.error == 'no'){
        $scope.user.email = '';
        $scope.user.password = '';
        $scope.user.activ_code = '';
        $scope.user.terms = 0;
        $scope.result.message = data.content;
        contentService.viewModal('message');
      }
      else if (data.error == 'email') {
        $scope.error.email = true;
        $scope.error.content = data.content;
      }
      else if (data.error == 'code'){
        $scope.error.code = true;
        $scope.error.content = data.content;
      }
    }).error(function(error){alert(error)});
  };
});