'use strict';

function $id(id) {
  return document.getElementById(id);
}

function UserCtrl($scope, $http, $compile, $timeout) {
  $scope.$watch('user.email + user.password', function(user) {

    if ($scope.user && $scope.user.email && $scope.user.password) {
      angular.element('#sign-in .form-control a').removeClass('button-disable');
    }
  });

  //Авторизация
  $scope.login = function(user) {
    if (!user.email || !user.password) return false;
    $http.post('/service/login', user).success(function(data) {
      if(data.error == 'login_error_count') {
        $http.post('/ajax/getBlock', {content:'sign_captcha_form'}).success(function(data)       {
          if(data.error == 'no') {
            var form = $compile(data.content)($scope);
            $http.post('/ajax/getBlock', {content:'captcha'}).success(function(data)           {
              if(data.error == 'no') {
                angular.element('#signInForm').html(form);
                angular.element('#signInForm .captcha').html($compile(data.content)($scope));
              }
            });
          }
        });
      }
      else if (data.error == 'yes') {
        angular.element('#sign-in input[name=email]').addClass('error');
        angular.element('#sign-in input[name=password]').addClass('error');
      }
      else {
        $(location).attr('href','/user/personal');
      }
    });
  };

  $scope.initTimer = function(){
    $http.post('/store/product/GetItemsInCart',{token: $scope.user.token}).success(function(data) {
      $scope.itemsInCart = data.itemsInCart;
    }).error(function(error){
      $scope.itemsInCart = 0;
    });
    var mytimeout = $timeout($scope.onTimeout,10000);
  };

  $scope.onTimeout = function(){
    $http.post('/store/product/GetItemsInCart',{token: $scope.user.token}).success(function(data) {
      $scope.itemsInCart = data.itemsInCart;
    });
    var mytimeout = $timeout($scope.onTimeout,10000);
  };
}

function HelpCtrl($scope, $http, $compile) {

  $scope.$watch('user.email + user.fName + user.question', function(user) {
    if ($scope.user.fName && $scope.user.email && $scope.user.question) {
      angular.element('#help-in .form-control a').removeClass('button-disable');
    }
  });


  $scope.send=function(user){
    $http.post('/ajax/sendQuestion', user).success(function(data) {
      if(data.error == 'no') {
        console.log(1);
      }
    });
  };
}

function SpotCtrl($scope, $http, $compile) {
   $scope.maxSize = 2500000;

  function output(msg) {
    var m = $id("messages");
    m.innerHTML = msg + m.innerHTML;
  }

  function fileDragHover(e) {
    e.stopPropagation();
    e.preventDefault();
    // e.target.className = (e.type == "spot-item dragover" ? "hover" : "");
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
        angular.element('#add-content').before($compile(data.content)($scope));
      }
    }
  }

  $scope.uploadFile = function(file) {

    var xhr = new XMLHttpRequest();
    if (xhr.upload && file.size <= $scope.maxSize) {
      xhr.addEventListener("load", $scope.uploadComplete, false)
      xhr.open("POST", "/spot/upload", true);
      xhr.setRequestHeader("X-File-Name", file.name);
      xhr.setRequestHeader("X-Discodes", $scope.spot.discodes);
      xhr.send(file);
    }
  }

  $scope.getVcard=function(spot){
    if (spot.vcard == 1) spot.vcard = 0;
    else spot.vcard = 1;
    $scope.setAttribute(spot);
  };

  $scope.getPrivate=function(spot) {
    if (spot.private == 1) spot.private = 0;
    else spot.private = 1;
    $scope.setAttribute(spot);
  };

  $scope.setAttribute=function(spot) {
    $http.post('/spot/spotAtributeSave', $scope.spot).success(function(data)           {
        if(data.error == 'no') {

        }
      });
  };

  $scope.accordion = function(e, token) {
    var spot = angular.element(e.currentTarget).parent();
    var discodes = spot.attr('id');
    var spotContent = spot.find('.spot-content');
    var spotHat = spot.find('.spot-hat');
    if (spotContent.attr('class') == null) {
      $http.post('/spot/spotView', {discodes:discodes, token:token}).success(function(data) {
          if(data.error == 'no') {
            var oldSpotContent = angular.element('.spot-content');
            angular.element('.spot-content_li').removeClass('open');
            oldSpotContent.slideUp(600, function () {
              oldSpotContent.remove();
            });

            $scope.spot.content='';
            spotHat.after($compile(data.content)($scope));
            spotContent = spot.find('.spot-content');
            spot.addClass('open');
            spotContent.slideToggle(600);

            var filedrag = $id('add-content');
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
      spot.removeClass('open');
      spotContent.slideUp(500,
        function () {
          spotContent.prev().remove();
          spotContent.remove();
        });
    }
  }

  $scope.saveSpot=function(spot) {
    if (spot.content && spot.user) {
      $http.post('/spot/spotSave', spot).success(function(data) {
        if(data.error == 'no') {
          angular.element('#add-content').before($compile(data.content)($scope));
          spot.content='';
        }
      });
    }
  };

  $scope.removeContent=function(spot, key, e) {
    spot.key = key;
    $http.post('/spot/spotRemoveContent', spot).success(function(data) {
      if(data.error == 'no') {
        var spotItem = angular.element(e.currentTarget).parent().parent().parent();
        spotItem.remove();
      }
    });
  };

  $scope.editContent=function(spot, key) {
     spot.key = key;
    $http.post('/spot/spotEditContent', spot).success(function(data) {
      if(data.error == 'no') {

      }
    });
  };
}