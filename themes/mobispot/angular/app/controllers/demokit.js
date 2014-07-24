'use strict';

angular.module('mobispot').controller('DemokitController',
  function($scope, $http, $compile, $timeout, contentService) {


$scope.dkitForm = function(e, index, checkValid, valid){
  if ($scope.summ <= 0) {
      return false;
  }

  if (typeof 'undefined' != checkValid && 1 == checkValid && !valid){
    contentService.setModal($scope.fillAllMessage, 'error');
    return false;
  }

  index = --index;

  var $tabItem = angular.element('.tab-item');
  var $tabLink = angular.element('li','.get-up-nav');
  $tabItem.removeClass('active');
  $tabLink.removeClass('active');
  angular.element($tabItem[index]).addClass('active');
  angular.element($tabLink[index]).addClass('active');

};

  $scope.order = {
    name:'',
    email:'',
    phone:'',
    address:'',
    city:'',
    zip:'',
    country:'',
    shipping: 1,
    payment: 1
  };
  $scope.products = {};
  $scope.max_product_id = 0;
  $scope.prices = {};
  $scope.shippings = {};
  $scope.payments = {};

  $scope.total = 0;
  $scope.toMain = false;

  $scope.registerProduct = function(product_id, price) {
    $scope.products[product_id] = 0;
    if (product_id > $scope.max_product_id)
        $scope.max_product_id = product_id;
    $scope.prices[product_id] = price;
  };

  $scope.addProduct = function(product_id) {
    if ($scope.products[product_id] < 9)
      $scope.products[product_id]++;
    $scope.calculateSumm();
  };

  $scope.deductProduct = function(product_id) {
    if ($scope.products[product_id] > 0)
      $scope.products[product_id]--;
    $scope.calculateSumm();
  };

  $scope.registerShipping = function(shipping_id, price) {
    $scope.shippings[shipping_id] = price;
  };

  $scope.setShipping = function(shipping_id, e) {
      $scope.order.shipping = shipping_id;
      if (typeof e != 'undefined')
          angular.element(e.currentTarget).click();
      $scope.calculateSumm();
  };

  $scope.registerPayment = function(payment_id, action) {
      $scope.payments[payment_id] = action;
  };

  $scope.setPayment = function(payment_id, e) {
      $scope.order.payment = payment_id;
      if (typeof e != 'undefined')
          angular.element(e.currentTarget).click();
  };

  $scope.calculateSumm = function() {
    $scope.summ = 120;

    $scope.total = $scope.summ;
    if ($scope.order.shipping && typeof $scope.shippings[$scope.order.shipping] != 'undefined')
    $scope.total += $scope.shippings[$scope.order.shipping];
  };

  $scope.buyDemoKit = function(order) {
    if ($scope.toMain)
      window.location.href = '/';
    else {
      order.products=$scope.products;
      $http.post('/service/buyDemoKit', order).success(function(data) {
        if (data.error == 'no'){
          if ('email' == data.action) {
            contentService.setModal(data.message, 'none');
            $scope.toMain = true;
            $scope.finishButton = $scope.toMainMessage;
          }
          else {
            angular.element('#demo-kit-block').after($compile(data.content)($scope));
            angular.element('#form-ym-pay').submit();
          }
        }
        else {
          contentService.setModal(data.message, 'error');
        }
      });
    }
  };
});
