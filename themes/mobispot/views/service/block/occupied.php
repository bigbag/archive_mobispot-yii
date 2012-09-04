<h2><?php echo Yii::t('general', 'Начните использовать Ваш спот<br /> прямо сейчас')?></h2>
<span class="error"></span>
<form action="#" method="post" id="registration">
    <input type="hidden" name="RegistrationForm[email]" value="<?=$email?>"/>
    <input type="hidden" name="RegistrationForm[password]" value="<?=$password?>"/>
    <input type="hidden" name="RegistrationForm[verifyPassword]" value="<?=$password?>"/>
    <?php echo Yii::t('user', 'Почта занята! Добавляйте новые аккаунты из профиля.')?>
    <br/>

    <div class="btn-30">
        <input type="hidden" name="token" id="token"
               value="<?php echo Yii::app()->request->csrfToken?>">

        <div><input type="submit" value="<?php echo Yii::t('user', 'Зарегистрироваться');?>"/></div>
    </div>
</form>