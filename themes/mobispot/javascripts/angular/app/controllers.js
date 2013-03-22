'use strict';

function UserCtrl($scope, $http, $compile)
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
        $(location).attr('href','/user/personal');
      }
    });
  };
}

function SpotCtrl($scope, $http, $compile)
{

  $scope.getVcard=function(spot){
    if (spot.vcard == 1) spot.vcard = 0;
    else spot.vcard = 1;
  };

  $scope.getPrivate=function(spot){
    if (spot.private == 1) spot.private = 0;
    else spot.private = 1;
  };

  $scope.accordion = function(e){
    var spot = angular.element(e.currentTarget).parent().parent();
    var discodes = spot.attr('id');
    var spotContent = spot.find('.spot-content');
    if (spotContent.is(":hidden")) {
      $http.post('/ajax/spotView', {discodes:discodes}).success(function(data)
        {
          if(data.error == 'no')
          {
            angular.element('.spot-content_li').removeClass('open');
            angular.element('.spot-content').slideUp(500);

            spotContent.html($compile(data.content)($scope));
            spot.addClass('open');
            spotContent.slideToggle(500);
          }
      });


    }
    else {
      spot.removeClass('open');
      spotContent.slideUp(500);
      spotContent.empty();
    }
  }
}

function HelpCtrl($scope, $http, $compile)
{
  $scope.send=function(user){
    $http.post('/ajax/sendQuestion', user).success(function(data)
    {
      if(data.error == 'no')
      {
        console.log(1);
      }
    });
  };
}