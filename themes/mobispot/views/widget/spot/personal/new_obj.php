<div class="spot-item spot-block">
  <div class="item-area text-center">
    <div class="file-block">
      <a href="<?php echo CHtml::encode($content)?>">
        <img src="/themes/mobispot/images/icons/i-files.2x.png" width="80">
          <span><?php echo CHtml::encode(substr(strchr($content, '_'), 1))?></span>
      </a>
    </div>
    <div class="spot-cover slow">
      <div class="spot-activity">
        <a class="button remove-spot round" ng-click="removeContent(spot, <?php echo $key;?>, $event)">&#xe00b</a>
      </div>
      <div class="move-spot"><i></i><span><?php echo Yii::t('spots', 'Move your file');?></span></div>
    </div>
  </div>
</div>