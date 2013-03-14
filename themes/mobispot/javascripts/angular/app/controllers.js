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
        alert(1);
        // $(location).attr('href','/');
      }
    });
  };
}