<div id="login">
<div class="shadow"></div>
<div class="login_popup">
<div class="login_popup_inner">
<a href="#" id="login_popup_close"></a>
<strong>Вход</strong>

<form action="#" method="post" id="login_form" name="enter">
<span class="login_error"></span>
<input name="LoginForm[email]" id="username" value="E-mail" onfocus="inp(1,this,'E-mail')"
onblur="inp(0,this,'E-mail')" type="text"/>
<input name="LoginForm[password]" id="password" type="password"/>
<input type="hidden" name="token" id="token" value="<?php echo Yii::app()->request->csrfToken?>">
<button type="submit" class="login_button">&nbsp;</button>
<a href="#" id="recovery_link">Забыли пароль?</a>
</form>

<div id="social">
Войти через социальные сети:<br/>
<a href="/service/social?service=facebook" class="facebook"><img src="/themes/runbee/images/soc_fb.png"
alt=""></a> <a
href="/service/social?service=vkontakte" class="vkontakte"><img
src="/themes/runbee/images/soc_vk.png"
alt=""></a> <a
href="/service/social?service=odnoklassniki" class="vkontakte" class="odnoklassniki"><img
src="/themes/runbee/images/soc_od.png" alt=""></a>
</div>
</div>
</div>
</div>
<script type="text/javascript">
jQuery(function ($) {
    $(".enter_socials .facebook").eauth({"popup":{"width":585, "height":290}, "id":"facebook"});
    $(".enter_socials .vkontakte").eauth({"popup":{"width":585, "height":350}, "id":"vkontakte"});
    $(".enter_socials .odnoklassniki").eauth({"popup":{"width":680, "height":500}, "id":"odnoklassniki"});
});
</script>