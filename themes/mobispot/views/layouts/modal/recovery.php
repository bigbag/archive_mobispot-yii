<div id="error-login" style="display: none;">
    <div id="cont-pop">
        <form action="#" method="post" id="recovery_form">
            <span></span>
            <center>
                <?php echo Yii::t('user', 'Если Вы забыли свой пароль и хотите его восстановить,<br /> введите адрес электронной почты,<br /> который Вы использовали при регистрации.')?>
                <table class="form">

                    <tr>
                        <td>
                            <center>
                                <div class="txt-form">
                                    <div class="txt-form-cl">
                                        <input type="text" style="width:100%;" class="txt" name="email" value="" placeholder="E-mail"/></div>
                                </div>
                            </center>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <center>
                                <div class="round-btn" style="width:130px">
                                    <div class="round-btn-cl">
                                        <input type="hidden" name="token" id="token" value="<?php echo Yii::app()->request->csrfToken?>">
                                        <input type="submit" class="" value="<?php echo Yii::t('user', 'Восстановить')?>"/>
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

