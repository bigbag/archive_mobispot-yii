<div id="main-container">
    <a class="btn-cent ico rad4 shadow" href="<?php echo Yii::app()->par->load('videoMobileUrl'); ?>" target="_blank">
        <span></span><?php echo Yii::t('mobile', 'Смотреть видео о Мобиспот');?>
    </a>
    <br/>
    <a href=""
       id="fullVersion"><?php echo Yii::t('mobile', 'Полная версия');?></a>

    <div class="grayAllBlock rad6 shadow">
        <form>
            <table class="proc100">
                <tr>
                    <td>
                        <input type="text" class="txt-100p rad6" value="" placeholder="Адрес электронной почты"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text" class="txt-100p rad6" value="" placeholder="Пароль"/>
                    </td>
                </tr>
            </table>
            <input type="submit" class="btn-round fright rad12 shadow" value="Войти"/>
            <br/><br/>
            <a href="" class="fright"><?php echo Yii::t('mobile', 'Забыли пароль?');?></a>
        </form>
    </div>
</div>