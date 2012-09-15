<div id="gallery_modal" class="reveal-modal">
    <div class="cont-pop">
        <a class="close-reveal-modal"><?php echo Yii::t('user', 'Закрыть')?></a>

        <form action="post.php" method="POST">
            <div id="galleryPhoto">
                <span id="numPhoto">3/10</span>
                <a href="" id="left" class="navGallery"></a>
                <a href="" id="right" class="navGallery"></a>
                <?php foreach (UserPersonalPhoto::getPhoto(Yii::app()->user->id) as $key => $value): ?>
                <a href="/uploads/images/<?php echo $value;?>" rel="prettyPhoto[pp_gal]"><img
                        src="/uploads/images/tmb_<?php echo $value;?>" width="60" alt="Fly kite, fly!"/></a>

                <?php endforeach;?>
            </div>
            <div id="galleryOption">
                <a href="" class="btn-30">
                    <span class="upload-ico ico"></span>
                    <span class="btn-30-txt"><?php echo Yii::t('account', 'Загрузить фото'); ?></span>
                </a>
                <a href="" class="btn-30">
                    <span class="star-ico ico"></span>
                    <span class="btn-30-txt"><?php echo Yii::t('account', 'Сделать основной'); ?></span>
                </a>
                <br/><br/>
                <a href="" class="btn-30">
                    <span class="del-ico ico"></span>
                    <span class="btn-30-txt"><?php echo Yii::t('account', 'Удалить'); ?></span>
                </a>
            </div>
            <div class="clear"></div>
        </form>


    </div>
</div>

