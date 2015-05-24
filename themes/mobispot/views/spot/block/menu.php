<div class="spot-tabs">
    <?php if (SpotTroika::isBlockedCard($spot->discodes_id)):?>
    <?php //Заблокированная тройка ?>
        <a ng-click="general.views='transport'"
            ng-class="{active: general.views=='transport'}">
            <i class="icon">&#xe616;</i>
            <?php echo Yii::t('spot', 'Public transport')?>
        </a>
        <a  title="settings"
            ng-click="general.views='settings'"
            ng-class="{active: general.views=='settings'}"
            class="icon-spot-button right icon settings">&#xe00f;
        </a>
    <?php elseif (!SpotTroika::hasTroika($spot->discodes_id)): ?>
    <?php //Обычный спот ?>
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
            <a ng-click="general.views='coupon'"
                ng-class="{active: general.views=='coupon'}">
                <i class="icon">&#xe601;</i>
                <?php echo Yii::t('spot', 'Coupon')?>
            </a>
        <?php endif;?>
        <a  title="settings"
            ng-click="general.views='settings'"
            ng-class="{active: general.views=='settings'}"
            class="icon-spot-button right icon settings">&#xe00f;
        </a>
    <?php else: ?>
    <?php //Активная тройка ?>
        <?php if ($wallet and $spot->type == Spot::TYPE_FULL):?>
            <a ng-click="general.views='wallet'"
                ng-class="{active: general.views=='wallet'}">
                <i class="icon">&#xe006;</i>
                <?php echo Yii::t('spot', 'Wallet')?>
            </a>
            <a ng-click="general.views='coupon'"
                ng-class="{active: general.views=='coupon'}">
                <i class="icon">&#xe601;</i>
                <?php echo Yii::t('spot', 'Coupon')?>
            </a>
            <a ng-click="general.views='transport'"
                ng-class="{active: general.views=='transport'}">
                <i class="icon">&#xe616;</i>
                <?php echo Yii::t('spot', 'Public transport')?>
            </a>
        <?php endif;?>
        <a ng-click="general.views='spot'"
            ng-class="{active: general.views=='spot'}">
            <i class="icon">&#xe60f;</i>
            <?php echo Yii::t('spot', 'Social links')?>
        </a>

        <a  title="settings"
            ng-click="general.views='settings'"
            ng-class="{active: general.views=='settings'}"
            class="icon-spot-button right icon settings">&#xe00f;
        </a>
    <?php endif; ?>
</div>
