<div id="login-captcha" style="display: none">
    <div class="cont-pop">
        <div class="close-btn"><?php echo Yii::t('user', 'Закрыть')?></div>
        <form action="#" method="post" id="login_captcha_form">
            <span class="error"></span>
            <center>Вы не правильно ввели комбинацию логина<br/> и пароля. Пожалуйста повторите попытку
                <table class="form">
                    <tr>
                        <td>
                            <center>
                                <div class="txt-form">
                                    <div class="txt-form-cl">
                                        <input type="text" name="LoginCaptchaForm[email]" style="width:100%;" class="txt"
                                               value="" placeholder="E-mail" autocomplete="off"/>
                                        <input type="hidden" name="token" id="token"
                                               value="<?php echo Yii::app()->request->csrfToken?>">
                                    </div>
                                </div>
                            </center>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <center>
                                <div class="txt-form">
                                    <div class="txt-form-cl">
                                        <input type="password" name="LoginCaptchaForm[password]" style="width:100%;"
                                               class="txt" value="" placeholder="Пароль" autocomplete="off"/>
                                    </div>
                                </div>
                            </center>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="dop-txt">Запомнить меня</span><input name="LoginCaptchaForm[rememberMe]"
                                                                              type="checkbox" class="niceCheck"></td>
                    </tr>
                    <tr>
                </table>
                Пожалуйста введите код показанный на картинке
                <table class="form">
                    <tr>
                        <td>
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
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <center>
                                <div class="txt-form">
                                    <div class="txt-form-cl">
                                        <input type="text" style="width:100%;" class="txt"
                                               name="LoginCaptchaForm[verifyCode]" value="" placeholder="" autocomplete="off"/>
                                    </div>
                                </div>
                            </center>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <center>
                                <div class="round-btn" style="float:right">
                                    <div class="round-btn-cl">
                                        <input type="submit" class="" value="Отправить"/>
                                    </div>
                                </div>
                            </center>
                        </td>
                    </tr>
                </table>
            </center>
        </form>
    </div>
</div>