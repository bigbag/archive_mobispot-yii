'use strict';

angular.module('mobispot').controller('PaymentController',
  function($scope, $http, $compile, $timeout, contentService) {

  $scope.card = 1;
  $scope.history = [];

  $('#wallet').on('change', function() {
    $scope.payment.wallet = this.value ;
  });


  $scope.accordion = function(e, payment) {
    var spot = angular.element(e.currentTarget).parent();
    var id = spot.attr('id');
    var spotContent = spot.find('.slide-content');
    var spotHat = spot.find('.spot-hat');

    $scope.payment.wallet_id = id;
    $scope.keys = [];
    if (spotContent.attr('class') == null) {
      $http.post('/corp/wallet/getView', payment).success(function(data) {
          if(data.error == 'no') {
            var oldSpotContent = angular.element('.slide-content');
            angular.element('.spot-content_li').removeClass('open');
            oldSpotContent.slideUp('slow', function () {
              oldSpotContent.remove();
            });

            spotHat.after($compile(data.content)($scope));
            spot.addClass('open');
            spot.find('.slide-content').slideToggle('slow');

            angular.element('.slide-content').foundation('forms');
            $('#filter-date').datepicker();
            $('#filter-date').datepicker("option", "dateFormat", "dd.mm.yy");
            $('#ui-datepicker-div').slideUp(0);
            angular.element('#j-settingsForm').addClass('slide-content');
          }
      });
    }
    else {
      delete $scope.payment.amount;
      spot.removeClass('open');
      spotContent.slideUp('slow',
        function () {
          spotContent.remove();
        });
    }
  }

  $scope.block = function(id){
    var payment = $scope.payment;
    payment.id=id;
    $http.post('/corp/wallet/blockWallet', payment).success(function(data) {
      if(data.error == 'no') {
        angular.element('#block-button').text(data.content);
        angular.element('#block-button').toggleClass('red-button green-button');
        angular.element('li#'+id).toggleClass('invisible-spot');
        $scope.recurrent.terms = 0;
        angular.element('a.checkbox.agree').removeClass('active');
        angular.element('#buttonApayOn').addClass('button-disable');
        $scope.payment.status=data.status;
      }
    });
  };

  $scope.getHistory = function(wallet_id, page, newFilter)
  {
    var newFilter = newFilter || 0;

    if (newFilter){
        $scope.history.term = angular.element('#block-history input[name=term]').val();
        $scope.history.date = angular.element('#block-history input[name=date]').val();
    }
    var data = {token: $scope.user.token, id:wallet_id, page:page};
    if (typeof ($scope.history.term) != 'undefined')
        data.term = $scope.history.term;
    if (typeof ($scope.history.date) != 'undefined')
        data.date = $scope.history.date;
    angular.element('#block-history .m-table-wrapper').addClass('loading');
    $http.post('/corp/wallet/getHistory', data).success(function(data) {
        if(data.error == 'no') {
            angular.element('#table-history tbody').html($compile(data.content)($scope));
            angular.element('#block-history .m-table-wrapper').removeClass('loading');
        }
    }).error(function(error){
        angular.element('#block-history .m-table-wrapper').removeClass('loading');
        console.log(error);
    });
  }
});