<div class="auth-hint">
    <table class="form">
        <tr>
            <td>
                <div class="txt-form">
                    <div class="txt-form-cl">
                        <input type="text" name="LoginForm[email]" style="width:100%;" class="txt"
                               placeholder="<?php echo Yii::t('user', 'E-mail')?>"/>
                        <input type="hidden" name="token" value="<?php echo Yii::app()->request->csrfToken?>">
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="txt-form">
                    <div class="txt-form-cl">
                        <input type="password" name="LoginForm[password]" style="width:100%;"
                               placeholder="<?php echo Yii::t('user', 'Пароль')?>"/>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <input name="LoginForm[rememberMe]" type="checkbox" class="niceCheck">
                <span class="remember-me">
                    <?php echo Yii::t('user', 'Запомнить меня')?>
                </span>
                <table style="width: 100%">
                    <tr>
                        <td>
                            <a class="auth-link facebook" href="/service/social?service=facebook" title="facebook"><img
                                    src="/themes/mobispot/images/auth_facebook.png" alt="fb"></a>
                            <a class="auth-link twitter" href="/service/social?service=twitter" title="twitter"><img
                                    src="/themes/mobispot/images/auth_twitter.png" alt="tw"></a>
                            <a class="auth-link google_oauth" href="/service/social?service=google_oauth"
                               title="google"><img
                                    src="/themes/mobispot/images/auth_google.png" alt="g"></a>

                        </td>
                        <td>
                            <div class="btn-30" style="float: right">
                                <div><input type="submit" id="hint-button-auth"
                                            value="<?php echo Yii::t('user', 'Отправить');?>"/>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan=2 style="text-align: right">
                            <span class="forget-pass"><?php echo Yii::t('user', 'Забыли пароль?')?></span>
                            <span id="mistake-auth" style="display:none;"></span>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
</div>