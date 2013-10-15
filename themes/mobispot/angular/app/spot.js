'use strict';

function $id(id) {
  return document.getElementById(id);
}

function SpotCtrl($scope, $http, $compile, $timeout) {

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

  $scope.maxSize = 25*1024*1024;
  $scope.progress = 0;
  $scope.spot_edit = false;
  $scope.keys = [];
  $scope.action = false;

  var renameSpot = angular.element('.rename-spot');
  var confirm = angular.element('.confirm');
  var toggle_box = angular.element('.toggle-box');

  $(document).on('click','.store-items__close', function(){
    $(this).parents('tr').remove();
  });

   // Сохраняем порядок блоков
  $scope.saveOrder = function() {
    var spot = $scope.spot;
    spot.keys = $scope.keys;
    $http.post('/spot/saveOrder', spot).success(function(data) {
      if(data.error == 'no') {

      }
    });
  }

  // Параметры сортировки
  $scope.sortableOptions = {
    update: function(e, ui) {
      $scope.saveOrder();
    },
    'containment':'.spot-content',
    'tolerance':'pointer',
    'scrollSensitivity': 10,
    'opacity':0.8
  };

 
  // Закачка файла html5
  function fileDragHover(e) {
    e.stopPropagation();
    e.preventDefault();
    if (e.type == "dragover"){
      angular.element('#dropbox').addClass("hover");
    }
    else {
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

  function uploadProgress(evt) {
    $scope.$apply(function(){
      if (evt.lengthComputable) {
          $scope.progress = Math.round(evt.loaded * 100 / evt.total)
      } else {
          $scope.progress = 'unable to compute'
      }
    })
  }

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


  // Атрибут разрешить скачивать визитку
  $scope.getVcard = function(spot){
    if (spot.vcard == 1) spot.vcard = 0;
    else spot.vcard = 1;
    $scope.setAttribute(spot);
  };

  // Атрибут приватности спота
  $scope.getPrivate = function(spot) {
    if (spot.private == 1) spot.private = 0;
    else spot.private = 1;
    $scope.setAttribute(spot);
  };

  // Сохранение атрибутов
  $scope.setAttribute = function(spot) {
    $http.post('/spot/spotAtributeSave', $scope.spot).success(function(data)           {
        if(data.error == 'no') {

        }
      });
  };

  // Аккордеон в списке личных спотов
  $scope.accordion = function(e, init) {
    var spot;
    $scope.SocNetTooltip(false);
    if(init == 1) {
      spot = e;
    }
    else {
      spot = angular.element(e.currentTarget).parent();
    }
    var spotContent = spot.find('.spot-content');
    var spotHat = spot.find('.spot-hat');

    $scope.spot.discodes = spot.attr('id');
    $scope.keys = [];
    $scope.KeysForLoad = [];
    $scope.ContentIteration = 0;

    if (spotContent.attr('class') == null) {
      var data = {discodes:$scope.spot.discodes, token:$scope.user.token};
      $http.post('/spot/spotView', data).success(function(data) {
        if(data.error == 'no') {
          var oldSpotContent = angular.element('.spot-content');
          angular.element('.spot-content_li').removeClass('open');
          oldSpotContent.slideUp('slow', function () {
            oldSpotContent.remove();
          });

          spotHat.after($compile(data.content)($scope));
          spot.addClass('open');
          spot.find('.spot-content').slideToggle('slow');
          $scope.LoadSocContent();

          $scope.spot.content='';

          var file_drag = $id('dropbox');
          var file_button = $id('add-file');
          if (file_drag && file_button) {
            var xhr = new XMLHttpRequest();
            if (xhr.upload) {
              file_drag.addEventListener("dragover", fileDragHover, false);
              file_drag.addEventListener("dragleave", fileDragHover, false);
              file_drag.addEventListener("drop", fileSelectHandler, false);
              file_button.addEventListener('change', fileSelectHandler, false);
            }
          }

          if ($scope.spot.status == 2){
            $scope.spot.invisible = true;
          }
          else {
            $scope.spot.invisible = false;
          }
          $scope.spot.pass = data.pass;
        }
      }).error(function(error){
        console.log(error);
      });
    }
    else {
      delete $scope.spot.discodes;
      delete $scope.spot.content_new;
      spotContent.slideUp('slow',
        function () {
          spot.removeClass('open');
          spotContent.prev().remove();
          spotContent.remove();
        });
    }
  }

    $scope.socTask = function(key){
        $scope.KeysForLoad.push(key);

    }
    
    $scope.LoadSocContent = function() {
        var len = $scope.KeysForLoad.length;
        for (var i = 0; i < len; i++)
        {
            var data = {discodes:$scope.spot.discodes, key:$scope.KeysForLoad[i], token:$scope.user.token};
            if (len == (i+1)){
                data.lastKey = true;
            }
            $http.post('/spot/SocNetContent', data).success(function(data) {
                if(data.error == 'no') 
                {
                    var spotEdit = angular.element('#block-' + data.key);
                    spotEdit.before($compile(data.content)($scope));
                    spotEdit.remove();
                    $scope.setVideoSize(data.key);
                }
                else
                {
                    console.log(data.error);
                }
            }).error(function(error){
                console.log(error);
            });
        }
        $scope.KeysForLoad = [];
    }
  
  // Добавление нового блока в спот
  $scope.addContent = function(spot) {
    if (spot.content && spot.user) {
        var currentNet = -1;

        for (var i = 0; i < $scope.socPatterns.length; i++)
        {
            if ($scope.spot.content.indexOf($scope.socPatterns[i].baseUrl) != -1)
            {
                currentNet = i;
                break;
            }
        }

        if (currentNet > -1 && $scope.socPatterns[currentNet].BindByPaste)
        {
            angular.element('body').css('cursor', 'wait');
            angular.element('#dropbox textarea').css('cursor', 'wait');
            $scope.bindByPanel($scope.socPatterns[currentNet].name);
        }
        else
        {
          $http.post('/spot/spotAddContent', spot).success(function(data) {
            if(data.error == 'no') {
              angular.element('#add-content').append($compile(data.content)($scope));

              $scope.keys.push(data.key);
              $scope.spot.content='';
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
        }
    }
  };

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
      var spotData = spotItem.find('p.item-type__text');

      $scope.spot.content_new = spotData.text();
      var spotEditText = spotEdit.find('textarea');
      spotEditText.text('1');

      spotEdit.removeClass('hide');
      spotEditText.focus(1);
      spotItem.hide().before($compile(spotEdit)($scope));
    }
    else {
      $scope.hideSpotEdit();
    }
  };

    $scope.socialButton = function()
    {
        if(angular.element('#extraMediaForm').hasClass('open'))
        {
            angular.element('#extraMediaForm').slideUp();
            angular.element('#extraMediaForm').removeClass('open');
        }
        else
        {
            $scope.freeSocial = true;
            angular.element('#extraMediaForm a').removeClass('blackout');
            angular.element('#extraMediaForm a').fadeTo(0, 1);
            angular.element('#extraMediaForm').slideDown(500);
            angular.element('#extraMediaForm').addClass('open');
        }
    }

    $scope.socView = function(Target)
    {
        $scope.SocNetTooltip(false);
        if($scope.freeSocial)
        {
            if (typeof (Target) != 'undefined' && Target.length > 0)
            {
                angular.element('#extraMediaForm a').stop();
                angular.element('#extraMediaForm a[net!=' + Target + ']').fadeTo(600, 0.2);
                angular.element('#extraMediaForm a[net=' + Target + ']').fadeTo(0, 1);
            }
            else{
                angular.element('#extraMediaForm a').stop();
                angular.element('#extraMediaForm a').fadeTo(600, 1);
            }
        }
    }

    //отслеживает поле редактирования на появление ссылок на соцсети
    $scope.changeContent = function()
    {
        var needPanel = false;
        var currentNet = -1;
        $scope.ContentIteration++;

        for (var i = 0; i < $scope.socPatterns.length; i++)
        {
            if ($scope.spot.content.indexOf($scope.socPatterns[i].baseUrl) != -1)
            {
                needPanel = true;
                currentNet = i;
                break;
            }
        }
        
        if (!needPanel && $scope.spot.content.indexOf('.') != -1 && $scope.spot.content.length > 2)
        {
            var data = {token:$scope.user.token, link:$scope.spot.content, iteration:$scope.ContentIteration};
            $http.post('/spot/DetectSocNet', data).success(function(data) {
                if (data.iteration == $scope.ContentIteration)
                {
                    var currentNet = -1;
                    var needPanel = false;
                    if (typeof (data.netName) != 'undefined')
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
    
    $scope.panelControl = function(needPanel, currentNet)
    {
        if (needPanel)
        {
            angular.element('#extraMediaForm a[net!=' + $scope.socPatterns[currentNet].name + ']').addClass('blackout');
            angular.element('#extraMediaForm a[net!=' + $scope.socPatterns[currentNet].name + ']').fadeTo(0, 0.2);
            angular.element('#extraMediaForm a[net=' + $scope.socPatterns[currentNet].name + ']').removeClass('blackout');
            angular.element('#extraMediaForm a[net=' + $scope.socPatterns[currentNet].name + ']').fadeTo(0, 1);
            $scope.freeSocial = false;
        }
        
        if (needPanel && !angular.element('#extraMediaForm').hasClass('open'))
        {
            angular.element('#extraMediaForm').slideDown(500, function(){$scope.SocNetTooltip(true, currentNet)});
            angular.element('#extraMediaForm').addClass('open');
        }
        else if (!needPanel && angular.element('#extraMediaForm').hasClass('open'))
        {
            $scope.SocNetTooltip(false);
            angular.element('#extraMediaForm').slideUp(400, function(){angular.element('#extraMediaForm a').removeClass('blackout');angular.element('#extraMediaForm a').fadeTo(0, 1);});
            angular.element('#extraMediaForm').removeClass('open');
        }
        else if (needPanel)
        {
            $scope.SocNetTooltip(true, currentNet);
        }
    }
    
    $scope.SocNetTooltip = function(NeedTooltip, currentNet)
    {
        if (NeedTooltip)
        {
            angular.element('#net-tooltip .STT-inner').text('Connect to ' + $scope.socPatterns[currentNet].title + ' to share more');
            var socImg = $('#extraMediaForm a[net=' + $scope.socPatterns[currentNet].name + ']');
            var netPos = socImg.offset();
            $('#net-tooltip').css('top', netPos.top - $('#net-tooltip').height() - 12);
            $('#net-tooltip').css('left', netPos.left - $('#net-tooltip').width()/2 + socImg.width()/2 - 2);
            $('#net-tooltip .STT-arrow').css('left', ($('#net-tooltip').width()/2 + 0));
            $('#net-tooltip .STT-arrow').css('top', ($('#net-tooltip').height() + 6)); 
            angular.element('#net-tooltip').show();
        }
        else
            angular.element('#net-tooltip').hide();
    }
    
    // Привязка соцсетей
    var popup;
    var socTimer;
    var holderTimer;
    //через плашку
    $scope.bindByPanel = function(buttonName)
    {
        var netName = buttonName;
        var data = {spot: $scope.spot, token:$scope.user.token, netName:netName};
        //определение сети по ссылке
        if ($scope.spot.content.length > 0)
        {
            data.link = $scope.spot.content;
            for (var i = 0; i < $scope.socPatterns.length; i++)
            {
                if ($scope.spot.content.indexOf($scope.socPatterns[i].baseUrl) != -1)
                {
                    netName = $scope.socPatterns[i].name;
                    data.netName = $scope.socPatterns[i].name;
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
                          url += 'redirect_uri=' + encodeURIComponent(redirect_uri) + '&';
                        url += 'js';

                        var centerWidth = (window.screen.width - options.popup.width) / 2,
                          centerHeight = (window.screen.height - options.popup.height) / 2;

                        popup = window.open(url, "yii_eauth_popup", "width=" + options.popup.width + ",height=" + options.popup.height + ",left=" + centerWidth + ",top=" + centerHeight + ",resizable=yes,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=yes");
                        popup.focus();
                        
                        $scope.bindNet = {name:data.socnet, discodes:$scope.spot.discodes, newField:1};
                        if ($scope.spot.content.length > 0)
                            $scope.bindNet.link = $scope.spot.content;
                        socTimer = $timeout($scope.loginTimer, 1000);
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
                            angular.element('body').css('cursor', 'default');
                            angular.element('#dropbox textarea').css('cursor', 'text');
                            
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
                                $scope.socPatterns[currentNet].BindByPaste = true;
                        }
                        else
                        {
                            var resultModal = angular.element('.m-result');
                            var resultContent = resultModal.find('p');
                            resultModal.show();
                            resultContent.text(data.linkCorrect);
                            resultModal.fadeOut(10000, function() {});
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
    $scope.getPatternInd = function(netName)
    {
        var currentNet = -1;
        for (var i = 0; i < $scope.socPatterns.length; i++)
        {
            if ($scope.socPatterns[i].name == netName)
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
              url += 'redirect_uri=' + encodeURIComponent(redirect_uri) + '&';
            url += 'js';

            var centerWidth = (window.screen.width - options.popup.width) / 2,
              centerHeight = (window.screen.height - options.popup.height) / 2;

            popup = window.open(url, "yii_eauth_popup", "width=" + options.popup.width + ",height=" + options.popup.height + ",left=" + centerWidth + ",top=" + centerHeight + ",resizable=yes,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=yes");
            popup.focus();
            
            $scope.bindNet = {name:data.socnet, discodes:spot.discodes, key:spot.key, spotEdit:angular.element(e.currentTarget).parents('.spot-item')};
            socTimer = $timeout($scope.loginTimer, 1000);
          }
          else {
            if(data.linkCorrect == 'ok')
            {
                spotEdit.before($compile(data.content)($scope));
                spotEdit.remove();
                var currentNet = $scope.getPatternInd(data.socnet);
                if (currentNet > -1)
                    $scope.socPatterns[currentNet].BindByPaste = true;
                $scope.setVideoSize(spot.key);
            }
            else
            {
                var resultModal = angular.element('.m-result');
                var resultContent = resultModal.find('p');
                resultModal.show();
                resultContent.text(data.linkCorrect);
                resultModal.fadeOut(10000, function() {});
            }
          }
        }
        else if(data.linkCorrect != 'ok'){
            $scope.setModal(data.linkCorrect, 'none');
        }
      }
      else {
        console.log(data.error);
      }
    });
  };
  
    //привязка соцсети и закрытие попапа, если пользователь залогинился через соцсеть
    $scope.loginTimer = function()
    {
        if (!popup.closed) {
            var data = {token: $scope.user.token, bindNet:$scope.bindNet};
            $http.post('/spot/bindedContent', data).success(function(data) {
                if (typeof (data.loggedIn) != 'undefined' && typeof (data.linkCorrect) != 'undefined')
                {
                    if (data.loggedIn)
                    {
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
                                
                                angular.element('body').css('cursor', 'default');
                                angular.element('#dropbox textarea').css('cursor', 'text');
                               
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

                            popup.close();
                            $scope.bindNet = {};
                            var currentNet = $scope.getPatternInd(data.socnet);
                            if (currentNet > -1)
                                $scope.socPatterns[currentNet].BindByPaste = true;

                        }
                        else
                        {
                            var resultModal = angular.element('.m-result');
                            var resultContent = resultModal.find('p');
                            resultModal.show();
                            resultContent.text(data.linkCorrect);
                            resultModal.fadeOut(10000);
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

    $scope.getSocPatterns = function()
    {
        $scope.freeSocial = true;
        if (typeof ($scope.socPatterns) == 'undefined')
        {
            var data = {token:$scope.user.token};
            $http.post('/spot/SocPatterns', data).success(function(data) {
                $scope.socPatterns = data.socPatterns;
                for (var i = 0; i < $scope.socPatterns.length; i++)
                {
                    if (typeof ($scope.socPatterns[i].BindByPaste) == 'undefined')
                        $scope.socPatterns[i].BindByPaste = false;
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

  // Атрибут согласия с условиями сервиса
  $scope.setTerms = function(spot){
    if (spot.terms == 1) spot.terms = 0;
    else spot.terms = 1;
  };

  // Следим за полями добавления спота
  $scope.$watch('spot.code + spot.terms', function(spot) {
    if ($scope.spot && $scope.spot.code){
      if (($scope.spot.terms == 1) && ($scope.spot.code.length == 10)) {
        angular.element('#add-spot .form-control a').removeClass('button-disable');
      }
      else {
        angular.element('#add-spot .form-control a').addClass('button-disable');
      }
    }

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
      }
      else if (data.error == 'yes') {
        angular.element('#actSpotForm input[name=code]').addClass('error');
        angular.element('#actSpotForm input[name=name]').addClass('error');
      }
    });
  };

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
            }
            else if (data.error == 'yes') {
                angular.element('#setPassForm input[name=newPass]').addClass('error');
            }
        });
    };
    
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

  //Открыть спот по коду
  $scope.defOpen = function(discodes){
    if (discodes == 0)  return false;

    var defSelector = '#' + discodes;
    var spot = angular.element(defSelector);
    $scope.accordion(spot, 1);
    $('html, body').animate({
      scrollTop: $(defSelector).offset().top
    }, 200);
  };
}
