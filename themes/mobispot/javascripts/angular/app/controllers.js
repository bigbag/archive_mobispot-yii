'use strict';

function UserCtrl($scope, $timeout, $http, $compile)
{
  //Авторизация
  $scope.login = function(user)
  {
    $http.post('/service/login', user).success(function(data)
    {
      if(data.error == 'login_error_count')
      {
        $http.post('/ajax/getBlock', {content:'sign_captcha_form'}).success(function(data)
        {
          if(data.error == 'no')
          {
            var form = $compile(data.content)($scope);
            $http.post('/ajax/getBlock', {content:'captcha'}).success(function(data)
            {
              if(data.error == 'no')
              {
                angular.element('#signInForm').html(form);
                angular.element('#signInForm .captcha').html($compile(data.content)($scope));
              }
            });
          }
        });
      }
      else if (data.error == 'yes')
      {
        angular.element('#sign-in input[name=email]').addClass('error');
        angular.element('#sign-in input[name=password]').addClass('error');

      }
      else
      {
        $(location).attr('href','/user/account');
      }
<<<<<<< HEAD
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