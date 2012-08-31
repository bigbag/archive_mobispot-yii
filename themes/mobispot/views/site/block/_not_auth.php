<h2><?php echo Yii::t('general', 'Начните использовать Ваш спот<br /> прямо сейчас')?></h2>
<span class="error"></span>
<form action="#" method="post" id="registration">

    <div class="txt-form">
        <div class="txt-form-cl">
            <input type="text" id="email" style="width:325px;" class="txt"
                   name="RegistrationForm[email]"
                   value="" placeholder="<?php echo Yii::t('user', 'Адрес электронной почты');?>"
                   autocomplete="off"/></div>
    </div>
    <div class="txt-form">
        <div class="txt-form-cl">
            <input type="text" id="password" style="width:325px;" class="txt"
                   name="RegistrationForm[password]"
                   value="" placeholder="<?php echo Yii::t('user', 'Пароль');?>" autocomplete="off"/>
        </div>
    </div>
    <div class="txt-form">
        <div class="txt-form-cl">
            <input type="text" id="verifyPassword" style="width:325px;" class="txt"
                   name="RegistrationForm[verifyPassword]"
                   value="" placeholder="<?php echo Yii::t('user', 'Подтверждение пароля');?>"
                   autocomplete="off"/></div>
    </div>
    <div class="txt-form">
        <div class="txt-form-cl">
            <input type="text" id="activ_code" style="width:325px;" class="txt"
                   name="RegistrationForm[activ_code]"
                   value="" placeholder="<?php echo Yii::t('user', 'Код активации спота');?>"
                   autocomplete="off"/></div>
    </div>
    <div id="registration_captcha" style="display: none">
        <?php echo Yii::t('user', 'Введите код показанный на картинке');?>
        <div id="img-capt">
            <?php $this->widget('CCaptcha', array(
            'clickableImage' => true,
            'showRefreshButton' => true,
            'buttonType' => 'button',
            'buttonOptions' =>
            array('type' => 'image',
                'src' => "/themes/mobispot/images/ico-refresh.png",
                'width' => 21,
            ),
        ));?>
        </div>
        <div class="txt-form">
            <div class="txt-form-cl">
                <input type="text" id="verifyCode" style="width:325px;" class="txt"
                       name="RegistrationForm[verifyCode]"
                       value=""/></div>
        </div>
    </div>
    <div id="terms" style="display: none;">
        <input type="checkbox" name="RegistrationForm[terms]" value="1" class="niceCheck">
                    <span class="dop-txt">
                        <?php echo Yii::t('user', 'Я согласен с условиями предоставления сервиса');?>
                    </span>
    </div>

    <div class="btn-30">
        <input type="hidden" name="token" id="token"
               value="<?php echo Yii::app()->request->csrfToken?>">

        <div><input type="submit" value="<?php echo Yii::t('user', 'Зарегистрироваться');?>"/></div>
    </div>
</form>