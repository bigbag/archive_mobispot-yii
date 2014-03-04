'use strict';

angular.module('mobispot').controller('UserController', 
  function($scope, $http, $compile) {

  $scope.error = {};

  //Обнуляем модель user и снимаем ошибки при смене формы
  $scope.$watch('action', function() {
    $scope.user.email = '';
    $scope.user.password = '';
    $scope.user.terms = 0;

    $scope.error.email = false;
    $scope.error.password = false;
  });

  //Авторизация
  $scope.login = function(user, valid) {
   if (!valid) return false;
    $http.post('/service/login', user).success(function(data) {
      if (data.error == 'yes') {
          $scope.error.email = true;
          $scope.error.content = data.content;
      }
      else if (data.error == 'no'){
        $(location).attr('href','/user/personal');
      }
      else {
        $(location).attr('href','/');
      }
    });
  };

  $scope.$watch('user.email + user.password', function(user) {
    $scope.error.email = false;
    $scope.error.content = '';
  });

  // Регистрация
  $scope.activation = function(user, valid){
    if (!valid) return false;
    if (user.terms == 0) return false;
    $http.post('/service/registration', user).success(function(data) {

      if (data.error == 'no'){
        angular.element('#actSpotForm').slideUp(400, function() {
          contentService.setModal(data.content, 'none');
        });

        $scope.user.email="";
        $scope.user.password="";
        $scope.user.activ_code="";
        $scope.user.terms=0;
      }
      else {
        if (data.error == 'yes') {
          $scope.error.activ.email = true;
        }
        else if (data.error == 'code'){
          $scope.error.activ.code = true;
        }
      }
    });
  };

  //Меняем статус активности кнопки отправить в форме регистрации через соц сети
  $scope.$watch('user.email + user.activ_code + user.terms', function(user) {
    if ($scope.user) {
      var socialButton = angular.element('#socialForm .form-control a.activ');

      if ($scope.user.email && $scope.user.activ_code && $scope.user.terms){
        if (($scope.user.terms == 1) && ($scope.user.activ_code.length == 10)) {
          socialButton.removeClass('button-disable');
        }
        else {
          socialButton.addClass('button-disable');
        }
      }
      else {
        socialButton.addClass('button-disable');
      }
    }
  });

  // Регистрация через соц сети
  $scope.social = function(user){
    var emailField = angular.element('#socialForm input[name=email]');
    var codeField = angular.element('#socialForm input[name=code]');

    $http.post('/service/social', user).success(function(data) {
      if (data.error == 'yes') {
        if (emailField){
          emailField.addClass('error');
        }
        codeField.addClass('error');
      }
      else if ((data.error == 'email') || (data.error == 'code')){
        contentService.setModal(data.content, 'error');
      }
      else if (data.error == 'no'){
        $scope.user.email="";
        $scope.user.activ_code="";
        $scope.user.terms=0;

        resultModal.show();
        resultContent.text(data.content);
        resultModal.fadeOut(8000, function() {
          $(location).attr('href','/');
        });

        if (emailField){
          emailField.removeClass('error');
        }
        codeField.removeClass('error');
      }
    });

  };

  // Восстановление пароля
  $scope.recovery = function(user, valid){
    if (!valid) return false;

    $http.post('/service/recovery', user).success(function(data) {
      if (data.error == 'yes') {
        $scope.error.email = true;
        $scope.error.content = data.content;
      }
      else if (data.error == 'no'){
        $scope.user.email = "";
      }
    });
  };

  $scope.$watch('user.email + user.password', function(user) {
    $scope.error.email = false;
    $scope.error.content = '';
  });

  // Смена пароля
  $scope.change = function(user, valid){
    if (!valid) return false;

    $http.post('/service/change', user).success(function(data) {
      if (data.error == 'yes') {
        angular.element('#changePassForm input[name=password]').addClass('error');
        angular.element('#changePassForm input[name=confirmPassword]').addClass('error');
      }
      else if (data.error == 'no'){
        $(location).attr('href','/user/personal');
      }
    });
  };
});