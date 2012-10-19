<div id="spot_invisible_modal" class="reveal-modal" style="margin-left: -400px;">
    <div class="cont-pop">
        <a class="close-reveal-modal"><?php echo Yii::t('account', 'Закрыть')?></a>

        <form action="" method="POST" class="spot_invisible_form">
            <p>
                <span class="spot_invisible_on" style="display: none">
                     <?php echo Yii::t('account', 'Данное действие приведет к тому, что информация в Вашем споте  не будет видима никому.<br /> При попытке сканирования пользователи будут попадать на главную страницу сайта. ')?>
                </span>
                <span class="spot_invisible_off" style="display: none">
                    <?php echo Yii::t('account', 'Данное действие приведет к тому,<br /> что информация в Вашем споте опять станет видимой для всех. ')?>
                </span>

                <br/>
                <?php echo Yii::t('account', 'Продолжить?')?>
                <br/>
                <br/>
            </p>
            <input type="hidden" name="discodes_id" value="">
            <span class="r-btn-30 invisible"><span><?php echo Yii::t('account', 'Продолжить')?></span></span>

            <div class="clear"></div>
        </form>
    </div>
</div>
