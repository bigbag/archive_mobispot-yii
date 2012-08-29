<script type="text/javascript">
    $(document).ready(function () {
        $('#account').click(function () {
            $().redirect('/user/account/', null, 'GET');
        });
    });
    //Блок меню пользователя
    $(document).ready(function () {
        $('#auth-user-name').click(function () {
            $(".user-menu-hint").show();
        });
        $('#main-container').on("click", function () {
            $(".user-menu-hint").hide();
        });
    });
    //Блок выбора языка
    $(document).ready(function () {
        $('#lang-select').click(function () {
            $(".lang-hint").show();
        });

        $('#main-container, .lang-hint a').on("click", function () {
            $(".lang-hint").hide();
        });
    });
    //Блок авторизации
    $(document).ready(function () {
        $('#button-auth').click(function () {
            $(".auth-hint").show();
        });

        $('#main-container').on("click", function () {
            $(".auth-hint").hide();
            $("#mistake-auth").hide();

        });
    });
    //Регистрация
    $(function () {
        var count = 0;
        $('#email, #password, #verifyPassword, #activ_code').bind('change', function(){
            count++;
        });
        $('#email, #password, #verifyPassword, #activ_code').bind('focus', function(){
            if (count == 3){
                $('#terms').show();
            }
        });
    });

    $(document).ready(function () {
        var options = {
            success:showRegistrationResponse,
            clearForm:false,
            url:'/ajax/registration/'
        };

        $('#registration').submit(function () {
            $(this).ajaxSubmit(options);
            return false;
        });
    });

    function showRegistrationResponse(responseText) {
        if (responseText == 1) {
            alert('<?php echo Yii::t("user", "Спасибо за регистрацию на нашем сайте, на указанную вами email была отправлено письмо с инструкцией по активации вашей учётной записи.")?>');
            $().redirect('/', null, 'GET');
        }
        else {
            var obj = jQuery.parseJSON(responseText);

            var error = "<ol>";
            if (obj.error.email) error += "<li>" + obj.error.email + "</li>";
            if (obj.error.password) error += "<li>" + obj.error.password + "</li>";
            if (obj.error.verifyPassword) error += "<li>" + obj.error.verifyPassword + "</li>";
            if (obj.error.terms) error += "<li>" + obj.error.terms + "</li>";
            if (obj.error.activ_code) error += "<li>" + obj.error.activ_code + "</li>";
            if (obj.error.verifyCode) error += "<li>" + obj.error.verifyCode + "</li>";
            error += "</ol>";

            $('#terms').show();
            $('#registration_captcha').show();
            $('#registration-form span.error').empty() ;
            $('#registration-form span.error').html(error);
        }
    }
    //Вход
    $(document).ready(function () {
        var options = {
            success:showLoginResponse,
            clearForm:true,
            url:'/ajax/login/'
        };

        $('#login_form').submit(function () {
            $(this).ajaxSubmit(options);
            return false;
        });

    });

    $(document).ready(function () {
        var options = {
            success:showLoginCaptchaResponse,
            dataType: 'json',
            clearForm:true,
            url:'/ajax/loginCaptcha/'
        };

        $('#login_captcha_form').submit(function () {
            $(this).ajaxSubmit(options);
            return false;
        });

    });

    function showLoginResponse(responseText) {
        if (responseText == 0) {
            $('#mistake-auth').show();
            $('#mistake-auth').text('<?php echo Yii::t('user', 'Пароль или логин не верен.')?>');
        }
        else if (responseText  == 'login_error_count'){
            $('#login_captcha_modal').reveal();

        }
        else if (responseText == 1) {
            $().redirect('/', null, 'GET');
        }
    }

    function showLoginCaptchaResponse(responseText) {
        if (responseText == 1) {
            $().redirect('/', null, 'GET');
        }
        else {
            $('#login_captcha_form span.error').text('<?php echo Yii::t("user", "Вы не правильно заполнили поля.")?>');
        }
    }

    //Восстановление пароля
    $(document).ready(function() {
        $('.forget-pass').click(function(e) {
            e.preventDefault();
            $('#recovery_modal').reveal();
        });
    });

    $(document).ready(function ()  {
        var options = {
            success:showRecoveryResponse,
            clearForm:true,
            url:'/ajax/recovery/'
        };

        $('#recovery_form').submit(function () {
            $(this).ajaxSubmit(options);
            return false;
        });
    });

    function showRecoveryResponse(responseText) {
        if (responseText == 1) {
            $('#recovery').hide();
            alert('<?php echo Yii::t("user", "По указанному вами адресу отправлено письмо с информацией о востановлении пароля.")?>');
            $().redirect('/', null, 'GET');
        }
        else if (responseText == 0) {
            $('#recovery_form span').text('<?php echo Yii::t("user", "Hа сайте не зарегистрирован пользователь с таким Email.")?>');
        }
    }

    $(document).ready(function () {
        $('input.txt').bind('focus', function () {
            $(this).parent().css('background-position', '100% -105px');
            $(this).parent().parent().css('background-position', '0 -70px');
        });
        $('input.txt').bind('blur', function () {
            $(this).parent().css('background-position', '100% -35px');
            $(this).parent().parent().css('background-position', '0 0');
        });
    });
    jQuery('input[placeholder], textarea[placeholder]').placeholder();

    $(document).ready(function() {
        $("select").selectBox();
    });
</script>
