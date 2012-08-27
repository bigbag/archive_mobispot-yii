<div class="auth-hint">
    <table class="form">
        <tr>
            <td>
            <div class="txt-form">
                <div class="txt-form-cl">
                    <input type="text" name="LoginForm[email]" style="width:100%;" class="txt" placeholder="<?php echo Yii::t('user', 'E-mail')?>"/>
                    <input type="hidden" name="token" value="<?php echo Yii::app()->request->csrfToken?>">
                </div>
            </div>
            </td>
        </tr>
        <tr>
            <td>
            <div class="txt-form">
                <div class="txt-form-cl">
                    <input type="password" name="LoginForm[password]" style="width:100%;"  placeholder="<?php echo Yii::t('user', 'Пароль')?>"/>
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
                <div class="btn-30">
                    <div><input type="submit" id="hint-button-auth" value="<?php echo Yii::t('user', 'Отправить');?>"/></div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <span id="mistake-auth" style="display:none;text-align: right"></span>
            </td>
        </tr>
        <tr>
            <td style="text-align: right">
                <span class="forget-pass"><?php echo Yii::t('user', 'Забыли пароль?')?></span>
            </td>
        </tr>
    </table>
</div>