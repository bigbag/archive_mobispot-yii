'use strict';

angular.module('mobispot').controller('SpotController',
  function($scope, $http, $cookies, $compile, $timeout, contentService) {

/* Инициализация переменных */

  $scope.maxSize = 25*1024*1024;
  $scope.progress = 0;
  $scope.keys = [];
  $scope.action = false;

  $scope.error = {};
  $scope.result = {};

  $scope.spot = {};
  $scope.spot.discodes = 0;

  $scope.general = {};
  $scope.general.views = false;
  $scope.host_mobile = 0;

  $scope.wallet = {};
  $scope.wallet.cards = {};

  $scope.scroll_key = -1;

  $scope.actions = {};
  $scope.actions.page = '';
  $scope.actions.phrase = '';

/* CRUD для спота */

  //Тригер на снятие ошибки при изменении поля
  $scope.$watch('spot.code + spot.terms', function() {
    $scope.error.code = false;
    $scope.error.terms = false;
  });

  // Добавление спота
  $scope.addSpot = function(spot) {
    if (!spot.code || !$scope.spot.terms) return false;
    $http.post('/spot/add', spot).success(function(data) {
      if(data.error == 'no') {
        $scope.spot.discodes = data.discodes;
        angular.element('.spot-list').prepend($compile(data.content)($scope));
        angular.element('#actSpot').click();
        delete $scope.spot.code;
        delete $scope.spot.terms;
        if ($scope.general.host_mobile)
            window.location.href = 'http://' + window.location.hostname + '/spot/list';
      }else if (data.error == 'yes') {
        $scope.error.code = true;
      }
    });
  };

  //Управление основными блоками спот, кошелек, купоны.
  $scope.$watch('general.views + spot.discodes', function() {
    $cookies.spot_curent_discodes = $scope.spot.discodes;
    if ($scope.general.views != 'settings') {
      $cookies.spot_curent_views = $scope.general.views;
    }
    $scope.actions.page = '';

    if ($scope.general.views == 'spot'){
      $scope.viewSpot($scope.spot);
    } else if ($scope.general.views == 'wallet'){
      $scope.viewWallet($scope.spot);
    } else if ($scope.general.views == 'coupon'){
      $scope.viewCoupons($scope.spot, $scope.actions);
    } else if ($scope.general.views == 'settings'){
      $scope.viewsSettings($scope.spot);
    }
  });

  $scope.bodyMinHeight = function(){
    var listHeight = angular.element('.spot-list').height();
    angular.element('.spot-content').css('min-height', listHeight+200);
  };

  $scope.viewSpot = function (spot) {
    if (spot.discodes === 0) return false;

    var spot_block = angular.element('#spot-block');
    $http.post('/spot/view', spot).success(function(data) {
      if(data.error == 'no') {
        spot_block.empty();
        spot_block.html($compile(data.content)($scope));

        $scope.keys = [];
        $scope.content_iteration = 0;
        $scope.fileUploadInit();

        $scope.bodyMinHeight();
        angular.element('.spot-content_row').show().animate({
          opacity: 1
        },500);
        contentService.scrollPage('body');
      }
    });
  };

  // Добавление нового блока в спот
  $scope.addContent = function() {
    $scope.addValue($scope.spot.content);
  };

  // Добавление непривязанного к соцсетям контента
  $scope.addValue = function(newValue){
    $scope.spot.content = newValue;
    $http.post('/spot/spotAddContent', $scope.spot).success(function(data) {
      if(data.error == 'no') {
        angular.element('#add-content').append($compile(data.content)($scope));

        $scope.spot.keys.push(data.key);
        $scope.spot.content = '';
        angular.element('textarea').removeClass('put');

        if (angular.element('#extraMediaForm').hasClass('open'))
        {
              angular.element('#extraMediaForm').slideUp(0, function(){angular.element('#extraMediaForm a').removeClass('blackout');angular.element('#extraMediaForm a').fadeTo(0, 1);});
              angular.element('#extraMediaForm').removeClass('open');
        }

        var scroll_height = $('#block-' + data.key).offset().top;
        $('html, body').animate({
          scrollTop: scroll_height
        }, 600);
      }
    });
    $scope.resetCursor();
  };

  // Сохраняем порядок блоков
  $scope.saveOrder = function() {
    $http.post('/spot/saveOrder', $scope.spot).success(function(data) {
      if(data.error == 'no') {

      }
    });
  };

  // Параметры сортировки
  $scope.sortableOptions = {
    update: function() {
      $scope.saveOrder();
    },
    'containment':'.spot-content',
    'handle': '.move',
    'scrollSensitivity': 5,
    'tolerance': 'pointer',
    'opacity':0.8
  };

  // Удаление блока в споте
  $scope.removeContent = function(spot, key, e) {
    spot.key = key;
    $http.post('/spot/spotRemoveContent', spot).success(function(data) {
      if(data.error == 'no') {
        var spotItem = angular.element(e.currentTarget).parents('.spot-item');
        spotItem.remove();
        $scope.keys=data.keys;
        if (data.netDown)
            $scope.netDown(data.netDown);
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

  // Переименовываем спот
  $scope.renameSpot = function(spot) {
    if (!spot.name) return false;
    $http.post('/spot/rename', spot).success(function(data) {
      if(data.error == 'no') {
        angular.element('#' + spot.discodes + ' h3').text(spot.name);
      }
    });
  };

  // Очищаем спот
  $scope.cleanSpot = function(spot) {
    $http.post('/spot/clean', spot).success(function(data) {
      if(data.error == 'no') {
        $scope.general.views = 'spot';
      }
    });
  };

  // Удаляем спот
  $scope.removeSpot = function(spot) {
    $http.post('/spot/remove', spot).success(function(data) {
      if(data.error == 'no') {
        $(location).attr('href','/spot/list/');
      }
    });
  };

  // Меняем статус спота
  $scope.ivisibleSpot = function(spot) {
    $http.post('/spot/invisible', spot).success(function(data) {
      if(data.error == 'no') {
        $scope.spot.status = data.status;
        angular.element('#'+spot.discodes).toggleClass('invisible');
      }
    });
  };

  // Отображение окна настроек
  $scope.viewsSettings = function (spot) {
    var spot_block = angular.element('#spot-block');
    $http.post('/spot/settings', spot).success(function(data) {
      if (data.error == 'no'){
        spot_block.empty();
        spot_block.html($compile(data.content)($scope));
        $scope.bodyMinHeight();
        angular.element('.spot-content_row').show().animate({
          opacity: 1
        },500);
      }
    });
  };

  // Отображение кошелька
  $scope.viewWallet = function (spot) {
    var spot_block = angular.element('#spot-block');
    $http.post('/spot/wallet', spot).success(function(data) {
      if (data.error == 'no'){
        spot_block.empty();
        spot_block.html($compile(data.content)($scope));

        $scope.getListCard();

        $scope.bodyMinHeight();
        angular.element('.spot-content_row').show().animate({
          opacity: 1
        },500);
      } else {
        $scope.viewSpot($scope.spot);
      }
    });
  };


  // Отображение купонов
  $scope.viewCoupons = function (spot) {
    var spot_block = angular.element('#spot-block');
    $http.post('/spot/coupons', spot).success(function(data) {
      if (data.error == 'no'){
        spot_block.empty();
        spot_block.html($compile(data.content)($scope));
        $scope.bodyMinHeight();
        angular.element('.spot-content_row').show().animate({
          opacity: 1
        },500);
      }
    });
  };

  //Cписок купонов
  $scope.listCoupons = function (spot, actions) {
    if (!actions.page) return false;
    var list = angular.element('#coupons-list');

    var data = {'discodes': spot.discodes, 'token': spot.token, 'page': actions.page, 'phrase': actions.phrase};

    $http.post('/spot/listCoupons', data).success(function(data) {
      if (data.error == 'no'){

        list.empty();
        list.html($compile(data.content)($scope));

      }
    });

  };

  // Список карт
  $scope.getListCard = function(){
    if ($scope.general.views != 'wallet') return false;
    $http.post('/spot/listCard', $scope.wallet).success(function(data) {
      if (data.error == 'no'){
        $scope.wallet.cards = data.cards;
        $scope.wallet.cards_count = data.cards_count;
        $scope.wallet.linking_card = data.linking_card;
      }
    });
    $timeout(function(){
       $scope.getListCard();
   }, 5000);
  };

  // Блокировка кошелька
  $scope.blockedWallet = function(){
    $http.post('/spot/blockedWallet', $scope.wallet).success(function(data) {
      if (data.error == 'no'){
        $scope.wallet.status = data.status;
      }
    });
  };

  // Отправка запроса на привязку карты
  $scope.linkingCard = function(card){
    if (!card.terms) return false;
    $( "#linking_card" ).submit();
  };

  // Делаем карту платежной
  $scope.setPaymentCard = function(card_id, e){
    var data = {'token': $scope.spot.token, 'card_id': card_id};
    $http.post('/spot/setPaymentCard', data).success(function(data) {
      if (data.error == 'no'){
        angular.element('.main-card').removeClass('main-card');
        angular.element(e.currentTarget).parent().parent().addClass('main-card');
      }
    });
  };

  $scope.editCardList = function(){
    $('.table-card').toggleClass('edit');

    if ($scope.wallet.card_edit === 0) {
      $scope.wallet.card_edit = 1;
    } else {
      $scope.wallet.card_edit = 0;
    }
  };

  // Удаляем карту
  $scope.removeCard = function(card_id){
    var data = {'token': $scope.spot.token, 'card_id': card_id};
    $http.post('/spot/removeCard', data).success(function(data) {
      if (data.error == 'no'){
        $scope.wallet.cards_count -= 1;
        delete $scope.wallet.cards[card_id];
      }
    });
  };

  // Счетчик на странице соглашения об оплате
  var stopped;
  $scope.countReset = function() {
    $scope.reset_time = typeof $scope.reset_time !== 'undefined' ? $scope.reset_time:30;
    stopped = $timeout(function() {
      if ($scope.reset_time === 0) {
        $(location).attr('href',window.location.pathname);
      } else $scope.reset_time--;
      $scope.countReset();
    }, 1000);
  };


/*Загрузка файлов */

  // Вешаем обработчики для загрузки файлов
  $scope.fileUploadInit = function () {
    var file_drag = document.getElementById('dropbox');
    var file_button = document.getElementById('add-file');
    if (file_drag && file_button) {
      var xhr = new XMLHttpRequest();
      if (xhr.upload) {
        file_drag.addEventListener("dragover", fileDragHover, false);
        file_drag.addEventListener("dragleave", fileDragHover, false);
        file_drag.addEventListener("drop", fileSelectHandler, false);
        file_button.addEventListener('change', fileSelectHandler, false);
      }
    }
  };

  // Закачка файла html5
  function fileDragHover(e) {
    e.stopPropagation();
    e.preventDefault();
    if (e.type == "dragover"){
      angular.element('#dropbox').addClass("hover");
    }else {
      angular.element('#dropbox').removeClass("hover");
    }
  }


  function fileSelectHandler(e) {
    fileDragHover(e);
    var files = e.target.files || e.dataTransfer.files;

    for (var i = 0, f; f = files[i]; i++) {
      $scope.uploadFile(f);
    }
  }

  // Отображаем прогресс бар и пролистываем экран к новому блоку
  $scope.uploadComplete = function(e) {
    var result = e.target.responseText;
    if (result){
      var data = angular.fromJson(result);
      if(data.error == 'no') {
        angular.element('#progress-content').hide();
        angular.element('#add-content').append($compile(data.content)($scope));
        $scope.keys.push(data.key);

        angular.element('#add-file').val('');

        var scroll_height = $('#block-' + data.key).offset().top;
        $('html, body').animate({
          scrollTop: scroll_height
        }, 600);
      }
    }
  };

  // Случайным образом генерируем значение для эффекта загрузки
  function uploadProgress(evt) {
    $scope.$apply(function(){
      if (evt.lengthComputable) {
          $scope.progress = Math.round(evt.loaded * 100 / evt.total);
      } else {
          $scope.progress = 'unable to compute';
      }
    });
  }

  // Действие если загрузка не удалась
  $scope.uploadFailed = function() {
    angular.element('#error-upload').show().delay(800).slideUp('slow');
  };

  $scope.uploadFile = function(file) {

    var xhr = new XMLHttpRequest();
    if (xhr.upload && file.size <= $scope.maxSize) {
      angular.element('#progress-content').show();

      xhr.upload.onprogress = function(e) {
        if (e.lengthComputable) {
          $scope.progress = Math.round(e.loaded * 100 / e.total);
        } else {
          $scope.progress = 'unable to compute';
        }
      };

      xhr.upload.addEventListener('progress', uploadProgress, false);
      xhr.addEventListener('error', $scope.uploadFailed, false);
      xhr.addEventListener('load', $scope.uploadComplete, false);
      xhr.open('POST', '/spot/upload', true);
      xhr.setRequestHeader('X-File-Name', unescape(encodeURIComponent(file.name)));
      xhr.setRequestHeader('X-Discodes', $scope.spot.discodes);
      xhr.send(file);
    }
  };

/* Соц сети */

  //подгрузка блока с контентом соцсети
  $scope.loadSocContent = function(key)
  {
    var data = {discodes:$scope.spot.discodes, key:key, token:$scope.user.token};

    $http.post('/spot/SocNetContent', data).success(function(data) {
      if(data.error == 'no'){
            var spotEdit = angular.element('#block-' + data.key);
            var oldHeight = spotEdit.height();
            var oldScroll = spotEdit.offset().top;

            spotEdit.before($compile(data.content)($scope));
            spotEdit.remove();
            $scope.setVideoSize(data.key);
            if (oldScroll < $('html, body').scrollTop()) {
                var scroll_height = $('html, body').scrollTop() +
                                    $('#block-' + data.key).height() -
                                    oldHeight;

                $('html, body').animate({
                    scrollTop: scroll_height
                }, 0);
            }
        }
      });
  };

  //установить подсветку кнопки соцсети
  $scope.netCheck = function(netName) {
    var data = {token:$scope.user.token, netName:netName};
    $http.post('/spot/netCheck', data).success(function(data) {
      if (data.error == 'no') {
        var button = angular.element("#extraMediaForm a[net='" + data.netName + "']");
        if (data.binded)
          button.addClass('binded');
        else
          button.removeClass('binded');
      }
    });
  };

  //подсветить кнопку соцсети
  $scope.netUp = function(netName) {
    var button = angular.element("#extraMediaForm a[net='" + netName + "']");
    button.addClass('binded');
  };

  //погасить кнопку соцсети
  $scope.netDown = function(netName) {
    var button = angular.element("#extraMediaForm a[net='" + netName + "']");
    button.removeClass('binded');
  };

  // Привязка соцсетей
  var popup;
  var socTimer;
  var likeTimer;

  //через плашку
  $scope.bindByPanel = function(buttonName) {
    var netName = buttonName;
    var data = {spot: $scope.spot, token:$scope.user.token, netName:netName};
    //определение сети по ссылке
    if ('undefined' != typeof ($scope.spot.content) && $scope.spot.content.length)
    {
        data.link = $scope.spot.content;
        for (var i = 0; i < $scope.soc_patterns.length; i++)
        {
            if ($scope.spot.content.indexOf($scope.soc_patterns[i].baseUrl) != -1)
            {
                netName = $scope.soc_patterns[i].name;
                data.netName = $scope.soc_patterns[i].name;
                break;
            }
        }

    }

    $http.post('/spot/BindByPanel', data).success(function(data) {
        if(data.error == 'no') {
            if(data.profileHint.length === 0)
            {
                if (!data.loggedIn) {
                    var options = $.extend({
                      id: '',
                      popup: {
                        width: 450,
                        height: 380
                      }
                    }, options);

                    var redirect_uri = 'http://' + window.location.hostname + '/user/BindSocLogin?service=' + netName;
                    var url = redirect_uri;

                    url += url.indexOf('?') >= 0 ? '&' : '?';
                    if (url.indexOf('redirect_uri=') === -1)
                      url += 'redirect_uri=' + encodeURIComponent(redirect_uri);

                    var centerWidth = (window.screen.width - options.popup.width) / 2,
                      centerHeight = (window.screen.height - options.popup.height) / 2;

                    if (!$scope.general.host_mobile) {
                        popup = window.open(url + '&js', "yii_eauth_popup", "width=" + options.popup.width + ",height=" + options.popup.height + ",left=" + centerWidth + ",top=" + centerHeight + ",resizable=yes,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=yes");
                    }

                    if (popup === null || typeof(popup)=='undefined') {
                        var href = url + '&discodes=' + $scope.spot.discodes + '&newField=1' + '&synch=true';

                        if (typeof $scope.spot.content !== 'undefined' && $scope.spot.content.length)
                            href += '&link=' + encodeURIComponent($scope.spot.content);

                        window.location.href = href;
                    }
                    else {
                        popup.focus();

                        $scope.bindNet = {name:data.socnet, discodes:$scope.spot.discodes, newField:1};
                        if ('undefined' != typeof ($scope.spot.content) && $scope.spot.content.length)
                            $scope.bindNet.link = $scope.spot.content;
                        socTimer = $timeout($scope.loginTimer, 1000);
                    }
                }
                else
                {
                    if(data.linkCorrect == 'ok')
                    {

                        angular.element('#add-content').append($compile(data.content)($scope));

                        $scope.keys.push(data.key);
                        $scope.spot.content='';
                        angular.element('textarea').removeClass('put');
                        $scope.resetCursor();

                        $scope.setVideoSize(data.key);
                        var scroll_height = $('#block-' + data.key).offset().top;
                        $('html, body').animate({
                            scrollTop: scroll_height
                        }, 600);

                        $scope.netUp(data.socnet);
                        var currentNet = $scope.getPatternInd(data.socnet);
                        if (currentNet > -1)
                            $scope.soc_patterns[currentNet].BindByPaste = true;
                    }
                }
            }
        }
    });
  };

  //возврашает индекс соцсети в скопе по имени
  $scope.getPatternInd = function(netName){
      var currentNet = -1;
      for (var i = 0; i < $scope.soc_patterns.length; i++)
      {
          if ($scope.soc_patterns[i].name == netName)
          {
              currentNet = i;
              break;
          }
      }
      return currentNet;
  };

  //привязка по кнопке
  $scope.bindSocial  = function(spot, key, e) {
    var spotEdit = angular.element(e.currentTarget).parents('.spot-item');
    spot.key = key;
    $http.post('/spot/bindSocial', spot).success(function(data) {
      if(data.error == 'no') {
        if((data.socnet != 'no') && (data.socnet.length > 0)){
          if (!data.loggedIn) {
            var options = $.extend({
              id: '',
              popup: {
                width: 450,
                height: 380
              }
            }, options);

            var redirect_uri = 'http://' + window.location.hostname + '/user/BindSocLogin?service=' + data.socnet;
            var url = redirect_uri;

            url += url.indexOf('?') >= 0 ? '&' : '?';
            if (url.indexOf('redirect_uri=') === -1)
              url += 'redirect_uri=' + encodeURIComponent(redirect_uri);

            var centerWidth = (window.screen.width - options.popup.width) / 2,
              centerHeight = (window.screen.height - options.popup.height) / 2;

            popup = window.open(url + '&js', "yii_eauth_popup", "width=" + options.popup.width + ",height=" + options.popup.height + ",left=" + centerWidth + ",top=" + centerHeight + ",resizable=yes,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=yes");

            if (popup === null || typeof(popup)=='undefined') {
                window.location.href = url + '&discodes=' + spot.discodes + '&key=' + spot.key + '&synch=true';
            }
            else {
                popup.focus();

                $scope.bindNet = {name:data.socnet, discodes:spot.discodes, key:spot.key, spotEdit:angular.element(e.currentTarget).parents('.spot-item')};
                socTimer = $timeout($scope.loginTimer, 1000);
            }
          }
          else {
            if(data.linkCorrect == 'ok')
            {
                spotEdit.before($compile(data.content)($scope));
                spotEdit.remove();
                var currentNet = $scope.getPatternInd(data.socnet);
                if (currentNet > -1)
                    $scope.soc_patterns[currentNet].BindByPaste = true;
                $scope.setVideoSize(spot.key);
                $scope.netUp(data.socnet);
            }
            else
            {
                contentService.setModal(data.linkCorrect, 'none');
            }
          }
        }else if(data.linkCorrect != 'ok'){
            contentService.setModal(data.linkCorrect, 'none');
        }
      }
    });
  };

  //подключение акции, требующей жетона соцсети
  $scope.checkLike = function(e, id_action)
  {
      var data = {token: $scope.user.token, id:id_action, discodes:$scope.spot.discodes};
      var act;
      $http.post('/user/checkLike', data).success(function(data) {

          if ('no' == data.error)
          {
              if (!data.isSocLogged)
              {
                  var options = $.extend({
                    id: '',
                    popup: {
                      width: 450,
                      height: 380
                    }
                  }, options);

                  var redirect_uri = 'http://' + window.location.hostname + '/user/BindSocLogin?service=' + data.service;
                  var url = redirect_uri;

                  url += url.indexOf('?') >= 0 ? '&' : '?';
                  if (url.indexOf('redirect_uri=') === -1)
                    url += 'redirect_uri=' + encodeURIComponent(redirect_uri) + '&';
                  url += 'js';

                  var centerWidth = (window.screen.width - options.popup.width) / 2,
                    centerHeight = (window.screen.height - options.popup.height) / 2;

                  if (!$scope.general.host_mobile) {
                    popup = window.open(url, 'yii_eauth_popup', 'width=' + options.popup.width + ',height=' + options.popup.height + ',left=' + centerWidth + ',top=' + centerHeight + ',resizable=yes,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=yes');
                  }

                  if (popup === null || typeof(popup)=='undefined') {
                    var href = url + '&discodes=' + $scope.spot.discodes + '&chek_like=' + id_action;

                    window.location.href = href;
                  }
                  else {
                    popup.focus();

                    $scope.checkingAction = {id:id_action};
                    $scope.actionDiv = angular.element(e.currentTarget).parent().parent('div.spot-item');
                    likeTimer = $timeout($scope.likesTimer, 1000);
                  }
              }
              else
              {
                  if ('undefined' != typeof (data.message_error) && 'undefined' != typeof (data.message))
                  {
                      if ('yes' == data.message_error)
                          contentService.setModal(data.message, 'error');
                      else
                          contentService.setModal(data.message, 'none');
                  }

                  if ('undefined' != typeof (data.content))
                  {
                    if (!$scope.general.host_mobile)
                      act = angular.element(e.currentTarget).parent().parent('div.spot-item');
                    else
                      act = angular.element(e.currentTarget).parent().parent().parent().parent();

                    act.before($compile(data.content)($scope));
                    act.remove();
                  }
              }
          }
      });
  };

    $scope.likesTimer = function()
    {
      if (!popup.closed) {
          var data = {token: $scope.user.token, id:$scope.checkingAction.id, discodes:$scope.spot.discodes};
          $http.post('/user/checkLike', data).success(function(data) {
              if ('undefined' != typeof (data.isSocLogged))
              {
                  if (data.isSocLogged)
                  {
                      popup.close();
                      $scope.bindNet = {};

                      if ('undefined' != typeof (data.message_error) && 'undefined' != typeof (data.message))
                      {
                          if ('yes' == data.message_error)
                              contentService.setModal(data.message, 'error');
                          else
                              contentService.setModal(data.message, 'none');
                      }
                      if ('undefined' != typeof (data.content) && 'undefined' != typeof ($scope.actionDiv))
                      {
                        $scope.actionDiv.before($compile(data.content)($scope));
                        $scope.actionDiv.remove();
                      }
                  }
                  else
                  {
                      likeTimer = $timeout($scope.likesTimer, 1000);
                  }
              }
          });
      }
    };

    $scope.disableAction = function(e, id_action)
    {
        var data = {token: $scope.user.token, id:id_action, discodes:$scope.spot.discodes};
        var act;
        $http.post('/user/disableLoyalty', data).success(function(data) {
            if ('no' == data.error)
            {
                if (!$scope.general.host_mobile)
                    act = angular.element(e.currentTarget).parent().parent('div.spot-item');
                else
                    act = angular.element(e.currentTarget).parent().parent().parent().parent();

                act.before($compile(data.content)($scope));
                act.remove();
            }
        });
    };

    //привязка соцсети и закрытие попапа, если пользователь залогинился через соцсеть
    $scope.loginTimer = function()
    {
        if (!popup.closed) {
            var netParams = {name:$scope.bindNet.name, discodes:$scope.bindNet.discodes, key:$scope.bindNet.key};
            if ('undefined' != typeof ($scope.bindNet.newField) && 1 == $scope.bindNet.newField)
                netParams.newField = 1;
            if ('undefined' != typeof ($scope.bindNet.link) && $scope.bindNet.link.length)
                netParams.link = $scope.bindNet.link;

            var data = {token: $scope.user.token, bindNet:netParams};
            $http.post('/spot/bindedContent', data).success(function(data) {
                if (typeof (data.loggedIn) != 'undefined' && typeof (data.linkCorrect) != 'undefined')
                {
                    if (data.loggedIn)
                    {
                        popup.close();
                        if(data.linkCorrect == 'ok')
                        {
                            if (data.newField)
                            {
                                angular.element('#add-content').append($compile(data.content)($scope));

                                $scope.keys.push(data.key);
                                $scope.spot.content='';
                                angular.element('textarea').removeClass('put');

                                $scope.resetCursor();

                                $scope.netUp(data.socnet);
                                $scope.setVideoSize(data.key);
                                var scroll_height = $('#block-' + data.key).offset().top - 100;
                                $('html, body').animate({
                                    scrollTop: scroll_height
                                }, 600);
                            }
                            else
                            {
                                var spotEdit = $scope.bindNet.spotEdit;
                                spotEdit.before($compile(data.content)($scope));
                                spotEdit.remove();
                                $scope.setVideoSize(data.key);
                                $scope.netUp(data.socnet);
                            }

                            $scope.bindNet = {};
                            var currentNet = $scope.getPatternInd(data.socnet);
                            if (currentNet > -1)
                                $scope.soc_patterns[currentNet].BindByPaste = true;

                        }
                        else
                        {
                            contentService.setModal(data.linkCorrect, 'none');
                        }
                    }
                    else
                        socTimer = $timeout($scope.loginTimer, 1000);
                }
            });
        }
    };

  //Отвязка соцсети
  $scope.unBindSocial  = function(spot, key, e) {
    spot.key = key;
    $http.post('/spot/UnBindSocial', spot).success(function(data) {
      if(data.error == 'no') {
        var spotEdit = angular.element(e.currentTarget).parents('.spot-item');
        spotEdit.before($compile(data.content)($scope));
        spotEdit.remove();
        if (data.netDown)
            $scope.netDown(data.netDown);
      }
    });

  };

  $scope.getSocPatterns = function(){
    $scope.freeSocial = true;
    if (typeof ($scope.soc_patterns) == 'undefined')
    {
      var data = {token:$scope.user.token};
      $http.post('/spot/SocPatterns', data).success(function(data) {
          $scope.soc_patterns = data.soc_patterns;
          for (var i = 0; i < $scope.soc_patterns.length; i++)
          {
              if (typeof ($scope.soc_patterns[i].BindByPaste) == 'undefined')
                  $scope.soc_patterns[i].BindByPaste = false;
          }
      });
    }
  };

  //установка размер проигрывателя YouTube или Vimeo
  $scope.setVideoSize = function(blockKey)
  {
      if (angular.element('#block-' + blockKey + ' .video-vimeo').length == 1)
      {
          var player = angular.element('#block-' + blockKey + ' .video-vimeo');
          player.css('width', '100%');
          player.css('height', (parseInt(player.css('width'), 10) / player.attr('rel') + 'px'));
      }/*
      else if (angular.element('#block-' + blockKey + ' .yt_player').length == 1)
      {
          var player = angular.element('#block-' + blockKey + ' .yt_player');
          player.css('width', '100%');
          player.css('height', (parseInt(player.css('width'), 10) / player.attr('rel') + 'px'));
      }*/
  };

  $scope.setNewPass = function(spot)
  {
      $http.post('/spot/setSpotPass', spot).success(function(data) {
          if (data.error == 'no' && typeof (data.saved) != 'undefined') {
              angular.element('#savePassButton').text(data.saved);
              if (typeof ($scope.spot.pass) != 'undefined' && spot.pass.length)
                  angular.element('#resetPassButton').show();
              else
                  angular.element('#resetPassButton').hide();
          }
          else if (data.error == 'yes') {
              angular.element('#setPassForm input[name=newPass]').addClass('error');
          }
      });
  };

  $scope.resetPass = function(spot)
  {
      spot.pass = '';
      $scope.setNewPass(spot);
  };

  $scope.savePassButtonText = function(text)
  {
      angular.element('#savePassButton').text(text);
      angular.element('#setPassForm input[name=newPass]').removeClass('error');
  };

  $scope.checkStatusSpot = function() {
    return true;
  };

  $scope.resetCursor = function()
  {
      if ('undefined' != typeof ($scope.cursorBody) && $scope.cursorBody.length)
      {
          angular.element('body').css('cursor', $scope.cursorBody);
          delete $scope.cursorBody;
      }
      else
          angular.element('body').css('cursor', 'default');

      if ('undefined' != typeof ($scope.cursorTextarea) && $scope.cursorTextarea.length)
      {
          angular.element('#dropbox textarea').css('cursor', $scope.cursorTextarea);
          delete $scope.cursorTextarea;
      }
      else
          angular.element('#dropbox textarea').css('cursor', 'text');
  };

  //изменение страницы фильтра купонов
  $scope.$watch('actions.page', function() {
    $scope.listCoupons($scope.spot, $scope.actions);
  });

});