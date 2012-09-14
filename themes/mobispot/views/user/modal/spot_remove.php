<div id="spot_remove_modal" class="reveal-modal">
    <div class="cont-pop">
        <a class="close-reveal-modal"><?php echo Yii::t('account', 'Закрыть')?></a>

        <form action="" method="post" class="spot_remove_form">
            <p>
                <?php echo Yii::t('account', 'Удалить спот ')?> <b class="spot_remove_id"></b>
                <br/>
                <br/>
            </p>
            <input type="hidden" name="discodes_id" value="">
            <span class="r-btn-30 remove"><span><span
                class="ico del-ico"></span><?php echo Yii::t('account', 'Удалить')?></span></span>

            <div class="clear"></div>
        </form>

    </div>
</div>
