'use strict';

function $id(id) {
  return document.getElementById(id);
}

function UserCtrl($scope, $http, $compile, $timeout) {

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

  //Меняем статус активности кнопки зарегистрироваться в зависимости от валидности формы
  $scope.$watch('user.email + user.password + user.activ_code + user.terms', function(user) {
    if ($scope.user) {
      var personButton = angular.element('#personSpotForm .form-control a.activ');
      var companyButton = angular.element('#companySpotForm .form-control a.activ');

      if ($scope.user.email && $scope.user.password && $scope.user.activ_code && $scope.user.terms){
        if (($scope.user.terms == 1) && ($scope.user.activ_code.length == 10)) {
          personButton.removeClass('button-disable');
          companyButton.removeClass('button-disable');
        }
        else {
          personButton.addClass('button-disable');
          companyButton.removeClass('button-disable');
        }
      }
      else {
        personButton.addClass('button-disable');
        companyButton.removeClass('button-disable');
      }
    }
  });

  // Атрибут согласия с условиями сервиса
  $scope.setTerms = function(user){
    if (user.terms == 1) user.terms = 0;
    else user.terms = 1;
  };

  // // Регистрация
  $scope.registration = function(user, valid){
    if (!valid) return false;

    $http.post('/service/registration', user).success(function(data) {
      if (data.error == 'yes') {
        angular.element('#companySpotForm input[name=email]').addClass('error');
        angular.element('#companySpotForm input[name=code]').addClass('error');
        angular.element('#personSpotForm input[name=email]').addClass('error');
        angular.element('#personSpotForm input[name=code]').addClass('error');
      }
      else if (data.error == 'no'){
        $scope.user.email="";
        $scope.user.password="";
        $scope.user.activ_code="";
        $scope.user.terms=0;
        angular.element('#personSpotForm input[name=email]').removeClass('error');
        angular.element('#personSpotForm input[name=code]').removeClass('error');
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
    user.action = 'recovery';
    $http.post('/service/recovery', user).success(function(data) {
      if (data.error == 'yes') {
        angular.element('#recPassForm input[name=email]').addClass('error');
      }
      else if (data.error == 'no'){
        angular.element('#recPassForm .result').text(data.content).fadeOut(7000);

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
        $(location).attr('href','/user/person');
      }
    });
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

function WalletCtrl($scope, $http, $timeout){
  $scope.ready = false;
  $scope.WalletInit = function(token){
      $scope.token = token;
      $http.post('/wallet/GetWallet', {token : $scope.token}).success(function(data) {
        $scope.wallet = data.wallet;
        $scope.history = data.history;
      }).error(function(error){
          alert(error);
      });
  };

  $scope.addByUniteller = function(){
    $scope.ready = false;
    $scope.tries = 0;

    $http.post('/wallet/GetUnitellerOrder', {token : $scope.token, newSumm: $scope.newSumm}).success(function(data) {
      $scope.order = data.order;
      $scope.ready = true;
      angular.element('#unitell_shop_id').val(data.order.idShop);
      angular.element('#unitell_customer').val(data.order.idCustomer);
      angular.element('#unitell_order_id').val(data.order.idOrder);
      angular.element('#unitell_subtotal').val(data.order.subtotal);
      angular.element('#unitell_signature').val(data.order.signature);
      angular.element('#unitell_url_ok').val(data.order.return_ok);
      angular.element('#unitell_url_no').val(data.order.return_error);
      document.getElementById('submitUnitell').click();
    }).error(function(error){
      alert(error);
    });
  }

}