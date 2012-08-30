<div id="spot_remove_modal" class="reveal-modal">
    <div class="cont-pop">
        <a class="close-reveal-modal"><?php echo Yii::t('account', 'Закрыть')?></a>

        <form action="" method="POST">
            <p>
                <?php echo Yii::t('account', 'Удалить спот ')?> <b class="spot_clear_id"></b>
                <br/>
                <br/>
            </p>
            <input type="hidden" name="discodes_id" value="">
            <a href="" class="r-btn-30"><span><span class="ico del-ico"></span><?php echo Yii::t('account', 'Удалить')?></span></a>

            <div class="clear"></div>
        </form>
    </div>
</div>
