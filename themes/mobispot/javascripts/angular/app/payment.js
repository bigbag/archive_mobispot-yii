'use strict';

function PaymentCtrl($scope, $http, $compile) {

  $('#wallet').on('change', function() {
    $scope.payment.wallet = this.value ;
  });

  $scope.$watch('payment.summ', function(payment) {
    if ($scope.payment) {
      if ($scope.payment.summ && $scope.payment.summ>199){
        angular.element('#setPayment a').removeClass('button-disable');
      }
      else {
        angular.element('#setPayment a').addClass('button-disable');
      }
    }
  });

  $scope.addSumm = function(payment, e){
    if (payment.summ && payment.wallet && $scope.payment.summ>199){
      var paymentForm = angular.element(e.currentTarget).parent().parent();
      $http.post('/payment/wallet/addSumm', payment).success(function(data){
        if(data.error == 'no') {
          var order = data.order;
          angular.element('#unitell_shop_id').val(order.idShop);
          angular.element('#unitell_customer').val(order.idCustomer);
          angular.element('#unitell_order_id').val(order.idOrder);
          angular.element('#unitell_subtotal').val(order.subtotal);
          angular.element('#unitell_signature').val(order.signature);
          angular.element('#unitell_url_ok').val(order.return_ok);
          angular.element('#unitell_url_no').val(order.return_error);
          paymentForm.submit();
        }
      });
    }
  }

  $scope.setAction = function(action, e){
    $scope.action = action;
    var curent = angular.element(e.currentTarget).next();
    var all = angular.element('.corp-register-form');
    if (curent.hasClass('hide')) {
      all.slideUp('slow', function () {
        $(this).addClass('hide');
      });
      curent.slideToggle('slow', function () {
        $(this).removeClass('hide');
      });
      }
  }

  $scope.corpRegister = function(){
    if ($scope.action){
      if ($scope.action == 'connection') var params = $scope.connection;
      else if ($scope.action == 'rent') var params = $scope.rent;
      else if ($scope.action == 'self') var params = $scope.self;

      console.log($scope.self);
    }

  }

}