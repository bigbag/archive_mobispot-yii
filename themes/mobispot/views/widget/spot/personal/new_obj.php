<div class="spot-item spot-block">
    <div class="item-area item-area type-file">
        <div class="file-block">
            <a href="<?php echo CHtml::encode($content) ?>">
                <span class="icon">&#xe00e;</span>
                <span><b><?php echo CHtml::encode(substr(strchr($content, '_'), 1)) ?></b></span>
            </a>
        </div>
        <div class="spot-cover slow">
            <div class="spot-activity">
                <a class="button remove-spot round" ng-click="removeContent(spot, <?php echo $key; ?>, $event)">&#xe00b;</a>
            </div>
            <div class="move-spot"><i></i><span><?php echo Yii::t('spots', 'Move your file'); ?></span></div>
        </div>
    </div>
</div>
