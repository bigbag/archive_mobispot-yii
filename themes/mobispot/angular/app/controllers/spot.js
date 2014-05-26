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
  $scope.wallet = {};

  $scope.scroll_key = -1;

  var renameSpot = angular.element('.rename-spot');
  var confirm = angular.element('.confirm');
  var toggle_box = angular.element('.toggle-box');

/* CRUD для спота */

  //Тригер на снятие ошибки при изменении поля
  $scope.$watch('spot.code + spot.terms', function(spot) {
    $scope.error.code = false;
    $scope.error.terms = false;
  });

  // Добавление спота
  $scope.addSpot = function(spot) {
    if (!spot.code | ($scope.spot.terms == 0)) return false;
    $http.post('/spot/addSpot', spot).success(function(data) {
      if(data.error == 'no') {
        var spotAdd = angular.element('#actSpotForm')
        angular.element('.spot-list').append($compile(data.content)($scope));
        spotAdd.find('a.checkbox').toggleClass('active');
        spotAdd.hide();
        delete $scope.spot.code;
      }else if (data.error == 'yes') {
        $scope.error.code = true;
      }
    });
  };

  //Управление основными блоками спот, кошелек, купоны.
  $scope.$watch('general.views + spot.discodes', function() {
    $cookies.spot_curent_discodes = $scope.spot.discodes;
    $cookies.spot_curent_views = $scope.general.views;

    if ($scope.general.views == 'spot'){
      $scope.viewSpot($scope.spot);
    } else if ($scope.general.views == 'wallet'){
      $scope.viewWallet($scope.spot);
    }
  });

  $scope.viewSpot = function (spot) {
    if (spot.discodes == 0) return false;

    var spot_block = angular.element('#spot-block');

    $http.post('/spot/viewSpot', spot).success(function(data) {
      if(data.error == 'no') {
        spot_block.empty();
        spot_block.html($compile(data.content)($scope));

        $scope.keys = [];
        $scope.content_iteration = 0;

        $scope.fileUploadInit();

        angular.element('.spot-content_row').show().animate({
          opacity: 1
        },500);
      }
    });
  };

  // Анимация смены спота
  $scope.animateSpotSwitching = function () {
    var speed = 400;
    var spot_wrapper = angular.element('.spot-wrapper');

      spot_wrapper.stop().animate({
        opacity: 0
      },speed/2,function(){
        spot_wrapper.addClass('active').animate({
          opacity: 1
        },speed)
      });
  };

  // Добавление нового блока в спот
  $scope.addContent = function(spot) {
    $scope.SocNetTooltip(false);
    var currentNet = -1;

    for (var i = 0; i < $scope.soc_patterns.length; i++){
        if ($scope.spot.content.indexOf($scope.soc_patterns[i].baseUrl) != -1){
            currentNet = i;
            break;
        }
    }
    if (currentNet > -1 && $scope.soc_patterns[currentNet].BindByPaste){
        $scope.cursorWait();
        $scope.bindByPanel($scope.soc_patterns[currentNet].name);
    }else{
      $scope.addValue($scope.spot.content);
    }

  };

  // Добавление непривязанного к соцсетям контента
  $scope.addValue = function(newValue){
    $scope.spot.content = newValue;
    $http.post('/spot/spotAddContent', $scope.spot).success(function(data) {
      if(data.error == 'no') {
        angular.element('#add-content').append($compile(data.content)($scope));

        $scope.keys.push(data.key);
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
  }

  // Удаление блока в споте
  $scope.removeContent = function(spot, key, e) {
    spot.key = key;
    $http.post('/spot/spotRemoveContent', spot).success(function(data) {
      if(data.error == 'no') {
        var spotItem = angular.element(e.currentTarget).parents('.spot-item');
        spotItem.remove();
        $scope.keys=data.keys;
      }
    });
  };

  // Редактирование текстового блока в споте
  $scope.editContent = function(spot, key, e) {
    spot.key = key;
    if (!spot.content_new){

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

  $scope.viewWallet = function (spot) {
    var spot_block = angular.element('#spot-block');
    $http.post('/spot/wallet', spot).success(function(data) {
      if (data.error == 'no'){
        spot_block.empty();
        spot_block.html($compile(data.content)($scope));
        angular.element('.spot-content_row').show().animate({
          opacity: 1
        },500);
      }
    });
  };

  // Блокировка кошелька
  $scope.blockedWallet = function(){
    $http.post('/spot/blockedWallet', $scope.spot).success(function(data) {
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
  }

  // Удаляем карту
  $scope.removeCard = function(card_id, e){
    var data = {'token': $scope.spot.token, 'card_id': card_id};
    $http.post('/spot/removeCard', data).success(function(data) {
      if (data.error == 'no'){
        angular.element(e.currentTarget).remove();
      }
    });
  };


  // TODO Сортировка блоков спота и сохранение порядна, не работает
  // // Сохраняем порядок блоков
  // $scope.saveOrder = function() {
  //   var spot = $scope.spot;
  //   spot.keys = $scope.keys;
  //   $http.post('/spot/saveOrder', spot).success(function(data) {
  //     if(data.error == 'no') {

  //     }
  //   });
  // }

  // // Параметры сортировки
  // $scope.sortableOptions = {
  //   update: function(e, ui) {
  //     $scope.saveOrder();
  //   },
  //   'containment':'.spot-content',
  //   'tolerance':'pointer',
  //   'scrollSensitivity': 10,
  //   'opacity':0.8
  // };

  // TODO Флаги для отображения визитки и приватности спота, пока убрано
  // // Атрибут разрешить скачивать визитку
  // $scope.getVcard = function(spot){
  //   if (spot.vcard == 1) spot.vcard = 0;
  //   else spot.vcard = 1;
  //   $scope.setAttribute(spot);
  // };

  // // Атрибут приватности спота
  // $scope.getPrivate = function(spot) {
  //   if (spot.private == 1) spot.private = 0;
  //   else spot.private = 1;
  //   $scope.setAttribute(spot);
  // };

  // // Сохранение атрибутов
  // $scope.setAttribute = function(spot) {
  //   $http.post('/spot/spotAtributeSave', $scope.spot).success(function(data)           {
  //       if(data.error == 'no') {

  //       }
  //     });
  // };

  $(document).on('click','.store-items__close', function(){
    $(this).parents('tr').remove();
  });

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
  }

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
      // $scope.parseFile(f);
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

        var scroll_height = $('#block-' + data.key).offset().top;
        $('html, body').animate({
          scrollTop: scroll_height
        }, 600);
      }
    }
  }

  // Случайным образом генерируем значение для эффекта загрузки
  function uploadProgress(evt) {
    $scope.$apply(function(){
      if (evt.lengthComputable) {
          $scope.progress = Math.round(evt.loaded * 100 / evt.total)
      } else {
          $scope.progress = 'unable to compute'
      }
    })
  }

  // Действие если загрузка не удалась
  $scope.uploadFailed = function(e) {
    angular.element('#error-upload').show().delay(800).slideUp('slow');
  }

  $scope.uploadFile = function(file) {

    var xhr = new XMLHttpRequest();
    if (xhr.upload && file.size <= $scope.maxSize) {
      angular.element('#progress-content').show();

      xhr.upload.onprogress = function(e) {
        if (e.lengthComputable) {
          $scope.progress = Math.round(e.loaded * 100 / e.total)
        } else {
          $scope.progress = 'unable to compute'
        }
      };

      xhr.upload.addEventListener("progress", uploadProgress, false)
      xhr.addEventListener("error", $scope.uploadFailed, false)
      xhr.addEventListener("load", $scope.uploadComplete, false)
      xhr.open("POST", "/spot/upload", true);
      xhr.setRequestHeader("X-File-Name", file.name);
      xhr.setRequestHeader("X-Discodes", $scope.spot.discodes);
      xhr.send(file);
    }
  }


  // DEL Аккордеон в списке личных спотов
  // $scope.accordion = function(e, init) {
  //   var spot;
  //   $scope.SocNetTooltip(false);
  //   if(init == 1) {
  //     spot = e;
  //   }
  //   else {
  //     spot = angular.element(e.currentTarget).parent();
  //   }
  //   var spotContent = spot.find('.spot-content');
  //   var spotHat = spot.find('.spot-hat');

  //   $scope.spot.discodes = spot.attr('id');
  //   $scope.keys = [];
  //   $scope.keys_for_load = [];
  //   $scope.content_iteration = 0;

  //   if (spotContent.attr('class') == null) {
  //     var data = {discodes:$scope.spot.discodes, token:$scope.user.token};
  //     $http.post('/spot/spotView', data).success(function(data) {
  //       if(data.error == 'no') {
  //         var oldSpotContent = angular.element('.spot-content');
  //         angular.element('.spot-content_li').removeClass('open');
  //         oldSpotContent.slideUp('slow', function () {
  //           oldSpotContent.remove();
  //         });

  //         spotHat.after($compile(data.content)($scope));
  //         spot.addClass('open');
  //         spot.find('.spot-content').slideToggle('slow');
  //         $scope.loadSocContent();

  //         $scope.spot.content='';

  //         var file_drag = document.getElementById('dropbox');
  //         var file_button = document.getElementById('addFile');
  //         if (file_drag && file_button) {
  //           var xhr = new XMLHttpRequest();
  //           if (xhr.upload) {
  //             file_drag.addEventListener("dragover", fileDragHover, false);
  //             file_drag.addEventListener("dragleave", fileDragHover, false);
  //             file_drag.addEventListener("drop", fileSelectHandler, false);
  //             file_button.addEventListener('change', fileSelectHandler, false);
  //           }
  //         }

  //         if ($scope.spot.status == 2){
  //           $scope.spot.invisible = true;
  //         }
  //         else {
  //           $scope.spot.invisible = false;
  //         }
  //         $scope.spot.pass = data.pass;
  //         if (typeof ($scope.spot.pass) == 'undefined' || $scope.spot.pass.length == 0)
  //           angular.element('#resetPassButton').hide();
  //         else
  //           angular.element('#resetPassButton').show();

  //         if ($scope.scroll_key >= 0 && $('#block-' + $scope.scroll_key).length) {
  //           var scroll_height = $('#block-' + $scope.scroll_key).offset().top;
  //           $('html, body').animate({
  //               scrollTop: scroll_height
  //           }, 600);
  //           $scope.scroll_key = -1;
  //         }

  //         //загрузка кошелька
  //         angular.element('#wallet-block').remove();
  //         var details = {discodes:$scope.spot.discodes, token:$scope.user.token};
  //         $http.post('/spot/wallet', details).success(function(data) {
  //           if (data.error == 'no'){
  //               angular.element('#spot-block').after($compile(data.content)($scope));
  //               if (angular.element('#icon-wallet').hasClass('active'))
  //                   angular.element('#wallet-block').slideDown();
  //           }
  //         });

  //         //загрузка страницы с акциями спота
  //           angular.element('#coupons-block').remove();
  //         var details = {discodes:$scope.spot.discodes, token:$scope.user.token};
  //         $http.post('/spot/coupons', details).success(function(data) {
  //           if (data.error == 'no'){
  //               angular.element('#spot-block').after($compile(data.content)($scope));
  //               if (angular.element('#icon-coupons').hasClass('active'))
  //                   angular.element('#coupons-block').slideDown();
  //           }
  //         });

  //       }
  //     }).error(function(error){
  //       console.log(error);
  //     });
  //   }
  //   else {
  //     delete $scope.spot.discodes;
  //     delete $scope.spot.content_new;
  //     spotContent.slideUp('slow',
  //       function () {
  //         spot.removeClass('open');
  //         spotContent.remove();
  //       });
  //   }
  // }

/* Соц сети */

  // DEL
  /*
  $scope.socTask = function(key){
      $scope.keys_for_load.push(key);
  }

  $scope.loadSocContent = function() {
    var len = $scope.keys_for_load.length;
    for (var i = 0; i < len; i++){
      var data = {discodes:$scope.spot.discodes, key:$scope.keys_for_load[i], token:$scope.user.token};
      $http.post('/spot/SocNetContent', data).success(function(data) {
        if(data.error == 'no'){
            var spotEdit = angular.element('#block-' + data.key);
            var oldHeight = spotEdit.height();
            var oldScroll = spotEdit.offset().top;

            spotEdit.before($compile(data.content)($scope));
            spotEdit.remove();
            $scope.setVideoSize(data.key);
            if (oldScroll < $('html, body').scrollTop()) {
                var scroll_height = $('html, body').scrollTop()
                                    + $('#block-' + data.key).height()
                                    - oldHeight;

                $('html, body').animate({
                    scrollTop: scroll_height
                }, 0);
            }
        }else{
            console.log('key ' + $scope.keys_for_load[i] + ' : ' + data.error);
        }
      }).error(function(error){
          console.log(error);
      });
    }
    $scope.keys_for_load = [];
  }

  */

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
                var scroll_height = $('html, body').scrollTop()
                                    + $('#block-' + data.key).height()
                                    - oldHeight;

                $('html, body').animate({
                    scrollTop: scroll_height
                }, 0);
            }
        }else{
            console.log('key ' + key + ':' + data.error);
        }
      }).error(function(error){
          console.log(error);
      });
  }

  $scope.socialButton = function(){
    var mediaForm = angular.element('#extraMediaForm');
    var mediaFormA = angular.element('#extraMediaForm a');
    if(mediaForm.hasClass('open'))
    {
      mediaForm.slideUp();
      mediaForm.removeClass('open');
    }
    else
    {
      $scope.freeSocial = true;
      mediaFormA.removeClass('blackout');
      mediaFormA.fadeTo(0, 1);
      mediaForm.slideDown(500);
      mediaForm.addClass('open');
    }
  }

  $scope.socView = function(Target){
    var mediaFormA = angular.element('#extraMediaForm a');

    $scope.SocNetTooltip(false);
    if($scope.freeSocial)
    {
      if (typeof (Target) != 'undefined' && Target.length > 0)
      {
          mediaFormA.stop();
          var currentNet = angular.element('#extraMediaForm a[net=' + Target + ']');
          var otherNet = angular.element('#extraMediaForm a[net!=' + Target + ']');
          otherNet.fadeTo(600, 0.2);
          currentNet.fadeTo(0, 1);
      }
      else{
          mediaFormA.stop();
          mediaFormA.fadeTo(600, 1);
      }
    }
  }

  //отслеживает поле редактирования на появление ссылок на соцсети
  $scope.changeContent = function(){
    var needPanel = false;
    var currentNet = -1;
    $scope.content_iteration++;

    for (var i = 0; i < $scope.soc_patterns.length; i++)
    {
        if ('undefined' != typeof ($scope.spot.content)
            && $scope.spot.content.indexOf($scope.soc_patterns[i].baseUrl) != -1)
        {
            needPanel = true;
            currentNet = i;
            break;
        }
    }

    if ('undefined' != typeof ($scope.spot.content) && !needPanel && $scope.spot.content.indexOf('.') != -1 && $scope.spot.content.length > 2)
    {
        var data = {token:$scope.user.token, link:$scope.spot.content, iteration:$scope.content_iteration};
        $http.post('/spot/DetectSocNet', data).success(function(data) {
            if (data.iteration == $scope.content_iteration)
            {
                var currentNet = -1;
                var needPanel = false;
                if (typeof (data.netName) != 'undefined' && data.netName.length)
                {
                    currentNet = $scope.getPatternInd(data.netName);
                    needPanel = true;
                }
                $scope.panelControl(needPanel, currentNet);
            }
        });
    }
    else
        $scope.panelControl(needPanel, currentNet);
  }

  $scope.panelControl = function(needPanel, currentNet){
    var mediaForm = angular.element('#extraMediaForm');
    var mediaFormA = angular.element('#extraMediaForm a');
    if (needPanel){
      var curentNet = angular.element('#extraMediaForm a[net=' + $scope.soc_patterns[currentNet].name + ']');
      var otherNet = angular.element('#extraMediaForm a[net!=' + $scope.soc_patterns[currentNet].name + ']');
      otherNet.addClass('blackout');
      otherNet.fadeTo(0, 0.2);
      curentNet.removeClass('blackout');
      curentNet.fadeTo(0, 1);
      $scope.freeSocial = false;
    }

    if (needPanel && !mediaForm.hasClass('open')){
      mediaForm.slideDown(500, function(){$scope.SocNetTooltip(true, currentNet)});
      mediaForm.addClass('open');
    }else if (!needPanel && mediaForm.hasClass('open')){
      $scope.SocNetTooltip(false);
      mediaForm.slideUp(400, function(){mediaFormA.removeClass('blackout');angular.element('#extraMediaForm a').fadeTo(0, 1);});
      mediaForm.removeClass('open');
    }else if (needPanel){
      $scope.SocNetTooltip(true, currentNet);
    }
  }

  $scope.SocNetTooltip = function(NeedTooltip, currentNet){
      if (NeedTooltip){
          angular.element('#net-tooltip .STT-inner').text('Connect to ' + $scope.soc_patterns[currentNet].title + ' to share more');
          var socImg = $('#extraMediaForm a[net=' + $scope.soc_patterns[currentNet].name + ']');
          var netPos = socImg.offset();
          $('#net-tooltip').css('top', netPos.top - $('#net-tooltip').height() - 12);
          $('#net-tooltip').css('left', netPos.left - $('#net-tooltip').width()/2 + socImg.width()/2 - 2);
          $('#net-tooltip .STT-arrow').css('left', ($('#net-tooltip').width()/2 + 0));
          $('#net-tooltip .STT-arrow').css('top', ($('#net-tooltip').height() + 6));
          angular.element('#net-tooltip').show();
      }else
          angular.element('#net-tooltip').hide();
  }

  // Привязка соцсетей
  var popup;
  var socTimer;
  var likeTimer;
  var holderTimer;
  //через плашку
  $scope.bindByPanel = function(buttonName) {
    var netName = buttonName;
    var data = {spot: $scope.spot, token:$scope.user.token, netName:netName};
    //определение сети по ссылке
    if ('undefined' != typeof ($scope.spot.content)
        && $scope.spot.content.length)
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
            if(data.profileHint.length == 0)
            {
                if (!data.loggedIn) {
                    var options = $.extend({
                      id: '',
                      popup: {
                        width: 450,
                        height: 380
                      }
                    }, options);

                    var redirect_uri, url = redirect_uri = 'http://' + window.location.hostname + '/user/BindSocLogin?service=' + netName;

                    url += url.indexOf('?') >= 0 ? '&' : '?';
                    if (url.indexOf('redirect_uri=') === -1)
                      url += 'redirect_uri=' + encodeURIComponent(redirect_uri);

                    var centerWidth = (window.screen.width - options.popup.width) / 2,
                      centerHeight = (window.screen.height - options.popup.height) / 2;

                    popup = window.open(url + '&js', "yii_eauth_popup", "width=" + options.popup.width + ",height=" + options.popup.height + ",left=" + centerWidth + ",top=" + centerHeight + ",resizable=yes,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=yes");

                    if (popup == null || typeof(popup)=='undefined') {
                        window.location.href = url + '&discodes=' + $scope.spot.discodes + '&link=' + encodeURIComponent($scope.spot.content) + '&newField=1' + '&synch=true';
                    }
                    else {
                        popup.focus();

                        $scope.bindNet = {name:data.socnet, discodes:$scope.spot.discodes, newField:1};
                        if ('undefined' != typeof ($scope.spot.content)
                            && $scope.spot.content.length)
                            $scope.bindNet.link = $scope.spot.content;
                        socTimer = $timeout($scope.loginTimer, 1000);
                    }
                }
                else
                {
                    if(data.linkCorrect == 'ok')
                    {
                        if(angular.element('#extraMediaForm').hasClass('open'))
                        {
                            angular.element('#extraMediaForm').slideUp();
                            angular.element('#extraMediaForm').removeClass('open');
                        }

                        angular.element('#add-content').append($compile(data.content)($scope));

                        $scope.keys.push(data.key);
                        $scope.spot.content='';
                        angular.element('textarea').removeClass('put');
                        $scope.resetCursor();

                        if (angular.element('#extraMediaForm').hasClass('open'))
                        {
                            angular.element('#extraMediaForm').slideUp(0, function(){angular.element('#extraMediaForm a').removeClass('blackout');angular.element('#extraMediaForm a').fadeTo(0, 1);});
                            angular.element('#extraMediaForm').removeClass('open');
                        }

                        $scope.setVideoSize(data.key);
                        var scroll_height = $('#block-' + data.key).offset().top - 100;
                        $('html, body').animate({
                            scrollTop: scroll_height
                        }, 600);

                        var currentNet = $scope.getPatternInd(data.socnet);
                        if (currentNet > -1)
                            $scope.soc_patterns[currentNet].BindByPaste = true;
                    }
                    else
                    {
                        $scope.addValue($scope.spot.content);
                        contentService.setModal(data.linkCorrect, 'none');
                    }
                }
            }
            else
            {
                $timeout.cancel(holderTimer);
                holderTimer = $timeout($scope.hintTimer, 10000);
                angular.element('#socLinkHolder h4').html(data.profileHint);
                angular.element('#mainHolder').addClass('hide');
                angular.element('#socLinkHolder').removeClass('hide');
                angular.element('#socLinkHolder h4').stop();
                angular.element('#socLinkHolder h4').fadeTo(800, 0.5,
                    function(){angular.element('#socLinkHolder h4').fadeTo(800, 1,
                        function(){angular.element('#socLinkHolder h4').fadeTo(800, 0.5, function(){
                            angular.element('#socLinkHolder h4').fadeTo(800, 1);})})});
            }
        }
        else
        {
            console.log(data.error);
        }
    }).error(function(error){
        console.log(error);
    });
  }

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
  }

    //возврашает исходный плейсхолдер нового поля, вместо сообщения с просьбой вставить ссылку на соцсеть
    $scope.hintTimer = function()
    {
        angular.element('#socLinkHolder h4').stop();
        angular.element('#socLinkHolder h4').html('');
        if (angular.element('#mainHolder').hasClass('hide'))
        {
            angular.element('#socLinkHolder').addClass('hide');
            angular.element('#mainHolder').removeClass('hide');
        }
    }

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

            var redirect_uri, url = redirect_uri = 'http://' + window.location.hostname + '/user/BindSocLogin?service=' + data.socnet;

            url += url.indexOf('?') >= 0 ? '&' : '?';
            if (url.indexOf('redirect_uri=') === -1)
              url += 'redirect_uri=' + encodeURIComponent(redirect_uri);

            var centerWidth = (window.screen.width - options.popup.width) / 2,
              centerHeight = (window.screen.height - options.popup.height) / 2;

            popup = window.open(url + '&js', "yii_eauth_popup", "width=" + options.popup.width + ",height=" + options.popup.height + ",left=" + centerWidth + ",top=" + centerHeight + ",resizable=yes,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=yes");

            if (popup == null || typeof(popup)=='undefined') {
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
            }
            else
            {
                contentService.setModal(data.linkCorrect, 'none');
            }
          }
        }
        else if(data.linkCorrect != 'ok'){
            contentService.setModal(data.linkCorrect, 'none');
        }
      }
      else {
        console.log(data.error);
      }
    });
  };

  //подключение акции, требующей жетона соцсети
  $scope.checkLike = function(e, id_action)
  {
      var data = {token: $scope.user.token, id:id_action, discodes:$scope.spot.discodes};
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

                  var redirect_uri, url = redirect_uri = 'http://' + window.location.hostname + '/user/BindSocLogin?service=' + data.service;

                  url += url.indexOf('?') >= 0 ? '&' : '?';
                  if (url.indexOf('redirect_uri=') === -1)
                    url += 'redirect_uri=' + encodeURIComponent(redirect_uri) + '&';
                  url += 'js';

                  var centerWidth = (window.screen.width - options.popup.width) / 2,
                    centerHeight = (window.screen.height - options.popup.height) / 2;

                  popup = window.open(url, "yii_eauth_popup", "width=" + options.popup.width + ",height=" + options.popup.height + ",left=" + centerWidth + ",top=" + centerHeight + ",resizable=yes,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=yes");

                  popup.focus();

                  $scope.checkingAction = {id:id_action};
                  $scope.actionDiv = angular.element(e.currentTarget).parent().parent('div.spot-item');
                  likeTimer = $timeout($scope.likesTimer, 1000);
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
                    var act = angular.element(e.currentTarget).parent().parent('div.spot-item');
                    act.before($compile(data.content)($scope));
                    act.remove();
                  }
              }
          }
      });
  }

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
        $http.post('/user/disableLoyalty', data).success(function(data) {
            if ('no' == data.error)
            {
                var act = angular.element(e.currentTarget).parent().parent('div.spot-item');
                act.before($compile(data.content)($scope));
                act.remove();
            }
        });

    }


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

                                if (angular.element('#extraMediaForm').hasClass('open'))
                                {
                                    angular.element('#extraMediaForm').slideUp();
                                    angular.element('#extraMediaForm').removeClass('open');
                                }

                                angular.element('#add-content').append($compile(data.content)($scope));

                                $scope.keys.push(data.key);
                                $scope.spot.content='';
                                angular.element('textarea').removeClass('put');

                                $scope.resetCursor()

                                if (angular.element('#extraMediaForm').hasClass('open'))
                                {
                                    angular.element('#extraMediaForm').slideUp(0, function(){angular.element('#extraMediaForm a').removeClass('blackout');angular.element('#extraMediaForm a').fadeTo(0, 1);});
                                    angular.element('#extraMediaForm').removeClass('open');
                                }

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
                else
                {
                    console.log('error in spot/bindedContent');
                }
            }).error(function(error){
                console.log(error);
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
      }
      else {
        console.log(data.error);
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
            }).error(function(error){
                console.log(error);
            });
        }
    }

    //установка размер проигрывателя YouTube или Vimeo
    $scope.setVideoSize = function(blockKey)
    {
        if (angular.element('#block-' + blockKey + ' .video-vimeo').length == 1)
        {
            var player = angular.element('#block-' + blockKey + ' .video-vimeo');
            player.css('width', '100%');
            player.css('height', (parseInt(player.css('width'), 10) / player.attr('rel') + 'px'));
        }
        else if (angular.element('#block-' + blockKey + ' .yt_player').length == 1)
        {
            var player = angular.element('#block-' + blockKey + ' .yt_player');
            player.css('width', '100%');
            player.css('height', (parseInt(player.css('width'), 10) / player.attr('rel') + 'px'));
        }
    }

  $scope.actionSpot = function(spot, e) {
    var curent = angular.element(e.currentTarget);
    if(!curent.hasClass('open')){
      var id = curent.attr('id');
      var open = angular.element('.spot-action.open');
      open.next().slideUp(400);
      open.removeClass('open');
      $scope.action = id;
    }
  }

  $scope.setNewName = function(spot) {
    if ($scope.spot.newName){
      $http.post('/spot/renameSpot', spot).success(function(data) {
        if(data.error == 'no') {
          var spotContent = angular.element('#' + spot.discodes);
          spotContent.find('.spot-hat h3').text(data.name);
          renameSpot.hide();
          delete $scope.spot.newName;
          angular.element('.popup').click();
          angular.element('.settings-list > li').removeClass('open');
        }
        else if (data.error == 'yes') {
          angular.element('#rename-spot input[name=newName]').addClass('error');
        }
      });
    }
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
    }

    $scope.savePassButtonText = function(text)
    {
        angular.element('#savePassButton').text(text);
        angular.element('#setPassForm input[name=newPass]').removeClass('error');
    }

  //действия при положительном ответе
  $scope.confirmYes = function(spot) {
    var spotContent = angular.element('#' + spot.discodes);
    if ($scope.action == 'deleteSpot'){
      $http.post('/spot/removeSpot', spot).success(function(data) {
        if(data.error == 'no') {
          spotContent.slideUp('slow', function () {
            spotContent.remove();
          });
        }
      });
    }
    else if ($scope.action == 'cleanSpot'){
      $http.post('/spot/cleanSpot', spot).success(function(data) {
        if(data.error == 'no') {
          spotContent = angular.element('.spot-block').remove();
        }
      });
    }
    else if ($scope.action == 'invisibleSpot' || $scope.action == 'visibleSpot'){
      $http.post('/spot/invisibleSpot', spot).success(function(data) {
        if(data.error == 'no') {
          var spot = angular.element('#' + $scope.spot.discodes);
          if ($scope.spot.invisible){
            spot.addClass('invisible-spot');
            spot.find('.invisible-icon').hide();
            $scope.spot.invisible = false;
          }
          else {
            spot.removeClass('invisible-spot');
            spot.find('.invisible-icon').hide();
            $scope.spot.invisible = true;
          }
        }
      });
    }
    renameSpot.hide();
    confirm.hide();
    angular.element('.settings-list > li').removeClass('open');
  };

  $scope.confirmNo = function(spot) {
    if ($scope.action){
      confirm.hide();
      angular.element('.settings-list > li').removeClass('open');
      $scope.action = false;
    }
  };

  $scope.checkStatusSpot = function(spot) {
    return true;
  };

    $scope.showSpotContent = function() {
        angular.element('.tabs-item').slideUp();
        angular.element('#spot-block').slideDown();
        angular.element('.spot-tabs a').removeClass('active');
        angular.element('#icon-spot').addClass('active');

    }

    $scope.showWallet = function() {
        angular.element('.tabs-item').slideUp();
        angular.element('#wallet-block').slideDown();
        angular.element('.spot-tabs a').removeClass('active');
        angular.element('#icon-wallet').addClass('active');

    }

    $scope.showCoupons = function() {
        angular.element('.tabs-item').slideUp();
        angular.element('#coupons-block').slideDown();
        angular.element('.spot-tabs a').removeClass('active');
        angular.element('#icon-coupons').addClass('active');
    }

  //Открыть спот по коду
  $scope.defOpen = function(discodes){
    if (discodes == 0)  return false;

    var defSelector = '#' + discodes;
    var spot = angular.element(defSelector);
    $scope.accordion(spot, 1);
    /*
    $('html, body').animate({
      scrollTop: $(defSelector).offset().top
    }, 600);
    */
  };

    $scope.cursorWait = function()
    {
        $scope.cursorBody = angular.element('body').css('cursor');
        $scope.cursorTextarea = angular.element('#dropbox textarea').css('cursor');
        angular.element('body').css('cursor', 'wait');
        angular.element('#dropbox textarea').css('cursor', 'wait');
    }

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
    }

});
