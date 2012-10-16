'use strict';

function UserController($scope, $http, $compile, $timeout, $location)
{
    //Авторизация
    $scope.login = function(user)
    {
        $http.post('/ajax/login', user).success(function(data)
        {
            if(data.error == 'login_error_count')
            {
                $http.post('/ajax/modal', {content:'login_captcha'}).success(function(data)
                {
                    if(data.error == 'no')
                    {
                        angular.element('.auth-hint').hide();
                        angular.element('.general-modal').html(data.content);

                        $.ajax({
                            url:'/ajax/getCaptcha',
                            type:'POST',
                            success:function (result) {
                                angular.element('#login_captcha_modal .img-capt').html(result);
                            }
                        });
                        angular.element('#login_captcha_modal').reveal({animation:'none'});
                    }
                });
            }
            else if (data.error == 'yes')
            {
                angular.element('.auth-hint .alert-box.alert.messages').show();
                $timeout(function()
                {
                    angular.element('.auth-hint .alert-box.alert.messages').hide();
                }, 3000);
            }
            else {
                angular.element('.auth-hint').hide();
                $().redirect('', null, 'GET');
            }
        });
    };


    //Регистрация
    $scope.registration = function(user)
    {
        $http.post('/ajax/registration/', user).success(function(data)
        {
            if(data.error == 'yes')
            {
                angular.element(".registration .form").css("height", "350px");
                angular.element(".login.alert-box.alert.messages").show();
            }
        });
    };

    //Вызов формы востановления пароля
    $scope.rmodal = function()
    {
        $http.post('/ajax/modal', {content:'password_recovery'}).success(function(data)
        {
            if(data.error == 'no')
            {
                angular.element('.auth-hint').hide();
                angular.element('.general-modal').html(data.content);
                angular.element('#recovery_modal').reveal({animation:'none'});
            }
        });
    };

    //Восстановление пароля
    $scope.recovery = function(user)
    {
        $http.post('/ajax/recovery', user).success(function(data)
        {
            if(data.error == 'no')
            {

            }
        });
    };
}

function FaqController($scope, $http, $timeout)
{
    $scope.question = function(faq)
    {
        $http.post('/ajax/setQuestion/', faq).success(function(data)
        {
            if(data.error == 'no')
            {
                angular.element('.question-form').hide();
                angular.element('.messages').show();
                $timeout(function()
                {
                    angular.element('.messages').hide();
                        angular.element('.get-question a.m-button').show();
                }, 3000);
            }
        });
    };
}