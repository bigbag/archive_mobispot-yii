<div id="main-container">
    <div id="cont-block" class="center">
        <div id="cont-block-760" class="center">
            <div id="zag-cont-block"><?php echo Yii::t('user', 'Авторизация')?></div>
            <?php echo CHtml::beginForm(); ?>
            <span class="error"><?php echo CHtml::errorSummary($model); ?></span>
            <center>
                <table class="form">
                    <tr>
                        <td>
                            <div class="txt-form">
                                <div class="txt-form-cl">
                                    <input type="text" name="LoginCaptchaForm[email]" style="width:100%;" class="txt"
                                           value="<?php echo $model->email;?>"
                                           placeholder="<?php echo Yii::t('user', 'E-mail')?>"/>
                                    <input type="hidden" name="token" id="token"
                                           value="<?php echo Yii::app()->request->csrfToken?>">
                                </div>
                            </div>

                        </td>
                    </tr>
                    <tr>
                        <td>
                            <center>
                                <div class="txt-form">
                                    <div class="txt-form-cl">
                                        <input type="password" name="LoginCaptchaForm[password]" style="width:100%;"
                                               class="txt" value="<?php echo $model->password;?>"
                                               placeholder="<?php echo Yii::t('user', 'Пароль')?>"/>
                                    </div>
                                </div>
                            </center>
                        </td>
                    </tr>

                    <tr>
                </table>
                <?php echo Yii::t('user', 'Введите код показанный на картинке')?>
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
                                               name="LoginCaptchaForm[verifyCode]" value="" placeholder=""/>
                                    </div>
                                </div>
                            </center>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="dop-txt"><?php echo Yii::t('user', 'Запомнить меня')?></span><input
                                name="LoginCaptchaForm[rememberMe]"
                                type="checkbox" class="niceCheck"></td>
                    </tr>
                    <tr>
                        <td>
                            <center>
                                <div class="round-btn" style="float:right">
                                    <div class="round-btn-cl">
                                        <?php echo CHtml::button(Yii::t('mobile', 'Отправить')); ?>
                                    </div>
                                </div>
                            </center>
                        </td>
                    </tr>
                </table>
            </center>
            <?php echo CHtml::endForm(); ?>
        </div>
    </div>
</div>
