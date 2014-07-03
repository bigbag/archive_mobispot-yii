<?php $urlVal = new CUrlValidator; ?>
<?php if ($urlVal->validateValue(CHtml::encode($content)) or $urlVal->validateValue('http://'.CHtml::encode($content))): ?>
<article id="block-<?php echo $key;?>" class="spot-item">
    <div class="item-area type-itembox">
        <div class="item-head">
            <a href="<?php echo CHtml::encode($content); ?>" class="type-link type-link_simple">
                <span class="link"><?php echo CHtml::encode($content); ?></span>
            </a>
        </div>
            <div class="item-control">
                <div class="spot-activity">
                        <a
                            class="button round"
                            href=""

                            ng-click="editContent(spot, <?php echo $key; ?>, $event)"
                        >&#xe009;</a>
                        <a
                            class="button round"
                            href=""
                            ng-click="removeContent(spot, <?php echo $key; ?>, $event)"
                        >&#xe00b;</a>
                </div>
    </div>
    </div>
</article>
<?php else: ?>
<article id="block-<?php echo $key;?>" class="spot-item item-area">
    <p class=" item-type__text"><?php echo CHtml::encode($content); ?></p>
    <div class="item-control">
                    <div class="spot-activity">
                        <a
                            class="button round"
                            href=""
                            ng-click="editContent(spot, <?php echo $key; ?>, $event)"
                        >&#xe009;</a>
                        <a
                            class="button round"
                            ng-click="removeContent(spot, <?php echo $key; ?>, $event)"
                            href=""
                        >&#xe00b;</a>
                    </div>
        </div>
</article>
<?php endif; ?>
