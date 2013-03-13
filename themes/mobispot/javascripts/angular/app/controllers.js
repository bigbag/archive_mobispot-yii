'use strict';

function UserCtrl($scope, $http, $compile)
{
    //Авторизация
    $scope.login = function(user)
    {
        $http.post('/ajax/login', user).success(function(data)
        {
            if (data.error == 'yes')
            {
                angular.element('#sign-in input[name=email]').addClass('error');
                angular.element('#sign-in input[name=password]').addClass('error');

            }
            else {
                angular.element('.auth-hint').hide();
                $().redirect('', null, 'GET');
            }
        });
    };
}
