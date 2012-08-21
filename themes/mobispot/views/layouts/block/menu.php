<div class="center-rel" >
    <div id="sel-lang">
        <ul>
            <li class="sel"><span>Русский</span></li>
            <li class="no-sel"><a href="">English</a></li>
            <li class="no-sel"><a href="">French</a></li>
        </ul>
    </div>
    <div id="logo"><a href="/"><img src="/themes/mobispot/images/logo.png" alt="mobispot"></a></div>
    <?php ?>
    <div id="authorization">
        <div id="user_menu">
        <?php if (Yii::app()->user->isGuest):?>
        <form action="#" method="post" id="login_form">
            <div id="form-auth-login" >
                <input name="LoginForm[email]" type="text" class="txt-inp" placeholder="E-mail" autocomplete="off"/>
                <input type="hidden" name="token" id="token" value="<?php echo Yii::app()->request->csrfToken?>">
                <span id="save-me"><input name="LoginForm[rememberMe]" type="checkbox"><?php echo Yii::t('user', 'Запомнить меня')?></span>
            </div>
            <div id="form-auth-pass">
                <input name="LoginForm[password]" type="password" class="txt-inp" placeholder="Пароль" autocomplete="off"/>
                <span id="forget-pass"><?php echo Yii::t('user', 'Забыли пароль?')?></span>
            </div>
            <div id="button-auth"><span><?php echo Yii::t('user', 'Войти')?></span><input type="submit" value="<?php echo Yii::t('user', 'Войти')?>"  style="display:none" /></div>
        </form>
        <span id="mistake-auth" style="display:none"></span>
        <?php else:?>
        <?php $user_info = $this->userInfo();?>
        <div id="auth-on">
            <div id="button-exit"><a href="/user/logout"><span><?php echo Yii::t('user', 'Выйти')?></span></a></div>
		    <span id="auth-user-name"><?php echo $user_info->name;?><br />
			    <a href="/user/profile"><?php echo Yii::t('user', 'Изменить личные данные')?></a>
			</span>
        </div>
        <?php endif;?>
        </div>
    </div>
</div>