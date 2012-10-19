'use strict';

//аккардеон на странице редактирования спота
$(document).ready(function () {

    $('body').delegate('div.spot-title>div.six.columns', 'click', function (e) {
        var spot = $(this).parent().parent();
        var spot_content = spot.find('div.twelve.columns.spot-content');
        if (e.target.tagName == 'INPUT' || e.target.tagName == 'BUTTON' || e.target.tagName == 'SPAN' || e.target.tagName == 'A')        return;

        if (spot_content.is(":hidden")) {
            var id = spot.attr('id');
            //загрузка содержимого спота
            if (id) {
                $.ajax({
                    url:'/ajax/spotView',
                    type:'POST',
                    data:{discodes_id:id},
                    success:function (result) {
                        $('#' + id  + ' .spot-content-body').html(result);
                    }
                });
            }
            $('div.twelve.columns.spot-content').hide();
            spot_content.slideToggle(300);


        }
        else spot_content.slideUp(300);
        return false;

    });
});

//Скрытие меню выбора языка и пользовательского
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

function SpotController($scope, $http, $compile, $timeout)
{
    //Добавление спота
    $scope.add = function()
    {
        $http.post('/ajax/spotAdd/', {code:$scope.code, type:$scope.type}).success(function(data)
        {
            if(data.error == 'no')
            {
                angular.element('.close-reveal-modal').click();
                $().redirect('', null, 'GET');
            }
        });
        $scope.discodes = false;
    }

    //Копирование спота
    $scope.copy = function()
    {
        $http.post('/ajax/spotCopy/', {discodes_from:$scope.discodes_from, discodes_to:$scope.discodes_to}).success(function(data)
        {
            if(data.error == 'no')
            {

            }
        });
        $scope.discodes = false;
    }

    //Переименование спота
    $scope.rename = function(name)
    {
        $http.post('/ajax/spotRename/', {discodes:$scope.discodes, name:name}).success(function(data)
        {
            if(data.error == 'no')
            {
                angular.element('#' + data.discodes + ' .spot-name div.name').html(data.name);
                angular.element('#' + data.discodes + ' .spot-name div.rename').hide();
                angular.element('#' + data.discodes + ' .spot-name div.name').show();
            }
        });
        $scope.discodes = false;
    }

    //Изменение типа спота
    $scope.retype = function(type_id)
    {
        $http.post('/ajax/spotRetype/', {discodes:$scope.discodes, type_id:type_id}).success(function(data)
        {
            if(data.error == 'no')
            {
                angular.element("#" + data.discodes + " .spot-type #Spot_spot_type_id [value='" + $scope.type_id + "']").attr("selected", "selected");
                angular.element('#' + data.discodes + ' .spot-type div.retype').hide();
                angular.element('#' + data.discodes + ' .spot-type div.type').html(data.type);
                angular.element('#' + data.discodes + ' .spot-type div.type').show();
            }
        });
        $scope.discodes = false;
    }

    //Очистка спота
    $scope.clear = function()
    {
        $http.post('/ajax/spotClear/', {discodes:$scope.discodes}).success(function(data)
        {
            if(data.error == 'no')
            {
                angular.element('.close-reveal-modal').click();
            }
        });
        $scope.discodes = false;
    }

    //Удаление спота
    $scope.remove = function()
    {
        $http.post('/ajax/spotRemove/', {discodes:$scope.discodes}).success(function(data)
        {
            if(data.error == 'no')
            {
                $('#' + data.discodes).remove();
                angular.element('.close-reveal-modal').click();
            }
        });
        $scope.discodes = false;
    }

    //Диспетчер выбора операций
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
                    $http.post('/ajax/modal', {content:'spot_copy'}).success(function(data)
                    {
                        if(data.error == 'no')
                        {
                            angular.element('.general-modal').html($compile(data.content)($scope));
                            angular.element('#spot_copy_modal input[name=discodes_id_from]').val($scope.discodes);
                            angular.element('#spot_copy_modal').reveal({animation:'none'});
                        }
                    });
                    break

                case 'invisible':
                    $http.post('/ajax/modal', {content:'spot_invisible'}).success(function(data)
                    {
                        if(data.error == 'no')
                        {
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

                            angular.element('.general-modal').html($compile(data.content)($scope));
                            angular.element('#spot_invisible_modal input').val($scope.discodes);
                            angular.element('#spot_invisible_modal').reveal({animation:'none'});
                        }
                    });
                    break

                case 'clear':
                    $http.post('/ajax/modal', {content:'spot_clear'}).success(function(data)
                    {
                        if(data.error == 'no')
                        {
                            angular.element('.general-modal').html($compile(data.content)($scope));
                            angular.element('#spot_clear_modal').reveal({animation:'none'});
                        }
                    });
                    break

                case 'remove':
                    $http.post('/ajax/modal', {content:'spot_remove'}).success(function(data)
                    {
                        if(data.error == 'no')
                        {
                            angular.element('.general-modal').html($compile(data.content)($scope));
                            angular.element('#spot_remove_modal').reveal({animation:'none'});
                        }
                    });
                    break
            }

        }
        else if (action)
        {
            if (action == 'add'){
                $http.post('/ajax/modal', {content:'spot_add'}).success(function(data)
                    {
                        if(data.error == 'no')
                        {
                            angular.element('.general-modal').html($compile(data.content)($scope));
                            $("select.spot_type").select2({
                                'width':'element',
                                'minimumResultsForSearch': 100,
                            });
                            angular.element('#spot_add_modal').reveal({animation:'none'});
                        }
                    });
            }
        }

        $scope.action = false;
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