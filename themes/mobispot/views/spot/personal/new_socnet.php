<?php $dataKey = $key; ?>
<?php if (isset($socContent) and !empty($socContent['block_type']) and !empty($socContent['soc_url'])): ?>
    <?php include(Yii::getPathOfAlias('webroot') . '/themes/mobispot/views/spot/personal/soc_block/'
        .$socContent['block_type']
        .'.php');
    ?>
<?php elseif(isset($socContent) and !empty($socContent['soc_url'])):?>
        <?php include(Yii::getPathOfAlias('webroot') . '/themes/mobispot/views/mobile/widget/spot/soc_content.php'); ?>
<?php else:?>
<?php $socInf = new SocInfo;?>
<div id="block-<?php echo $key;?>" class="spot-item" ng-init="loadSocContent(<?php echo $key;?>)">
    <div class="item-area type-itembox">
        <div class="item-head">
            <a href="<?php echo CHtml::encode(CHtml::encode($content)) ?>"
                class="type-link">
                <img class="soc-icon"
                    src="/themes/mobispot/socialmediaicons/<?php echo $socInf->getSmallIcon(CHtml::encode($content));?>" height="36">
                <span class="link">
                    <?php echo CHtml::encode(CHtml::encode($content)) ?>
                </span>
            </a>
        </div>
        <div class="type-mess item-body">
            <div id="post-box-<?php echo $key;?>"
                class="post-box"
            >
            </div>
        </div>
        <div class="item-control">
            <span class="move move-top"></span>
                <div class="spot-activity">
                    <a class="button round"
                        ng-click="unBindSocial(spot, <?php echo $key; ?>, $event)">
                        &#xe003;
                    </a>
                    <a class="button round"
                        ng-click="removeContent(spot, <?php echo $key; ?>, $event)">
                        &#xe00b;
                    </a>
                </div>
            <span class="move move-bottom"></span>
        </div>
    </div>
</div>
<?php endif; ?>
