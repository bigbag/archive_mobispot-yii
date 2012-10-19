<div id="spot_clear_modal" class="reveal-modal">
    <div class="cont-pop">
        <a class="close-reveal-modal"><?php echo Yii::t('account', 'Закрыть')?></a>

        <form action="" method="POST" class="spot_clear_form">
            <p>
                <?php echo Yii::t('account', 'Указанное действие уничтожит всю информацию в споте')?>
                <b class="spot_clear_id"></b>
                <br/>
                <?php echo Yii::t('account', 'Продолжить?')?>
                <br/>
                <br/>
            </p>
            <input type="hidden" name="discodes_id" value="">
            <span class="r-btn-30 clear"><span><?php echo Yii::t('account', 'Продолжить')?></span></span>

            <div class="clear"></div>
        </form>
    </div>
</div>
