<div class="spot-item">
  <div class="item-area text-center">
    <img src="<?php echo $content?>">
    <div class="spot-cover slow">
      <a class="button remove-spot round" ng-click="removeContent(spot, <?php echo 1;?>, $event)">></a>
      <div class="move-spot"><i></i><span><?php echo Yii::t('spots', 'Move your text');?></span></div>
    </div>
  </div>
</div>