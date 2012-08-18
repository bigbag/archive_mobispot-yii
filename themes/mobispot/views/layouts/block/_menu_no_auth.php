<form action="#" method="post" id="login_form">
    <div id="form-auth-login" >
        <input name="LoginForm[email]" id="username" type="text" class="txt-inp" placeholder="E-mail" />
        <input type="hidden" name="token" id="token" value="<?php echo Yii::app()->request->csrfToken?>">
        <span id="save-me"><input name="LoginForm[rememberMe]" type="checkbox"><?php echo Yii::t('user', 'Запомнить меня')?></span>
    </div>
    <div id="form-auth-pass">
        <input name="LoginForm[password]" id="password" type="password" class="txt-inp" placeholder="Пароль" />
        <span id="forget-pass"><a href="#"><?php echo Yii::t('user', 'Забыли пароль?')?></a></span>
    </div>
    <div id="button-auth"><span><?php echo Yii::t('user', 'Войти')?></span><input type="submit" value="<?php echo Yii::t('user', 'Войти')?>"  style="display:none" /></div>
</form>
<span id="mistake-auth" style="display:none"><?php echo Yii::t('user', 'Неправильный логин или пароль?')?></span>