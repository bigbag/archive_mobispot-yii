<article class="coupon">
    <div class="cover-coupon">
        <h3><?php echo Yii::t('spot', 'Для подключения акции не были выполнены следующие условия:')?></h3>
        <ul>
            <li>
                <?php echo $condition; ?>
            </li>
        </ul>
        <footer>
        <a class="accept" ng-click="reloadCoupon(<?php echo $id_loyalty ?>, $event)"><?php echo Yii::t('spot', 'Back') ?>
        </footer>
    </div>
</article>
