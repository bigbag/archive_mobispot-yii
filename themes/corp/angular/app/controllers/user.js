'use strict';

angular.module('mobispot').controller('UserController', 
  function($scope, $http, $compile, $timeout, contentService) {
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
    $http.post('/service/login', user).success(function(data) {
      if (data.error == 'yes') {
        contentService.setModal(data.content, 'error');

        angular.element('#sign-in input[name=email]').addClass('error');
        angular.element('#sign-in input[name=password]').addClass('error');
      }
      else if (data.error == 'no'){
        $(location).attr('href','/wallet/');
      }
      else {
        $(location).attr('href','/');
      }
    });
  };

 //Меняем статус активности кнопки зарегистрироваться в зависимости от валидности формы
  $scope.$watch('user.email + user.password + user.activ_code + user.terms', function(user) {
    if ($scope.user) {
      var activButton = angular.element('#personSpotForm .form-control a.activ');
      if ($scope.user.email && $scope.user.password && $scope.user.activ_code && $scope.user.terms){
        if (($scope.user.terms == 1) && ($scope.user.activ_code.length == 10)) {
          activButton.removeClass('button-disable');
        }
        else {
          activButton.addClass('button-disable');
        }
      }
      else {
        activButton.addClass('button-disable');
      }
    }
  });

  // Атрибут согласия с условиями сервиса
  $scope.setTerms = function(user){
    if (user.terms == 1) user.terms = 0;
    else user.terms = 1;
  };

  // Регистрация
  $scope.registration = function(user, valid){
    if (!valid) return false;

    var emailId = angular.element('#personSpotForm input[name=email]');
    var passwordId = angular.element('#personSpotForm input[name=password]');
    var codeId = angular.element('#personSpotForm input[name=code]');

    $http.post('/service/registration', user).success(function(data) {
      emailId.removeClass('error');
      passwordId.removeClass('error');
      codeId.removeClass('error');

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
          emailId.addClass('error');
          passwordId.addClass('error');
        }
        else if (data.error == 'code'){
          angular.element('#personSpotForm input[name=code]').addClass('error');
        }
        contentService.setModal(data.content, 'error');
      }
    });
  };

  //Меняем статус активности кнопки отправить в форме востановления пароля
  $scope.$watch('recovery.email', function(recovery) {
    if ($scope.recovery) {
      var activButton = angular.element('#recovery-pass .form-control a');
      if ($scope.recovery.email){
        activButton.removeClass('button-disable');
      }
      else {
        activButton.addClass('button-disable');
      }
    }
  });

  // Восстановление пароля
  $scope.recovery = function(recovery, valid){
    if (!valid) return false;

    var user = $scope.user;
    user.email = recovery.email;

    $http.post('/service/recoveryMail', user).success(function(data) {
      if (data.error == 'yes') {
        angular.element('#recPassForm input[name=email]').addClass('error');
        contentService.setModal(data.content, 'error');
      }
      else if (data.error == 'no'){
        angular.element('#recPassForm').slideUp(400, function() {
          contentService.setModal(data.content, 'none');
        });

        $scope.user.email="";
        $scope.recovery.email="";
        angular.element('#recPassForm input[name=email]').removeClass('error');
      }
    });
  };

  //Меняем статус активности кнопки отправить на странице востановления пароля
  $scope.$watch('user.password + user.confirmPassword', function(change) {
    if ($scope.user) {
      var activButton = angular.element('#change-pass .form-control a');
      if ($scope.user.password && $scope.user.confirmPassword && ($scope.user.password == $scope.user.confirmPassword)){
        activButton.removeClass('button-disable');
      }
      else {
        activButton.addClass('button-disable');
      }
    }
  });

  // Смена пароля
  $scope.change = function(user, valid){
    if (!valid) return false;

    $http.post('/service/changepassword', user).success(function(data) {
      if (data.error == 'yes') {
        angular.element('#changePassForm input[name=password]').addClass('error');
        angular.element('#changePassForm input[name=confirmPassword]').addClass('error');
      }
      else if (data.error == 'no'){
        $(location).attr('href','/wallet/');
      }
    });
  };
});