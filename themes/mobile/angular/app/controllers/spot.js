'use strict';

angular.module('mobispot').controller('SpotController',
  function($scope, $http, $compile, $timeout) {

/* Инициализация переменных */

  $scope.keys = [];

  $scope.error = {};
  $scope.result = {};

  $scope.spot = {};
  $scope.spot.discodes = 0;

  $scope.general = {};
  $scope.general.views = false;

  //Управление основными блоками спот, кошелек, купоны.
  $scope.$watch('general.views + spot.discodes', function() {
    if ($scope.general.views == 'spot'){
      $scope.viewSpot($scope.spot);
    } else if ($scope.general.views == 'wallet'){
      $scope.viewWallet($scope.spot);
    } else if ($scope.general.views == 'coupon'){
      $scope.viewCoupons($scope.spot);
    } else if ($scope.general.views == 'settings'){
      $scope.viewsSettings($scope.spot);
    }
  });
  
  // Отображение контента спота
  $scope.viewSpot = function (spot) {
    if (spot.discodes === 0) return false;

    var spot_block = angular.element('#spot-block');
    
    $http.post('/spot/spotContent', spot).success(function(data) {
      if(data.error == 'no') {
        spot_block.empty();
        spot_block.html($compile(data.content)($scope));
      }
    });
  };
  
  // Отображение кошелька
  $scope.viewWallet = function (spot) {
  
  };

    // Отображение купонов
  $scope.viewCoupons = function (spot) {

  };
  
  // Отображение настроек
  $scope.viewsSettings = function (spot) {
    
  };
  
  //подгрузка блока с контентом соцсети
  $scope.loadSocContent = function(key)
  {
    var data = {discodes:$scope.spot.discodes, key:key, token:$scope.spot.token};

    $http.post('/spot/socNetContent', data).success(function(data) {
      if(data.error == 'no'){
            var spotEdit = angular.element('#block-' + data.key);
            spotEdit.before($compile(data.content)($scope));
            spotEdit.remove();
        }
      });
  };

  // Добавление нового блока в спот
  $scope.addContent = function() {
    if ($scope.spot.content.length)
      $scope.addValue($scope.spot.content);
  };

  // Добавление непривязанного к соцсетям контента
  $scope.addValue = function(newValue){
    $scope.spot.content = newValue;
    $http.post('/spot/spotAddContent', $scope.spot).success(function(data) {
      if(data.error == 'no') {
        angular.element('#add-content').append($compile(data.content)($scope));

        $scope.keys.push(data.key);
        $scope.spot.content = '';
        
        var scroll_height = $('#block-' + data.key).offset().top;
        $('html, body').animate({
          scrollTop: scroll_height
        }, 600);
      }
    });
  };

  // Удаление блока в споте
  $scope.removeContent = function(spot, key, e) {
    spot.key = key;
    $http.post($scope.desctopHost() + '/spot/spotRemoveContent', spot).success(function(data) {
      if(data.error == 'no') {
        var spotItem = angular.element(e.currentTarget).parents('.spot-item');
        spotItem.remove();
        $scope.keys=data.keys;
        //if (data.netDown)
          //  $scope.netDown(data.netDown);
      }
    });
  };

  // Привязка соцсетей
  $scope.bindByPanel = function(buttonName) {
    var netName = buttonName;
    var data = {spot: $scope.spot, token:$scope.spot.token, netName:netName};
    $http.post('/spot/bindByPanel', data).success(function(data) {
        if(data.error == 'no') {
            if (!data.loggedIn) {
                var redirect_uri = 'http://' + window.location.hostname + '/user/BindSocLogin?service=' + netName;
                var url = redirect_uri;

                url += url.indexOf('?') >= 0 ? '&' : '?';
                if (url.indexOf('redirect_uri=') === -1)
                  url += 'redirect_uri=' + encodeURIComponent(redirect_uri);

                window.location.href = url + '&discodes=' + $scope.spot.discodes + '&link=' + encodeURIComponent($scope.spot.content) + '&newField=1' + '&synch=true' + '&return_host=' + encodeURIComponent(window.location.protocol + '//' +
                window.location.hostname);
            }
            else
            {
                if(data.linkCorrect == 'ok')
                {
                    angular.element('#add-content').append($compile(data.content)($scope));

                    $scope.keys.push(data.key);
                    $scope.spot.content='';

                    var scroll_height = $('#block-' + data.key).offset().top;
                    $('html, body').animate({
                        scrollTop: scroll_height
                    }, 600);

                   // $scope.netUp(data.socnet);
                }
            }
        }
    });
  };
  
  $scope.desctopHost = function()
  {
      var hostname = window.location.hostname;
      if (hostname.indexOf('m.') != -1)
        hostname = hostname.replace('m.', '');
      
      return 'http://' + hostname;
  }
  
});