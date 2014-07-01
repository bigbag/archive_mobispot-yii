'use strict';

angular.module('mobispot').controller('UserCtrl',
  function($scope, $http) {

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
});