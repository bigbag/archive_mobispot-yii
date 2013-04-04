'use strict';

function $id(id) {
  return document.getElementById(id);
}

function UserCtrl($scope, $http, $compile)  {
  $scope.$watch('user.email + user.password', function(user)  {

    if ($scope.user.email && $scope.user.password)  {
      angular.element('#sign-in .form-control a').removeClass('button-disable');
    }
  });

  //Авторизация
  $scope.login = function(user) {
    if (!user.email || !user.password) return false;
    $http.post('/service/login', user).success(function(data) {
      if(data.error == 'login_error_count') {
        $http.post('/ajax/getBlock', {content:'sign_captcha_form'}).success(function(data)        {
          if(data.error == 'no')  {
            var form = $compile(data.content)($scope);
            $http.post('/ajax/getBlock', {content:'captcha'}).success(function(data)            {
              if(data.error == 'no')  {
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
      else  {
        $(location).attr('href','/user/personal');
      }
    });
  };

  $scope.initTimer = function(token){
    $scope.token = token;
    $http.post('/store/product/GetItemsInCart',{token: token}).success(function(data) {
      $scope.itemsInCart = data.itemsInCart;
    }).error(function(error){
      $scope.itemsInCart = 0;
    });
    var mytimeout = $timeout($scope.onTimeout,1000);
  };

  $scope.onTimeout = function(){
    $http.post('/store/product/GetItemsInCart',{token: $scope.token}).success(function(data) {
      $scope.itemsInCart = data.itemsInCart;
    });
      mytimeout = $timeout($scope.onTimeout,1000);
  };
}

function HelpCtrl($scope, $http, $compile)  {

  $scope.$watch('user.email + user.fName + user.question', function(user) {
    if ($scope.user.fName && $scope.user.email && $scope.user.question) {
      angular.element('#help-in .form-control a').removeClass('button-disable');
    }
  });


  $scope.send=function(user){
    $http.post('/ajax/sendQuestion', user).success(function(data) {
      if(data.error == 'no')  {
        console.log(1);
      }
    });
  };
}

function SpotCtrl($scope, $http, $compile)  {
   $scope.maxSize = 2500000;

  function output(msg) {
    var m = $id("messages");
    m.innerHTML = msg + m.innerHTML;
  }

  function fileDragHover(e) {
    e.stopPropagation();
    e.preventDefault();
    e.target.className = (e.type == "dragover" ? "hover" : "");
  }

  function fileSelectHandler(e) {
    fileDragHover(e);
    var files = e.target.files || e.dataTransfer.files;

    for (var i = 0, f; f = files[i]; i++) {
      $scope.uploadFile(f);
      $scope.parseFile(f);
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

  $scope.parseFile= function(file) {
    if (file.type.indexOf("image") == 0) {
      var reader = new FileReader();
      reader.onload = function(e) {


        var txt = '<div class="spot-item">' +
          '<div class="item-area text-center">' +
          '<img src="' + e.target.result + '">' +
          '<div class="spot-cover slow">' +
          '<a class="button remove-spot round" href="javascripts:;"></a>' +
          '<div class="move-spot"><i></i><span>Move your photo</span></div>' +
          '</div></div></div>';
          angular.element('#add-content').before($compile(txt)($scope));
      }
      reader.readAsDataURL(file);
    }

  }

  $scope.uploadFile = function(file) {

    var xhr = new XMLHttpRequest();
    if (xhr.upload && file.size <= $scope.maxSize) {
      xhr.open("POST", "upload.php", true);
      xhr.setRequestHeader("X-File-Name", file.name);
      xhr.send(file);
    }
  }

  $scope.getVcard=function(spot){
    if (spot.vcard == 1) spot.vcard = 0;
    else spot.vcard = 1;
    $scope.setAttribute(spot);
  };

  $scope.getPrivate=function(spot)  {
    if (spot.private == 1) spot.private = 0;
    else spot.private = 1;
    $scope.setAttribute(spot);
  };

  $scope.setAttribute=function(spot)  {
    $http.post('/ajax/spotAtributeSave', $scope.spot).success(function(data)            {
        if(data.error == 'no')  {

        }
      });
  };

  $scope.accordion = function(e, token)  {
    var spot = angular.element(e.currentTarget).parent().parent();
    var discodes = spot.attr('id');
    var spotContent = spot.find('.spot-content');
    if (spotContent.is(":hidden")) {
      $http.post('/ajax/spotView', {discodes:discodes, token:token}).success(function(data)  {
          if(data.error == 'no')  {
            var oldSpotContent = angular.element('.spot-content');
            angular.element('.spot-content_li').removeClass('open');
            oldSpotContent.slideUp(500);
            oldSpotContent.empty();

            $scope.spot.content='';
            spotContent.html($compile(data.content)($scope));
            spot.addClass('open');
            spotContent.slideToggle(500);

            var filedrag = $id("filedrag");
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
    else  {
      spot.removeClass('open');
      spotContent.slideUp(500);
      spotContent.empty();
    }
  }

  $scope.saveSpot=function(spot)  {
    if (spot.content && spot.user)  {
      $http.post('/ajax/spotSave', spot).success(function(data)  {
        if(data.error == 'no')  {
          angular.element('#add-content').before($compile(data.content)($scope));
          spot.content='';
        }
      });
    }
  };
}