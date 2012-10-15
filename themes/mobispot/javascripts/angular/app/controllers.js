'use strict';

function LoginController($scope) {

    $scope.login = function(user) {
        if(user){
            $.ajax({
                url:'/ajax/login',
                dataType:"json",
                type:'POST',
                data:angular.toJson(user),
                success:function (result) {
                    var messages = angular.fromJson(result);
                    if(messages.error == 'login_error_count'){
                        $.ajax({
                            url:'/ajax/getCaptcha',
                            type:'POST',
                            success:function (result) {
                                $('#login_captcha_modal div#img-capt').html(result);
                            }
                        });
                        $('#login_captcha_modal').reveal({animation:'none'});
                    }
                    else if (messages.error == 'yes'){
                        $('.login-form input').removeClass('ng-valid');
                        $('.login-form input').addClass('ng-invalid');
                    }
                    else {
                        $('.auth-hint').hide();
                        $().redirect('', null, 'GET');
                    }
                }
            });
        }
    };

}

function RegistrationController($scope) {

    $scope.registration = function(user) {
        if(user){
            $.ajax({
                url:'/ajax/registration/',
                dataType:"json",
                type:'POST',
                data:angular.toJson(user),
                success:function (result) {

                }
            });
        }
    };

}

function FaqController($scope) {

    $scope.question = function(faq) {
        if(faq){
            $.ajax({
                url:'/ajax/setQuestion/',
                dataType:"json",
                type:'POST',
                data:angular.toJson(faq),
                success:function (result) {
                    var messages = angular.fromJson(result);
                    if(messages.error == 'no'){
                        $('.question-form').hide();
                        $('.messages').show();
                        setTimeout(function () {
                            $('.messages').hide();
                            $('.get-question a.m-button').show();
                        }, 3000);
                    }
                }
            });
        }
    };

}