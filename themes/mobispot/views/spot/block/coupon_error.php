<div class="spot-item item-area type-coupon type-coupon__50 error-coupon">
    <div class="cover-coupon">
        <h3><?php echo Yii::t('spot', 'Для подключения акции не были выполнены следующие условия:')?></h3>
        <a href="javascript:;" ng-click="reloadCoupon(<?php echo $id_loyalty ?>, $event)" class="close-info icon">&#xe00b;</a>
        <ul>
            <li>
                <?php echo $condition; ?>
            </li>
        </ul>
    </div>
</div>
