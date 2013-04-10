'use strict';

function $id(id) {
  return document.getElementById(id);
}

function UserCtrl($scope, $http, $compile, $timeout) {
  $scope.$watch('user.email + user.password', function(user) {

    if ($scope.user) {
      if ($scope.user.email && $scope.user.password){
        angular.element('#sign-in .form-control a.login').removeClass('button-disable');
      }
      else {
        angular.element('#sign-in .form-control a.login').addClass('button-disable');
      }
    }
  });

//Авторизация
  $scope.login = function(user) {
    if (!user.email || !user.password) return false;
    $http.post('/service/login', user).success(function(data) {
      if(data.error == 'login_error_count') {
        $http.post('/ajax/getBlock', {content:'sign_captcha_form'}).success(function(data)       {
          if(data.error == 'no') {
            var form = $compile(data.content)($scope);
            $http.post('/ajax/getBlock', {content:'captcha'}).success(function(data)           {
              if(data.error == 'no') {
                angular.element('#signInForm').html(form);
                angular.element('#signInForm .captcha').html($compile(data.content)($scope));
              }
            });
          }
        });
      }
      else if (data.error == 'yes') {
        angular.element('#sign-in input[name=email]').addClass('error');
        angular.element('#sign-in input[name=password]').addClass('error');
      }
      else if (data.error == 'no'){
        $(location).attr('href','/user/personal');
      }
      else {
        $(location).attr('href','/');
      }
    });
  };

// Таймер отслеживания состояния корзины
  $scope.initTimer = function(period){
    $http.post('/store/product/GetItemsInCart',{token: $scope.user.token}).success(function(data) {
      $scope.itemsInCart = data.itemsInCart;
    }).error(function(error){
      $scope.itemsInCart = 0;
    });
	if(period == 1000)
		var mytimeout = $timeout($scope.onFastTimeout, 1000);
	else
		var mytimeout = $timeout($scope.onTimeout, 10000);
  };

  $scope.onTimeout = function(){
    $http.post('/store/product/GetItemsInCart',{token: $scope.user.token}).success(function(data) {
      $scope.itemsInCart = data.itemsInCart;
    });

    var mytimeout = $timeout($scope.onTimeout, 10000);
  };

  $scope.onFastTimeout = function(){
    $http.post('/store/product/GetItemsInCart',{token: $scope.user.token}).success(function(data) {
      $scope.itemsInCart = data.itemsInCart;
    });

    var mytimeout = $timeout($scope.onFastTimeout, 1000);
  };

}

function HelpCtrl($scope, $http, $compile) {

  $scope.$watch('user.email + user.fName + user.question', function(user) {
    if ($scope.user.fName && $scope.user.email && $scope.user.question) {
      angular.element('#help-in .form-control a').removeClass('button-disable');
    }
  });


  $scope.send = function(user){
    $http.post('/ajax/sendQuestion', user).success(function(data) {
      if(data.error == 'no') {
        console.log(1);
      }
    });
  };
}