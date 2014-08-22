<div class="spot-content" ng-init="spot.status=<?php echo $spot->status; ?>">
    <section class="spot-wrapper active">
        <div class="spot-hat">
            <?php include('block/menu.php'); ?>
        </div>
        <div class="tabs-block">
            <section class="coupon-block spot-content_row spot-coupon tabs-item">
                <?php foreach ($coupons as $coupon):?>
                    <?php include(Yii::getPathOfAlias('webroot') . '/themes/mobispot/views/spot/block/coupon.php'); ?>
                <?php endforeach; ?>
            </section>
        </div>
    </section>
</div>
