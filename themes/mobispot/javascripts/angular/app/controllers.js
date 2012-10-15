'use strict';

function LoginController($scope, $http)
{
    $scope.login = function(user)
    {
        $http.post('/ajax/login', user).success(function(data)
        {
            if(data.error == 'login_error_count')
            {
                $.ajax({
                    url:'/ajax/getCaptcha',
                    type:'POST',
                        success:function (result) {
                            $('#login_captcha_modal div#img-capt').html(result);
                        }
                    });
                    $('#login_captcha_modal').reveal({animation:'none'});
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
}

function RegistrationController($scope, $http)
{
    $scope.question = function(user)
    {
        $http.post('/ajax/registration/', user).success(function(data)
        {
            if(data.error == 'no')
            {

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