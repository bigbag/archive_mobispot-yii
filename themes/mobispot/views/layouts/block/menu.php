<div class="center-rel">
    <div id="sel-lang">
        <ul>
            <li class="sel"><span><?php echo Yii::t('menu', 'Русский')?></span></li>
            <li class="no-sel"><a href=""><?php echo Yii::t('menu', 'English')?></a></li>
            <li class="no-sel"><a href=""><?php echo Yii::t('menu', 'French')?></a></li>
        </ul>
    </div>
    <div id="logo"><a href="/"><img src="/themes/mobispot/images/logo.png" alt="mobispot"></a></div>
    <?php ?>
    <div id="authorization">
        <div id="user_menu">
            <?php if (Yii::app()->user->isGuest): ?>
            <form action="#" method="post" id="login_form">
                <div id="button-auth">
                    <span><?php echo Yii::t('user', 'Войти')?></span>
                </div>
                <?php include('auth.php'); ?>
            </form>
            <?php else: ?>
            <?php $user_info = $this->userInfo(); ?>
            <div id="auth-on">
                <div id="button-exit"><a href="/user/logout"><span><?php echo Yii::t('user', 'Выйти')?></span></a></div>
		    <span id="auth-user-name"><?php echo $user_info->name;?><br/>
			    <a href="/user/profile"><?php echo Yii::t('user', 'Изменить личные данные')?></a>
			</span>
            </div>
            <?php endif;?>
        </div>
    </div>
</div>