'use strict';

angular.module('mobispot').controller('UserController',
  function($scope, $http, $compile, $cookies, contentService) {

  $scope.error = {};
  $scope.result = {};
  $scope.modal = 'none';
  $scope.host_type = 'mobile';

  //Очистка значений
  $scope.setEmpty = function() {
    $scope.user.password = '';
    $scope.user.terms = 0;

    $scope.error = {};
    $scope.result = {};
  };

  $scope.hideModal = function() {
    $scope.modal = 'none';
  };

  //Инициализация датапикера
  angular.element('#birthday').datepicker({
    yearRange: '1900:-0',
    dateFormat: 'dd.mm.yy',
    onSelect: function (dateText, inst) {
      $scope.$apply(function () {
          $scope.user.birthday = dateText;
      });
    }
  });

  //Сторож модальных окон
  $scope.$watch('modal', function() {
    $scope.setEmpty($scope.modal);
    contentService.desktopModal($scope.modal);
  });

  //Редактирование профиля пользователя
  $scope.setProfile = function(user){
    $http.post('/user/editProfile',user).success(function(data) {
        if (data.error == 'no'){
          $scope.result.message = data.content;
          contentService.desktopModal('message');
        }
    });
  };

  //Автоопределение разрещения
  $scope.getResolution = function() {
    var resolution = $cookies.resolution;
    if (!resolution) {
      var clientRes = Math.max(screen.width,screen.height);
      var res = [1920, 1400, 1280];
      for(var i=0; i<res.length; i++) {
        if (clientRes >= res[i]){
          resolution = res[i];
          break;
        }
      }
      $cookies.resolution = '' + resolution;
      $scope.resolution = resolution;
    }
  };

  //Авторизация
  $scope.login = function(user, valid) {
   if (!valid) return false;
    $http.post('/service/login', user).success(function(data) {
      if (data.error == 'yes') {
          $scope.error.email = true;
          $scope.error.content = data.content;
      }
      else if (data.error == 'no'){
        if (angular.isUndefined(data.access_url) || !data.access_url.length)
          angular.element(location).attr('href','/spot/list/');
        else
          angular.element(location).attr('href',data.access_url);
      }
      else {
        angular.element(location).attr('href','/');
      }
    });
  };

  $scope.$watch('user.email + user.password + user.code', function() {
    $scope.error.email = false;
    $scope.error.code = false;
    $scope.error.password = false;
    $scope.error.content = '';
  });

  // Регистрация
  $scope.activation = function(user, valid){
    if (!valid) return false;
    if (user.terms === 0) return false;

    $http.post('/service/registration', user).success(function(data) {

      if (data.error == 'no'){
        $scope.user.email = '';
        $scope.user.password = '';
        $scope.user.terms = 0;
        if ($scope.host_type === 'mobile') {
          contentService.mobileModal(data.content, 'none');
        } else {
          $scope.result.message = data.content;
          contentService.desktopModal('message');
        }

      } else {
        if (data.error === 'email') {
          $scope.error.email = true;
        } else {
          $scope.error.code = true;
        }
        $scope.error.content = data.content;
        if ($scope.host_type === 'mobile')
          contentService.mobileModal(data.content, 'error');
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
        if ($scope.host_type === 'mobile')
            contentService.mobileModal(data.content, 'error');
      }
      else if (data.error == 'no'){
        $scope.user.email = '';
        $scope.result.message = data.content;
        if ($scope.host_type === 'mobile')
            contentService.mobileModal(data.content, 'none');
        else
            contentService.desktopModal('message');
      }
    });
  };

  // Смена пароля
  $scope.change = function(user, valid){
    if (!valid) return false;

    $http.post(window.location.pathname , user).success(function(data) {
      if (data.error == 'no'){
        angular.element(location).attr('href','/spot/list/');
      }
    });
  };

  $scope.messageModal = function(text) {
    if (angular.isUndefined(text) || !text.length)
        return false;

    $scope.result.message = text;
    if ($scope.host_type === 'mobile')
      contentService.mobileModal(text, 'none');
    else
      contentService.desktopModal('message');
  };
  
  $scope.loadFront = function() {
    var resolution = 1920;
    
    if (screen.width <= 1400)
        resolution = 1400;
    if (screen.width <= 1280)
        resolution = 1280;
        
    var frontBlock = angular.element('.splash .first-screen');
       
    frontBlock.css('background-image', 'url(../themes/mobispot/img/info/front_' + resolution + '.jpg)');
  }
  
  /*
  angular.element(window).bind('load', function() {
    if (!angular.element('.splash').length || !angular.element('.splash #payment').length)
        return false;
        
    var resolution = 1920;
    
    if (screen.width <= 1400)
        resolution = 1400;
    if (screen.width <= 1280)
        resolution = 1280;
    
    angular.element('.splash #payment').css('background-image', 'url(../themes/mobispot/img/info/pass_' + resolution + '.jpg)');
    
    angular.element('.splash #soc').css('background-image', 'url(../themes/mobispot/img/info/discount_' + resolution + '.jpg)');
    
    angular.element('.splash #coupon').css('background-image', 'url(../themes/mobispot/img/info/social_' + resolution + '.jpg)');
    
    angular.element('.splash #transport').css('background-image', 'url(../themes/mobispot/img/info/transport_' + resolution + '.jpg)');
    
    angular.element('.splash #dev').css('background-image', 'url(../themes/mobispot/img/info/partner_' + resolution + '.jpg)');
 
  });
  */
  
});