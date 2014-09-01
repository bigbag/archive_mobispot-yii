            <div id="coupon-<?php echo $coupon['id']; ?>"
                class="
                <?php if ($coupon['status']==WalletLoyalty::STATUS_ON):?>
                    active
                <?php elseif ($coupon['status']==WalletLoyalty::STATUS_CONNECTING): ?>
                    connecting
                <?php elseif ($coupon['status']==WalletLoyalty::STATUS_ERROR): ?>
                    error-coupon
                <?php endif; ?>
            spot-item item-area type-coupon <?php echo $coupon['coupon_class']; ?>">

            <?php if ($coupon['status']==WalletLoyalty::STATUS_ERROR):?>
            <div class="cover-coupon">
                <h3><?php echo Yii::t('spot', 'Для подключения акции не были выполнены следующие условия:')?></h3>
                <a href="javascript:;" ng-click="disableAction($event, <?php echo $coupon['id']; ?>)" class="close-info icon">&#xe00b;</a>
                <ul>
                    <?php foreach($coupon['errors'] as $error): ?>
                    <li>
                        <?php echo $error; ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php else: ?>

                <?php //<i class="coupon-indicator coupon-indicator__new">New</i> ?>
                <?php if($coupon['status']==WalletLoyalty::STATUS_ON):?>
                    <sup><?php echo Yii::t('spot', 'Participating')?></sup>
                <?php elseif ($coupon['status']==WalletLoyalty::STATUS_CONNECTING): ?>
                    <sup><?php echo Yii::t('spot', 'Connecting...')?></sup>
                <?php endif; ?>
                <div class="s-content">
                    <img src="/uploads/action/<?php echo $coupon['img']; ?>">
                </div>
                <div class="coupon-terms">
                    <div class="details">
                        <h3><?php echo $coupon['name']?>
                        </h3>
                        <?php echo $coupon['desc']; ?>
                        <div class="soc-block">
                            <?php if (!empty($coupon['soc_block'])) echo $coupon['soc_block']; ?>
                        </div>
                    </div>
                    <?php if($coupon['status']==WalletLoyalty::STATUS_ON):?>
                        <a ng-click="disableAction($event, <?php echo $coupon['id']; ?>)" class="form-button red"><?php echo Yii::t('spot', 'Cancel participation') ?></a>
                    <?php elseif ($coupon['status']==WalletLoyalty::STATUS_OFF
                        or $coupon['status']==WalletLoyalty::STATUS_ERROR): ?>
                        <a ng-click="checkLike(<?php echo $coupon['id']; ?>, $event)" class="form-button red"><?php echo Yii::t('spot', 'Participate') ?></a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
