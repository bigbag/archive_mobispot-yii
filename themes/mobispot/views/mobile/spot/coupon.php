<article id="coupon-<?php echo $coupon['id']; ?>"
    class="coupon
    <?php if ($coupon['status']==WalletLoyalty::STATUS_ON):?>
        active
    <?php elseif ($coupon['status']==WalletLoyalty::STATUS_CONNECTING): ?>
        connecting
    <?php elseif ($coupon['status']==WalletLoyalty::STATUS_ERROR): ?>
        error-coupon
    <?php endif; ?>
    ">
    <?php if ($coupon['status']==WalletLoyalty::STATUS_ON):?>
        <sup><?php echo Yii::t('spot', 'Participating')?></sup>
    <?php elseif ($coupon['status']==WalletLoyalty::STATUS_CONNECTING): ?>
        <sup><?php echo Yii::t('spot', 'Connecting...')?></sup>
    <?php elseif ($coupon['status']==WalletLoyalty::STATUS_ERROR): ?>
        <sup><?php echo Yii::t('spot', 'Not connected')?></sup>
    <?php endif; ?>
    <h2><?php echo $coupon['name']?></h2>
    <div class="picture-block">
        <img src="/uploads/action/<?php echo $coupon['img']; ?>">
    </div>
    <div class="details">
        <p>
            <?php if ($coupon['status']==WalletLoyalty::STATUS_ERROR):?>
                <h3><?php echo Yii::t('spot', 'Для подключения акции не были выполнены следующие условия:')?></h3>
                <ul>
                    <?php foreach($coupon['errors'] as $error): ?>
                    <li>
                        <?php echo $error; ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <?php echo $coupon['desc']; ?>
            <?php endif; ?>
        </p>
        <footer>
            <div class="soc-block">
                <?php if (!empty($coupon['soc_block'])) echo $coupon['soc_block']; ?>
                <?php if ($coupon['status']==WalletLoyalty::STATUS_ON):?>
                    <?php /*
                    <a class="accept" ng-click="disableAction($event, <?php echo $coupon['id']; ?>)"><?php echo Yii::t('spot', 'Cancel participation') ?></a>
                    */ ?>
                <?php elseif ($coupon['status']==WalletLoyalty::STATUS_OFF or $coupon['status']==WalletLoyalty::STATUS_ERROR):?>
                    <a class="accept" ng-click="checkLike(<?php echo $coupon['id']; ?>, $event)"><?php echo Yii::t('spot', 'Participate') ?></a>
                <?php endif; ?>
            </div>
        </footer>
    </div>
</article>
