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
        $scope.toKey(data.key);
      }
    });
  };

  $scope.toKey = function(key)
  {
    var block = $('#block-' + key);
    if (block.length) {
      var scroll_height = block.offset().top;
      $('html, body').animate({
        scrollTop: scroll_height
      }, 600);
    }
  }

  // Удаление блока в споте
  $scope.removeContent = function(spot, key, e) {
    spot.key = key;
    $http.post('/spot/spotRemoveContent', spot).success(function(data) {
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
                var redirect_uri = 'http://' + window.location.hostname + '/service/socLogin?service=' + netName;
                var url = redirect_uri;

                url += url.indexOf('?') >= 0 ? '&' : '?';
                if (url.indexOf('redirect_uri=') === -1)
                  url += 'redirect_uri=' + encodeURIComponent(redirect_uri);


                var href = url + '&discodes=' + $scope.spot.discodes + '&newField=1' + '&synch=true';

                if (typeof $scope.spot.content !== 'undefined' && $scope.spot.content.length)
                    href += '&link=' + encodeURIComponent($scope.spot.content);

                window.location.href = href;
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

  // Редактирование текстового блока в споте
  $scope.editContent = function(spot, key, e) {
    if (!spot.content_new){
      spot.key = key;
      var spotItem = angular.element(e.currentTarget).parents('.spot-item');
      var spotEdit = angular.element('#spot-edit').clone();

      if (spotItem.find('a.type-link').size() > 0){
          //ссылка
          var spotLink = spotItem.find('a.type-link');
          $scope.spot.content_new = spotLink.find('span.link').text();
      }else{
          //текст
          var spotData = spotItem.find('p.item-type__text');
          $scope.spot.content_new = spotData.text();
      }

      spotEdit.removeClass('hide');
      spotEdit.find('textarea').focus(1);
      spotItem.hide().before($compile(spotEdit)($scope));
    }else {
      $scope.hideSpotEdit();
    }
  };

  // Сохранение текстового блока в споте
  $scope.saveContent = function(spot, e) {
    var spotEdit = angular.element(e.currentTarget).parents('.spot-item');
    var spotItem = spotEdit.next();

    $http.post('/spot/spotSaveContent', spot).success(function(data) {
      if(data.error == 'no') {
        spotEdit.before($compile(data.content)($scope));
        spotEdit.remove();
        spotItem.remove();
      }
      else {
        spotEdit.remove();
        spotItem.show();
      }
      delete $scope.spot.content_new;
    });
  };

  // Прячем текстовый блок при клике вне, данные сохраняем
  $scope.hideSpotEdit = function() {
    if (!$scope.spot.content && !$scope.spot.content_new) return false;

    var spotEdit = angular.element('#spot-edit');
    var spotItem = spotEdit.next();

    $http.post('/spot/spotSaveContent', $scope.spot).success(function(data) {
      if(data.error == 'no') {
        spotEdit.before($compile(data.content)($scope));
        spotEdit.remove();
        spotItem.remove();
      }
      else {
        spotEdit.remove();
        spotItem.show();
      }
      delete $scope.spot.content_new;
    });
  };

});