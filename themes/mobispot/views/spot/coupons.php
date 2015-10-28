<div class="spot-content discounts" ng-init="spot.status=<?php echo $spot->status; ?>">
    <section class="spot-wrapper active">
        <div class="spot-hat">
            <?php include('block/menu.php'); ?>
        </div>
        <div class="tabs-block">
        <p><?php echo Yii::t('spot', 'Connect social network profiles with your account to get the discounts'); ?></p>
            <?php include('block/linking_socnet.php'); ?>
            <div class="filter">
                <input class="search" type="text" ng-init="actions.phrase='';actions.page = 'all';" ng-model="actions.phrase" placeholder="<?php echo Yii::t('spot', 'Search for Coupons')?>" ng-keypress="($event.keyCode == 13)?filterCoupons(spot, actions):''" >
                <i class="icon" ng-click="filterCoupons(spot, actions)">&#xe612;</i>
                <a class="spot-button" ng-class="{active: actions.page == 'all'}" ng-click="actions.page = 'all'"><?php echo Yii::t('spot', 'All'); ?></a>
                <a class="spot-button" ng-class="{active: actions.page == 'new'}" ng-click="actions.page = 'new'"><?php echo Yii::t('spot', 'New'); ?></a>
                <a class="spot-button" ng-class="{active: actions.page == 'my'}" ng-click="actions.page = 'my'"><?php echo Yii::t('spot', 'Participating'); ?></a>
                <a class="spot-button" ng-class="{active: actions.page == 'used'}" ng-click="actions.page = 'used'"><?php echo Yii::t('spot', 'Used'); ?></a>
            </div>
            <section id="coupons-list" class="coupon-block spot-content_row spot-coupon tabs-item" ng-init="setLoyaltyTimer()">
            </section>
        </div>
    </section>
</div>
