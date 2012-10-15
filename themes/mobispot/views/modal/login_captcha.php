<div id="login_captcha_modal" class="reveal-modal" ng-controller="UserController" ng-init="user.token='<?php echo Yii::app()->request->csrfToken?>'">
    <div class="cont-pop">
        <a class="close-reveal-modal"><?php echo Yii::t('user', 'Закрыть')?></a>

        <form action="#" method="post" id="login_captcha_form" name="cform">
            <span class="error"></span>
            <p>
                <?php echo Yii::t('user', 'Вы не правильно ввели комбинацию логина<br/> и пароля. Пожалуйста повторите попытку');?>
            </p>
            <div class="row">
                <div class="seven columns centered">
                    <input type="email" ng-model="user.email" name="LoginCaptchaForm[email]" placeholder="<?php echo Yii::t('user', 'E-mail')?>" autocomplete="off" required />
                </div>
            </div>
            <div class="row">
                <div class="seven columns centered">
                    <input type="password" ng-model="user.password" name="LoginCaptchaForm[password]" placeholder="<?php echo Yii::t('user', 'Пароль')?>" autocomplete="off" required />
                </div>
            </div>
            <div class="row">
                <div class="seven columns centered">
                    <div class="remember-me">
                        <input type="checkbox" ng-model="user.rememberMe" name="LoginCaptchaForm[rememberMe]" ng-init="user.rememberMe=false"/>
                        <?php echo Yii::t('user', 'Запомнить меня')?>
                    </div>
                </div>
            </div>
            <p>
                <?php echo Yii::t('user', 'Пожалуйста введите код показанный на картинке')?>
            </p>
            <div class="row">
                <div class="seven columns centered">
                    <div class="img-capt"></div>
                </div>
            </div>
            <div class="row">
                <div class="seven columns centered">
                    <input type="text" ng-model="user.verifyCode" name="LoginCaptchaForm[verifyCode]" autocomplete="off" required />
                </div>
            </div>
            <div class="row">
                <div class="seven columns centered">
                    <div class="send">
                        <button class="m-button" ng-click="clogin(user)" ng-disabled="cform.$invalid">
                            <?php echo Yii::t('user', 'Отправить')?>
                        </button>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>