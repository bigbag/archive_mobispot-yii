'use strict';

function UserCtrl($scope, $http, $compile)
{
  //Авторизация
  $scope.login = function(user)
  {
    $http.post('/ajax/login', user).success(function(data)
    {
      if(data.error == 'login_error_count')
      {
        $http.post('/ajax/getCaptcha', {content:1}).success(function(data)
        {
          if(data.error == 'no' && user.error != 'captcha')
          {
            user.error='captcha';
            angular.element('#signInForm .captcha').html($compile(data.content)($scope));
            angular.element('.spot-button.login').hide();
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
        angular.element('.auth-hint').hide();
        $().redirect('', null, 'GET');
      }
    });
  };
}