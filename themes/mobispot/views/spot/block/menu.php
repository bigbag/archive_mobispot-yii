<div class="spot-tabs">
    <a ng-click="general.views='spot'"
        ng-class="{active: general.views=='spot'}">
        <i class="icon">&#xe60f;</i>
        <?php echo Yii::t('spot', 'Social links')?>
    </a>
    <?php if ($wallet and $spot->type == Spot::TYPE_FULL):?>
        <a ng-click="general.views='wallet'"
            ng-class="{active: general.views=='wallet'}">
            <i class="icon">&#xe006;</i>
            <?php echo Yii::t('spot', 'Wallet')?>
        </a>
        <?php //if (CouponAccess::access($wallet->discodes_id)):?>
        <a ng-click="general.views='coupon'"
            ng-class="{active: general.views=='coupon'}">
            <i class="icon">&#xe601;</i>
            <?php echo Yii::t('spot', 'Coupon')?>
        </a>
        <?php //endif;?>
        <?php if (CouponAccess::access($wallet->discodes_id)):?>
        <a ng-click="general.views='transport'"
            ng-class="{active: general.views=='transport'}">
            <i class="icon">&#xe616;</i>
            <?php echo Yii::t('spot', 'Public transport')?>
        </a>
        <?php endif;?>
    <?php endif;?>
    <a  title="settings"
        ng-click="general.views='settings'"
        ng-class="{active: general.views=='settings'}"
        class="icon-spot-button right icon settings">&#xe00f;
    </a>
</div>
