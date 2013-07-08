<div class="spot-item spot-block">
    <div class="item-area">
        <p class="item-area item-type__text"><img src="/themes/mobile/images/icons/<?php $socInf = new SocInfo;
echo $socInf->getSmallIcon(CHtml::encode($content));
?>" height="14" width="14" style="display: inline-block;">	 <?php echo CHtml::encode(CHtml::encode($content)) ?></p>
        <div class="spot-cover slow" ui-event="{dblclick : 'editContent(spot, <?php echo $key; ?>, $event)'}">
            <div class="spot-activity">
                <a class="button unbind-spot round" ng-click="unBindSocial(spot, <?php echo $key; ?>, $event)">&#xe003;</a>
                <a class="button remove-spot round" ng-click="removeContent(spot, <?php echo $key; ?>, $event)">&#xe00b;</a>
            </div>
        </div>
    </div>
</div>