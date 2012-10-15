<script type="text/javascript">
//Блок меню пользователя
$(document).ready(function () {
    $('.auth-user-name').click(function () {
        $(".user-menu-hint").show();
    });
    $('.content').on("click", function () {
        $(".user-menu-hint").hide();
    });
});
//Блок выбора языка
$(document).ready(function () {
    $('.curent-lang').click(function () {
        $(".lang-hint").show();
    });

    $('.content, .lang-hint a').on("click", function () {
        $(".lang-hint").hide();
    });
});
//Блок авторизации
$(document).ready(function () {
    $('div.m-button').click(function () {
        $(".auth-hint").show();
    });

    $('.content').on("click", function () {
        $(".auth-hint").hide();

    });
});


function showRecoveryResponse(responseText) {
    if (responseText == 1) {
        $('#recovery_modal').hide();
        $('#messages_modal div.messages').html('<?php echo Yii::t("user", "По указанному вами адресу отправлено письмо<br/> с информацией о востановлении пароля.")?>');
        $('#messages_modal').reveal({animation:'none'});

        setTimeout(function () {
            $().redirect('/', null, 'GET');
        }, 3000);

    }
    else if (responseText == 0) {
        $('#recovery_form span').text('<?php echo Yii::t("user", "Hа сайте не зарегистрирован пользователь с таким Email.")?>');
    }
}

//like facebook
(function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

jQuery('input[placeholder], textarea[placeholder]').placeholder();

$(document).foundationAlerts();

</script>
