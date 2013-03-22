<li id="<?php echo $data->discodes_id;?>" class="spot-content_li bg-gray">
  <div class="spot-hat">
    <h3 ng-click="accordion($event, spot.token)"><?php echo $data->name?></h3>
    <a class="settings-button spot-button right text-center" href="javascript:;"><?php echo Yii::t('spots', 'Settings');?></a>
  </div>
  <div class="spot-content slide-content">
  </div>
</li>