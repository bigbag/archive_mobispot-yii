<article class="coupon<?php echo ($coupon['part'])?' active':''; ?>">
    <?php if($coupon['part']):?>
        <sup><?php echo Yii::t('spot', 'Participating')?></sup>
    <?php endif; ?>
    <h2><?php echo $coupon['name']?></h2>
    <div class="picture-block">
        <img src="/uploads/action/<?php echo $coupon['img']; ?>">
    </div>
    <div class="details">
        <p>
            <?php echo $coupon['desc']; ?>
        </p>
        <footer>
            <div class="soc-block">
                <?php if (!empty($coupon['soc_block'])) echo $coupon['soc_block']; ?>
                <?php if($coupon['part']):?>
                    <a class="accept" ng-click="disableAction($event, <?php echo $coupon['id']; ?>)"><?php echo Yii::t('spot', 'Cancel participation') ?></a>
                <?php else: ?>
                    <a class="accept" ng-click="checkLike($event, <?php echo $coupon['id']; ?>)"><?php echo Yii::t('spot', 'Participate') ?></a>
                <?php endif; ?>
            </div>
        </footer>
    </div>
</article>