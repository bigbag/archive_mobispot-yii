<?php $urlVal = new CUrlValidator; ?>
<?php $socInfo = new SocInfo; ?>
<?php if ($urlVal->validateValue( CHtml::encode($content))): ?>
<div id="block-<?php echo $key;?>" class="spot-item">
    <div class="item-area type-itembox">
        <div class="item-head">
            <a href="<?php echo CHtml::encode($content); ?>" class="type-link">
                <span class="link"><?php echo CHtml::encode($content); ?></span>
            </a>
        </div>
        <div class="spot-cover slow" ui-event="{dblclick : 'editContent(spot, <?php echo $key; ?>, $event)'}">
            <div class="spot-activity">
                <?php $net = $socInfo->getNetByLink(CHtml::encode($content)); ?>
                <?php if (!empty($net['name'])): ?>
                    <a class="button bind-spot round" ng-click="bindSocial(spot, <?php echo $key; ?>, $event)">&#xe005;</a>
                <?php endif; ?>
                <a class="button edit-spot round" ng-click="editContent(spot, <?php echo $key; ?>, $event)">&#xe009;</a>
                <a class="button remove-spot round" ng-click="removeContent(spot, <?php echo $key; ?>, $event)">&#xe00b;</a>
            </div>
            <div class="move-spot"><i></i>
                <span>
                    <?php echo Yii::t('spots', 'Move your link'); ?>
                </span>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
<div id="block-<?php echo $key;?>" class="spot-item item-area">
    <p class="item-type__text"><?php echo CHtml::encode($content)?></p>
    <div class="spot-cover slow" ui-event="{dblclick : 'editContent(spot, <?php echo $key; ?>, $event)'}">
        <div class="spot-activity">
            <?php $net = $socInfo->getNetByLink(CHtml::encode($content)); ?>
            <?php if (!empty($net['name'])): ?>
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
<?php endif; ?>
