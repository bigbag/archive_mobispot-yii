<article>
    <div class="tabs-item">
        <div class="button-input">
            <input type="text" ng-model="actions.phrase" placeholder="<?php echo Yii::t('spot', 'Search for Coupons')?>">
            <a ng-click="filterCoupons(spot, actions)"><i class="icon">&#xe612;</i></a>
        </div>
        <div class="filter" ng-init="actions.phrase='';actions.page = 'all';">
            <a ng-class="{fl: actions.page == 'all'}" ng-click="actions.page = 'all'"><?php echo Yii::t('spot', 'All')?></a>
            <a ng-class="{fl: actions.page == 'new'}" ng-click="actions.page = 'new'"><?php echo Yii::t('spot', 'New')?></a>
            <a ng-class="{fl: actions.page == 'my'}" ng-click="actions.page = 'my'"><?php echo Yii::t('spot', 'Participating')?></a>
            <a ng-class="{fl: actions.page == 'used'}" ng-click="actions.page = 'used'"><?php echo Yii::t('spot', 'Used')?></a>
        </div>
    </div>
    <div id="coupons-list" class="tabs-item" ng-init="setLoyaltyTimer()">
        <?php /*foreach ($coupons as $coupon):?>
            <?php include(Yii::getPathOfAlias('webroot') . '/themes/mobispot/views/mobile/spot/coupon.php'); ?>
        <?php endforeach; */?>
    </div>
    <span ng-init="couponsScroll()"></span>
</article>
