<?php $urlVal = new CUrlValidator; ?>
<?php $socInfo = new SocInfo; ?>
<?php if ($urlVal->validateValue(CHtml::encode($content)) or $urlVal->validateValue('http://'.CHtml::encode($content))): ?>
<div id="block-<?php echo $key;?>" class="spot-item item-area">
    <div class="item-head"
        ng-dblclick="editContent(spot, <?php echo $key; ?>, $event)">
        <a href="<?php echo CHtml::encode($content); ?>" class="type-link">
            <span class="link"><?php echo CHtml::encode($content); ?></span>
        </a>
    </div>
    <div class="item-control">
        <span class="move move-top"></span>
            <div class="spot-activity">
                <?php $net = $socInfo->getNetByLink(CHtml::encode($content)); ?>
                <?php if (!empty($net['name'])): ?>
                <a class="button round"
                    ng-click="bindSocial(spot, <?php echo $key; ?>, $event)">
                    &#xe005;
                </a>
                <?php endif; ?>
                <a class="button round"
                    ng-click="editContent(spot, <?php echo $key; ?>, $event)">
                    &#xe009;
                </a>
                <a class="button round"
                    ng-click="removeContent(spot, <?php echo $key; ?>, $event)">
                    &#xe00b;
                </a>
            </div>
        <span class="move move-bottom"></span>
    </div>
</div>
<?php else: ?>
<div id="block-<?php echo $key;?>" class="spot-item item-area">
    <p class="item-type__text"
        ng-dblclick="editContent(spot, <?php echo $key; ?>, $event)"><?php echo CHtml::encode($content)?></p>
    <div class="item-control">
        <span class="move move-top"></span>
            <div class="spot-activity">
                <?php $net = $socInfo->getNetByLink(CHtml::encode($content)); ?>
                <?php if (!empty($net['name'])): ?>
                <a class="button round"
                ng-click="bindSocial(spot, <?php echo $key; ?>, $event)">
                    &#xe005;
                </a>
                <?php endif; ?>
                <a class="button round"
                    ng-click="editContent(spot, <?php echo $key; ?>, $event)">
                    &#xe009;
                </a>
                <a class="button round"
                    ng-click="removeContent(spot, <?php echo $key; ?>, $event)">
                    &#xe00b;
                </a>
            </div>
        <span class="move move-bottom"></span>
    </div>
</div>
<?php endif; ?>
