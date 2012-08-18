<script type="text/javascript">
    //Блок авторизации
    $(document).ready(function () {
        $('#button-auth').click(function () {
            $("#form-auth-login").show();
            $("#form-auth-pass").show();
            $("#button-auth input").show();
            $("#button-auth span").hide();
        });
    });
    //Регистрация
    $(document).ready(function () {
        var options = {
            success:showRegistrationResponse,
            clearForm:true,
            url:'/ajax/registration/'
        };

        $('#registration').submit(function () {
            $(this).ajaxSubmit(options);
            return false;
        });
    });

    function showRegistrationResponse(responseText) {
        if (responseText) {
            alert(1);
        }
        else {
            alert(0);
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

    function showLoginResponse(responseText) {
        if (responseText) {
            $('#user_menu').html(responseText);
        }
        else {
            $('#mistake-auth').show();
        }
    }

    //Восстановление пароля
    $(function () {
        $('body').delegate('#forget-pass', 'click', function () {
            $(function(){
                mw = new ModalWindowClass();
                mw.show($('#error-login').html());
            });
        });
        return false;
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
            $('#error-login').hide();
            alert('По указанному вами адресу отправлено письмо с информацией о востановлении пароля. ');
        }
        else if (responseText == 0) {
            $('#recovery_form span').text('Hа сайте не зарегистрирован пользователь с такими данными.');
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

    $(document).ready(function () {
        $('#circle-menu li').click(function () {

            $(".circle-hint:visible").not($(this).children(".circle-hint")).hide();
            $(this).children(".circle-hint").toggle();
        });
    });
    jQuery('input[placeholder], textarea[placeholder]').placeholder();
</script>
