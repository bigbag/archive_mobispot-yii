<div id="block-<?php echo $key;?>" class="spot-item spot-block">
    <div class="item-area item-type__text">
        <p><?php echo CHtml::encode($content)?></p>
        <div class="spot-cover slow" ui-event="{dblclick : 'editContent(spot, <?php echo $key; ?>, $event)'}">
            <div class="spot-activity">
                <?php if (SocInfo::isSocLink(CHtml::encode($content))): ?>
                    <a class="button bind-spot round" ng-click="bindSocial(spot, <?php echo $key; ?>, $event)">&#xe005;</a>
                <?php endif; ?>
                <a class="button edit-spot round" ng-click="editContent(spot, <?php echo $key; ?>, $event)">&#xe009;</a>
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