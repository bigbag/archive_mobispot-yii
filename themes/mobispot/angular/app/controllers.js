'use strict';

function $id(id) {
  return document.getElementById(id);
}

function UserCtrl($scope, $http, $compile, $timeout) {
  var resultModal = angular.element('.m-result');
  var resultContent = resultModal.find('p');

  $scope.setModal = function(content, type){
    if (content != '0'){
      resultModal.removeClass('m-negative');
      if (type == 'error') {
          resultModal.addClass('m-negative');
      }
      resultModal.show();
      resultContent.text(content);
      if($('html').hasClass('no-opacity')){
        setTimeout(function(){resultModal.hide}, 5000);
      } else {
        resultModal.fadeOut(5000);
      }
    } 
  };

  $('#birthday').datepicker({
      yearRange: '1900:-0',
      dateFormat: 'dd.mm.yy',
      onSelect: function (dateText, inst) {
        $scope.$apply(function () {
            $scope.user.birthday = dateText;
        }); 
      }
    });

  //Редактирование профиля пользователя
  $scope.setProfile = function(user){
    $http.post('/user/editProfile',user).success(function(data) {
        if (data.error == 'no'){
          $scope.setModal(data.content, 'none');
        }
    });
  };

  //Авторизация
  $scope.login = function(user, valid) {
   if (!valid) return false;
    $http.post('/service/login', user).success(function(data) {
      if (data.error == 'yes') {
        $scope.setModal(data.content, 'error');

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

  // Атрибут огласия с условиями сервиса
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
          $scope.setModal(data.content, 'none');
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
          codeId.addClass('error');
        }
        $scope.setModal(data.content, 'error');
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
        $scope.setModal(data.content, 'error');
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
  $scope.recovery = function(recovery, valid){
    if (!valid) return false;

    var user = $scope.user;
    user.email = recovery.email;
    user.action = 'recovery';
    $http.post('/service/recovery', user).success(function(data) {
      if (data.error == 'yes') {
        angular.element('#recPassForm input[name=email]').addClass('error');
        $scope.setModal(data.content, 'error');
      }
      else if (data.error == 'no'){
        angular.element('#recPassForm').slideUp(400, function() {
          resultModal.removeClass('m-negative');
          resultModal.show();
          resultContent.text(data.content);
          resultModal.fadeOut(8000, function() {
          });
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
    user.action = 'change';

    $http.post('/service/recovery', user).success(function(data) {
      if (data.error == 'yes') {
        angular.element('#changePassForm input[name=password]').addClass('error');
        angular.element('#changePassForm input[name=confirmPassword]').addClass('error');
      }
      else if (data.error == 'no'){
        $(location).attr('href','/user/personal');
      }
    });
  };
}

function HelpCtrl($scope, $http, $compile) {
  var resultModal = angular.element('.m-result');
  var resultContent = resultModal.find('p');

  $scope.$watch('user.email + user.name + user.question', function(user) {
    if ($scope.user.name && $scope.user.email && $scope.user.question) {
      angular.element('#help-in .form-control a').removeClass('button-disable');
    }
  });

  $scope.send = function(user, valid){
    if (!valid) return false;

    $http.post('/service/sendQuestion', user).success(function(data) {
      if(data.error == 'no') {
        $scope.user.name = '';
        $scope.user.email = '';
        $scope.user.question = '';
        $scope.user.phone = '';

        resultModal.show();
          resultContent.text(data.content);
          resultModal.fadeOut(10000, function() {
        });
      }
    });
  };

}
