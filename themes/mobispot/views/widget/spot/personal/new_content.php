<div class="spot-item spot-block">
    <div class="item-area  type-link">
        <?php if(isset($content['binded_link'])): ?>
        <?php $socInf = new SocInfo;?>
        <a href="<?php echo CHtml::encode(CHtml::encode($content['binded_link'])); ?>">
            <img src="/themes/mobispot/images/icons/social/<?php echo $socInf->getSmallIcon(CHtml::encode($content['binded_link']));?>"
            height="32"
            width="32"
            style="display: inline-block;">
            <?php echo CHtml::encode(CHtml::encode($content['binded_link'])) ?>
        </a>
        <?php endif;?>
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