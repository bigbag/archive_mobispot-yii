<div class="spot-tabs">
    <a ng-click="general.views='spot'"
        ng-class="{active: general.views=='spot'}">
        <i class="icon">&#xe600;</i>
        <?php echo Yii::t('spot', 'Social links')?>
    </a>
    <?php if ($wallet and $spot->type == Spot::TYPE_FULL):?>
    <a ng-click="general.views='wallet'"
        ng-class="{active: general.views=='wallet'}">
        <i class="icon">&#xe006;</i>
        <?php echo Yii::t('spot', 'Wallet')?>
    </a>
   <!--  <a ng-click="general.views='coupon'"
        ng-class="{active: general.views=='coupon'}">
        <i class="icon">&#xe601;</i>
        <?php echo Yii::t('spot', 'Coupon')?>
    </a> -->
    <?php endif;?>
    <a href="javascript:;"
        title="settings"
        ng-click="spotBlock($event,'settings-block')"
        class="icon-spot-button right icon settings">&#xe00f;
    </a>
</div>