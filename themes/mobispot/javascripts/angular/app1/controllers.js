'use strict';

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
    $scope.isClean = function() {
        return angular.equals(self.original, $scope.project);
    }

    //вывод комментариев к споту типа обратная связь
    $scope.feedback_content = function(id) {
        $http.post('/ajax/spotFeedbackContent', {discodes:id}).success(function(data)
        {
            if(data.error == 'no')
            {
                angular.element('#' + id  + ' .spot-content-body').html($compile(data.content)($scope));
            }
        });
    }

    $scope.feedback = function(id) {
        $http.post('/ajax/spotView', {discodes:id}).success(function(data)
        {
            if(data.error == 'no')
            {
                angular.element('#' + id  + ' .spot-content-body').html($compile(data.content)($scope));
            }
        });
        $scope.discodes = false;
    }

    //аккардеон на странице редактирования спота
    $scope.accordion = function(e){
        if (e.target.tagName == 'INPUT' || e.target.tagName == 'BUTTON' || e.target.tagName == 'SPAN' || e.target.tagName == 'A') return;

        var spot = angular.element(e.currentTarget).parent().parent();
        var spot_content = spot.find('div.twelve.columns.spot-content');

        if (spot_content.is(":hidden")) {
            var id = spot.attr('id');
            //загрузка содержимого спота
            $http.post('/ajax/spotView', {discodes:id}).success(function(data)
            {
                if(data.error == 'no')
                {
                    angular.element('#' + id  + ' .spot-content-body').html($compile(data.content)($scope));
                }
            });
            $scope.discodes = false;

            angular.element('div.twelve.columns.spot-content').hide();
            spot_content.slideToggle(300);
        }
        else spot_content.slideUp(300);
        return false;
    }

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
                angular.element('.close-reveal-modal').click();
                angular.element('#' + data.discodes + ' div.name').html(data.name);
                angular.element('#' + data.discodes + ' div.type').html(data.type)
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

    //Невидимость спота спота
    $scope.invisible = function()
    {
        $http.post('/ajax/spotInvisible/', {discodes:$scope.discodes}).success(function(data)
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
        if ($scope.action){
            if ($scope.discodes && $scope.status)
            {
                angular.element('.spot-checkbox input[name=discodes_id]').attr('checked', false);
                $('select option:first', '#action-select').attr('selected', true);
                $('#action-select').select2({
                    'placeholder': "<?php echo Yii::t('account', 'Выберите действие');?>",
                    'width':'element',
                    'minimumResultsForSearch': 100,
                });

                switch (action) {
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
                        $http.post('/ajax/modal', {content:'spot_invisible', discodes:$scope.discodes}).success(function(data)
                        {
                            if(data.error == 'no')
                            {
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
            else
            {
                if ($scope.action == 'add'){
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