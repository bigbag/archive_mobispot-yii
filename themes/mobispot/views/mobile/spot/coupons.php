<article>
    <div class="tabs-item">
        <div class="button-input">
        <!--
            <input type="text" placeholder="Search For Coupons"> 
            <a href="#"><i class="icon">&#xe612;</i></a>
        -->
        </div>
        <div class="filter">
        <!--
            <a class="fl" href="#">Все</a>
            <a href="#">Новые</a>
            <a href="#">Учавствую</a>
        -->
        </div>
    </div>
    <div class="tabs-item">
        <?php foreach ($coupons as $coupon):?>
            <?php include(Yii::getPathOfAlias('webroot') . '/themes/mobispot/views/mobile/spot/coupon.php'); ?>
        <?php endforeach; ?>
    </div>
</article>