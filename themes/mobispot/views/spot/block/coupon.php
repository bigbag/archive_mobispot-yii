            <div class="<?php echo ($coupon['part'])?'active ':''; ?>spot-item item-area type-coupon <?php echo $coupon['coupon_class']; ?>">
                <?php //<i class="coupon-indicator coupon-indicator__new">New</i> ?>
                <div class="s-content">
                    <img src="/uploads/action/<?php echo $coupon['img']; ?>">
                </div>
                <div class="coupon-terms">
                    <h3><?php echo $coupon['name']?> 
                    <?php if($coupon['part']):?>
                        <sup><?php echo Yii::t('spot', 'Учавствую')?></sup>
                    <?php endif; ?>
                    </h3>
                    <?php echo $coupon['desc']; ?>
                    <div class="soc-block">
                        <?php if (!empty($coupon['soc_block'])) echo $coupon['soc_block']; ?>
                    </div>
                    <?php if($coupon['part']):?>
                        <a ng-click="disableAction($event, <?php echo $coupon['id']; ?>)" class="spot-button spot-button-red">Отключить</a>
                    <?php else: ?>
                        <a ng-click="checkLike($event, <?php echo $coupon['id']; ?>)" class="spot-button spot-button-blue"><?php echo Yii::t('spot', 'Подключить') ?></a>
                    <?php endif; ?>
                </div>
            </div>    