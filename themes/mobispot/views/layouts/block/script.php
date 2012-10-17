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



jQuery('input[placeholder], textarea[placeholder]').placeholder();

$(document).foundationAlerts();

</script>
