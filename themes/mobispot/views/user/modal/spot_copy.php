<div id="spot_copy_modal" class="reveal-modal">
    <div class="cont-pop">
        <a class="close-reveal-modal"><?php echo Yii::t('account', 'Закрыть')?></a>
        <form action="" method="post" class="spot_copy_form">
            <?php echo Yii::t('account', 'Введите ID-спота, в которую вы хотите скопировать содержимое спота')?>
            <b class="spot_copy_id"></b>
            <div class="txt-form">
                <div class="txt-form-cl">
                    <input type="hidden" name="discodes_id_from" value="">
                    <input style="width:100%;" class="txt" name="discodes_id_to" value="" placeholder="" type="text">
                </div>
            </div>
            <span class="red-txt">
                <?php echo Yii::t('account', 'Вся информация, содеражаяся в этом споте будет<br> уничтожена и заменена на копируемую информацию.')?>
            </span>
            <div class="round-btn" style="float:left">
                <div class="round-btn-cl">
                    <input class="" value="<?php echo Yii::t('account', 'Ок')?>" type="submit">
                </div>
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>