'use strict';

function UserController($scope, $http)
{
    //Авторизация
    $scope.login = function(user)
    {
        $http.post('/ajax/login', user).success(function(data)
        {
            if(data.error == 'login_error_count')
            {
                $.ajax({
                    url:'/ajax/modal',
                    type:'POST',
                    data:{content:'login_captcha'},
                    success:function (result) {
                        $('.general-modal').html(result);
                        $.ajax({
                            url:'/ajax/getCaptcha',
                            type:'POST',
                            success:function (result) {
                                    $('#login_captcha_modal div#img-capt').html(result);
                                    $('#login_captcha_modal').reveal({animation:'none'});
                            }
                        });
                    }
                });

            }
            else if (data.error == 'yes'){
                $('.auth-hint .alert-box.alert.messages').show();
                    setTimeout(function () {
                        $('.auth-hint .alert-box.alert.messages').hide();
                    }, 3000);
            }
            else {
                $('.auth-hint').hide();
                $().redirect('', null, 'GET');
            }
        });
    };

    //Регистрация
    $scope.registration = function(user)
    {
        $http.post('/ajax/registration/', user).success(function(data)
        {
            if(data.error == 'no')
            {

            }
        });
    };

    //Вызов формы востановления пароля
    $scope.rmodal = function()
    {
        $.ajax({
            url:'/ajax/modal',
            type:'POST',
            data:{content:'password_recovery'},
            success:function (result) {
                $(".auth-hint").hide();
                $('.general-modal').html(result);
                $('#recovery_modal').reveal({animation:'none'});
            }
        });
    };
}

function FaqController($scope, $http)
{
    $scope.question = function(faq)
    {
        $http.post('/ajax/setQuestion/', faq).success(function(data)
        {
            if(data.error == 'no')
            {
                $('.question-form').hide();
                $('.messages').show();
                    setTimeout(function () {
                        $('.messages').hide();
                        $('.get-question a.m-button').show();
                    }, 3000);
            }
        });
    };
}