            <div class="<?php echo ($coupon['part'])?'active ':''; ?>spot-item item-area type-coupon <?php echo $coupon['coupon_class']; ?>">
                <?php //<i class="coupon-indicator coupon-indicator__new">New</i> ?>
                <?php if($coupon['part']):?>
                    <sup><?php echo Yii::t('spot', 'Учавствую')?></sup>
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
                    <?php if($coupon['part']):?>
                        <a ng-click="disableAction($event, <?php echo $coupon['id']; ?>)" class="form-button red"><?php echo Yii::t('spot', 'Отключить') ?></a>
                    <?php else: ?>
                        <a ng-click="checkLike($event, <?php echo $coupon['id']; ?>)" class="form-button red"><?php echo Yii::t('spot', 'Учавствовать') ?></a>
                    <?php endif; ?>
                </div>
            </div>