<div class="spot-item spot-block">
  <div class="item-area text-center">
    <img src="/uploads/spot/tmb_<?php echo $content?>">
    <div class="spot-cover slow">
      <div class="spot-activity">
        <a class="button remove-spot round" ng-click="removeContent(spot, <?php echo $key;?>, $event)">&#xe00b</a>
      </div>
      <div class="move-spot"><i></i><span><?php echo Yii::t('spots', 'Move your image');?></span></div>
    </div>
  </div>
</div>