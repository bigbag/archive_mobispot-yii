<div class="spot-item spot-block">
    <div class="item-area  type-link">
        <?php $socInf = new SocInfo;?>
        <a href="<?php echo CHtml::encode(CHtml::encode($content)) ?>">
            <img src="/themes/mobispot/images/icons/social/<?php echo $socInf->getSmallIcon(CHtml::encode($content));?>" class="spot-soc-icon" width="36">
            <?php echo CHtml::encode(CHtml::encode($content)) ?>
        </a>

        <div class="spot-cover slow">
            <div class="spot-activity">
                <a class="button unbind-spot round" ng-click="unBindSocial(spot, <?php echo $key; ?>, $event)">&#xe003;</a>
                <a class="button remove-spot round" ng-click="removeContent(spot, <?php echo $key; ?>, $event)">&#xe00b;</a>
            </div>
            <div class="move-spot"><i></i>
                <span>
                    <?php echo Yii::t('spots', 'Move your text'); ?>
                </span>
            </div>
        </div>
    </div>
</div>