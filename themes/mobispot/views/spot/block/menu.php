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
    <?php endif;?>
    <a  title="settings"
        ng-click="general.views='settings'"
        ng-class="{active: general.views=='settings'}"
        class="icon-spot-button right icon settings">&#xe00f;
    </a>
</div>
