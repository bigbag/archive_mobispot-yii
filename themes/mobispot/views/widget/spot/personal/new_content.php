<?php $dataKey = $key; ?>
<?php $socContent = $content; ?>
<?php $socContent['dinamyc'] = true; ?>
<div id="block-<?php echo $key;?>" class="spot-item spot-block">
    <div class="item-area type-soc">
        <div class="item-area-hat">
        <?php if(isset($content['binded_link'])): ?>
        <?php $socInf = new SocInfo;?>
            <img width="36" src="/themes/mobispot/images/icons/social/<?php echo $socInf->getSmallIcon(CHtml::encode($content['binded_link']));?>" class="spot-soc-icon" width="36">
            <h5><?php echo CHtml::encode(CHtml::encode($content['binded_link'])) ?></h5>
        <?php endif;?>
        </div>
        
        <div id="post-box-<?php echo $key;?>" class="post-box">
            <?php include(Yii::getPathOfAlias('webroot') . '/themes/mobispot/views/mobile/widget/spot/soc_content.php'); ?>
        </div>
        
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