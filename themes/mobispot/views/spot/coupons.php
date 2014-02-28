    <div id="coupons-block" class="spot-content_row spot-coupon tabs-item" style="display:none">
        <?php foreach ($coupons as $coupon):?>
            <?php include(Yii::getPathOfAlias('webroot') . '/themes/mobispot/views/spot/coupon.php'); ?>
        <?php endforeach; ?>
    </div>