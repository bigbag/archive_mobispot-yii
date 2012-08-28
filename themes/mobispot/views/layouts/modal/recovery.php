<div id="recovery"  class="reveal-modal">
    <div class="cont-pop">
        <a class="close-reveal-modal"><?php echo Yii::t('user', 'Закрыть')?></a>
        <div style="text-align: center">
            <form action="#" method="post" id="recovery_form">
                <p>
                    <?php echo Yii::t('user', 'Если Вы забыли свой пароль и хотите его восстановить,<br /> введите адрес электронной почты,<br /> который Вы использовали при регистрации.')?>
                </p>
                <center>
                <table>
                    <tr>
                        <td>
                            <center>
                            <div class="txt-form">
                                <div class="txt-form-cl" >
                                    <input type="text" style="width:100%;" class="txt" name="email" value="" placeholder="E-mail" autocomplete="off"/>
                                </div>

                            </div>
                                <span class="error"></span>
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
</div>
