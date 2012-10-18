'use strict';

$(document).ready(function ()
{
    $('.content').on("click", function ()
    {
        $(".user-menu-hint").hide();
        $(".auth-hint").hide();
        $(".lang-hint").hide();
    });

    $('.lang-hint a').on("click", function ()
    {
        $(".lang-hint").hide();
    });
});

function MenuController($scope, $http)
{
    $scope.menu = function()
    {
        angular.element('.user-menu-hint').show();
    }

    $scope.lang = function()
    {
        angular.element('.lang-hint').show();
    }

    $scope.auth = function()
    {
        angular.element('.auth-hint').show();
    }
}

function SpotController($scope, $http)
{
    $scope.action = false;
    $scope.discodes = false;
    $scope.status = false;

    //диспетчер выбора операций
    $scope.$watch('action', function(action)
    {
        if ($scope.action && $scope.discodes && $scope.status)
        {
            angular.element('.spot-checkbox input[name=discodes_id]').attr('checked', false);
            angular.element('.action-menu .action option:first').attr('selected','selected');
            $("select.action").select2({
                'width':'element',
                'minimumResultsForSearch': 100,
            });

            switch ($scope.action) {
                case 'rename':
                    angular.element('#' + $scope.discodes + ' .spot-name div.rename').show();
                    angular.element('#' + $scope.discodes + ' .spot-name div.name').hide();
                    break

                case 'retype':
                    angular.element('#' + $scope.discodes + ' .spot-type div.retype').show();
                    angular.element('#' + $scope.discodes + ' .spot-type div.type').hide();
                    break

                case 'copy':
                    angular.element('b.spot_copy_id').text($scope.discodes);
                    angular.element('#spot_copy_modal input[name=discodes_id_from]').val($scope.discodes);
                    angular.element('#spot_copy_modal').reveal({animation:'none'});
                    break

                case 'invisible':
                    if (status) {
                        if (status == $scope.status) {
                            angular.element('.spot_invisible_off').show();
                            angular.element('.spot_invisible_on').hide();
                        }
                        else {
                            angular.element('.spot_invisible_off').hide();
                            angular.element('.spot_invisible_on').show();
                        }
                    }
                    angular.element('b.spot_invisible_id').text($scope.discodes);
                    angular.element('#spot_invisible_modal input').val($scope.discodes);
                    angular.element('#spot_invisible_modal').reveal({animation:'none'});

                    break

                case 'clear':
                    angular.element('b.spot_clear_id').text($scope.discodes);
                    angular.element('#spot_clear_modal input').val($scope.discodes);
                    angular.element('#spot_clear_modal').reveal({animation:'none'});
                    break

                case 'remove':
                    angular.element('b.spot_remove_id').text($scope.discodes);
                    angular.element('#spot_remove_modal input').val($scope.discodes);
                    angular.element('#spot_remove_modal').reveal({animation:'none'});
                    break

                case 'add':

                    break
            }
        }
    });

}

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
                        angular.element('.general-modal').html($compile(data.content)($scope));
                        $http.post('/ajax/getCaptcha', {content:1}).success(function(data)
                        {
                            if(data.error == 'no')
                            {
                                angular.element('#login_captcha_modal .img-capt').html(data.content);
                                angular.element('#login_captcha_modal').reveal({animation:'none'});
                            }
                        });
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

    //Авторизация с каптчей
    $scope.clogin = function(user)
    {
        $http.post('/ajax/loginCaptcha/', user).success(function(data)
        {
            if(data.error == 'yes')
            {
                angular.element('#login_captcha_modal .messages').show();
                $timeout(function()
                {
                    angular.element('#login_captcha_modal .messages').hide();
                }, 3000);
            }
            else if(data.error == 'no')
            {
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
            else if(data.error == 'no')
            {
                $().redirect('', null, 'GET');
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
                angular.element('.general-modal').html($compile(data.content)($scope));
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
                $http.post('/ajax/modal', {content:'messages'}).success(function(data)
                {
                    if(data.error == 'no')
                    {
                        angular.element('#recovery_modal').hide();
                        angular.element('.auth-hint').hide();
                        angular.element('.general-modal').html(data.content);
                        angular.element('#messages_modal .messages .recovery').show();
                        angular.element('#messages_modal').reveal({animation:'none'});
                    }
                });
            }
            else if (data.error == 'yes')
            {
                angular.element('.reveal-modal .messages').show();
                $timeout(function()
                {
                    angular.element('.reveal-modal .messages').hide();
                }, 3000);
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