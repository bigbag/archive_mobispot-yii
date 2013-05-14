'use strict';

function $id(id) {
  return document.getElementById(id);
}

function SpotCtrl($scope, $http, $compile) {
  $scope.maxSize = 25*1024*1024;
  $scope.progress = 0;
  $scope.spot_edit = false;
  $scope.keys = [];
  $scope.action = false;

  var renameSpot = angular.element('#rename-spot');
  var confirm = angular.element('#confirm');

  // $scope.sortableOptions = {
  //   update: function(e, ui) {
  //     console.log(e*-);
  //   },
  //   containment: '#spotslistview > ul > li',
  // };


  // Следим за очередностью блоков
  // $scope.$watch('keys', function() {
  //   console.log($scope.keys);
  // });

  $(document).on('click','.store-items__close', function(){
    $(this).parents('tr').remove();
  });

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

  function uploadProgress(evt) {
    $scope.$apply(function(){
      if (evt.lengthComputable) {
        $scope.progress = Math.round(evt.loaded * 100 / evt.total)
      } else {
        $scope.progress = 'unable to compute'
      }
    })
  }

  $scope.uploadComplete = function(e) {
    var result = e.target.responseText;
    if (result){
      var data = angular.fromJson(result);
      if(data.error == 'no') {
        var content = angular.element('#add-content');
        content.hide().before($compile(data.content)($scope));
        $scope.keys.push(data.key);
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
      angular.element('#add-content').show();

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
  $scope.accordion = function(e, token) {
    var spot = angular.element(e.currentTarget).parent();
    var discodes = spot.attr('id');
    var spotContent = spot.find('.spot-content');
    var spotHat = spot.find('.spot-hat');
    $scope.keys = [];

    if ($scope.spot.status == 2){
      $scope.spot.invisible = true;
    }
    else {
      $scope.spot.invisible = false;
    }

    if (spotContent.attr('class') == null) {
      $http.post('/spot/spotView', {discodes:discodes, token:token}).success(function(data) {
          if(data.error == 'no') {
            var oldSpotContent = angular.element('.spot-content');
            angular.element('.spot-content_li').removeClass('open');
            oldSpotContent.slideUp('slow', function () {
              oldSpotContent.remove();
            });

            spotHat.after($compile(data.content)($scope));
            spot.addClass('open');
            spot.find('.spot-content').slideToggle('slow');

            $scope.spot.content='';

            var filedrag = $id('dropbox');
            if (filedrag) {
              var xhr = new XMLHttpRequest();
              if (xhr.upload) {
                filedrag.addEventListener("dragover", fileDragHover, false);
                filedrag.addEventListener("dragleave", fileDragHover, false);
                filedrag.addEventListener("drop", fileSelectHandler, false);
              }
            }
          }
      });
    }
    else {
      delete $scope.spot.content_new;
      spotContent.slideUp('slow',
        function () {
          spot.removeClass('open');
          spotContent.prev().remove();
          spotContent.remove();
        });
    }
  }

  // Добавление нового блока в спот
  $scope.addContent = function(spot) {
    if (spot.content && spot.user) {
      $http.post('/spot/spotAddContent', spot).success(function(data) {
        if(data.error == 'no') {
          angular.element('#add-content').before($compile(data.content)($scope));

          $scope.keys.push(data.key);
          // console.log($scope.keys);
          $scope.spot.content='';
          angular.element('textarea').removeClass('put');
        }
      });
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
      var spotData = spotItem.find('.item-type__text');

      $scope.spot.content_new = spotData.text();
      var spotEditText = spotEdit.find('textarea');
      spotEditText.text($scope.spot.content_new);

      spotEdit.removeClass('hide');
      spotEditText.focus(1);
      spotItem.hide().before($compile(spotEdit)($scope));
    }
    else {
      $scope.hideSpotEdit();
    }
  };

	// Привязка соцсетей
	var popup;
	$scope.bindSocial  = function(spot, key, e) {
	    spot.key = key;
		$http.post('/spot/BindSocial', spot).success(function(data) {
			if(data.error == 'no') {
				if(data.socnet != 'no'){
					if (!data.loggedIn){
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
					}else{
					    var spotEdit = angular.element(e.currentTarget).parents('.spot-item');
						var spotItem = spotEdit.next();
						spotEdit.before($compile(data.content)($scope));
						spotItem.remove();
					}
				}
			}
			else {
				alert(data.error);
			}
		});
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

  // Делаем спот неивдимым
  $scope.invisibleSpot = function(spot) {
    $scope.action = 'invisible';
    renameSpot.hide();
    confirm.show();
    angular.element('#confirm .button.round.active').focus();
  };

  // Удаление спота
  $scope.removeSpot = function(spot) {
    $scope.action = 'remove';
    renameSpot.hide();
    confirm.show();
    angular.element('#confirm .button.round.active').focus();
  };

  // Очистка спота
  $scope.cleanSpot = function(spot) {
    $scope.action = 'clear';
    renameSpot.hide();
    confirm.show();
    angular.element('#confirm .button.round.active').focus();
  };

  //Переименование спота
  $scope.renameSpot = function(spot) {
    $scope.action = 'rename';
    confirm.hide();
    renameSpot.show();
    angular.element('#rename-spot input').focus();
  };

  $scope.setNewName = function(spot) {
    if ($scope.spot.newName){
      $http.post('/spot/renameSpot', spot).success(function(data) {
        if(data.error == 'no') {
          var spotContent = angular.element('#' + spot.discodes);
          spotContent.find('.spot-hat h3').text(data.name);
          renameSpot.hide();
          delete $scope.spot.newName;
          angular.element('.popup').click();
          angular.element('.settings-list > li').removeClass('active');
        }
        else if (data.error == 'yes') {
          angular.element('#rename-spot input[name=newName]').addClass('error');
        }
      });
    }
  };

  //действия при положительном ответе
  $scope.confirmYes = function(spot) {
    var spotContent = angular.element('#' + spot.discodes);
    if ($scope.action == 'remove'){
      $http.post('/spot/removeSpot', spot).success(function(data) {
        if(data.error == 'no') {
          spotContent.slideUp('slow', function () {
            spotContent.remove();
          });
        }
      });
    }
    else if ($scope.action == 'clear'){
      $http.post('/spot/cleanSpot', spot).success(function(data) {
        if(data.error == 'no') {
          spotContent = angular.element('.spot-block').remove();
        }
      });
    }
    else if ($scope.action == 'invisible'){
      $http.post('/spot/invisibleSpot', spot).success(function(data) {
        if(data.error == 'no') {
          if ($scope.spot.invisible){
            $scope.spot.invisible = false;
          }
          else {
            $scope.spot.invisible = true;
          }
        }
      });
    }
    renameSpot.hide();
    confirm.hide();
    angular.element('.settings-list > li').removeClass('active');
  };

  $scope.confirmNo = function(spot) {
    if ($scope.action){
      angular.element('#confirm').hide();
      angular.element('.settings-list > li').removeClass('active');
      $scope.action = false;
    }
  };

  $scope.checkStatusSpot = function(spot) {
    return true;
  };
}