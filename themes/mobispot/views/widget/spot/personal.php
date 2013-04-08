<a class="settings-button spot-button right text-center" href="javascript:;"><?php echo Yii::t('spots', 'Settings');?></a>
<div class="spot-content slide-content">
  <div ui-sortable>
<?php if(!empty($spotContent->content)):?>
<?php $content=$spotContent->content?>
<?php if(isset($content['data'])):?>
  <?php foreach ($content['data'] as $key=>$value):?>
  <div class="spot-item">
    <div class="item-area <?php echo ($content['keys'][$key]!='text')?'text-center':''?>">
      <?php if ($content['keys'][$key]=='text'):?>
      <p class="item-area item-type__text"><?php echo CHtml::encode($value)?></p>
      <?php elseif ($content['keys'][$key]=='image'):?>
      <img src="/uploads/spot/tmb_<?php echo $value?>">
      <?php else:?>
      <a href="<?php echo CHtml::encode($value)?>">
        <img src="/themes/mobispot/images/icons/i-files.2x.png" width="80">
        <span><?php echo CHtml::encode(substr(strchr($value, '_'), 1))?></span>
      </a>
      <?php endif;?>
      <div class="spot-cover slow">
        <a class="button remove-spot round" ng-click="removeContent(spot, <?php echo $key;?>, $event)"></a>
        <?php if ($content['keys'][$key]=='text'):?>
        <a class="button edit-spot round" ng-click="editContent(spot, <?php echo $key;?>, $event)"></a>
        <?php endif;?>
        <div class="move-spot"><i></i><span><?php echo Yii::t('spots', 'Move your text');?></span></div>
      </div>
    </div>
  </div>
  <?php endforeach;?>
  <?php endif;?>
  <span ng-init="spot.vcard=<?php echo $content['vcard'];?>; spot.private=<?php echo $content['private'];?>;"></span>
<?php else:?>
  <span ng-init="spot.vcard=0; spot.private=0;"></span>
<?php endif;?>
  <div id="add-content" class="spot-item">
    <div class="item-area type-progress">
      <div class="progress-bar">
        <div class="meter" ng-style="{'width': progress+'%'}">{{progress}}%</div>
      </div>
    </div>
  </div>
</div>

<div class="spot-content_row">

  <div id="error-upload" class="spot-item">
    <div class="item-area text-center type-error">
      <h1><?php echo Yii::t('spot', 'Error')?></h1>
      <h4><?php echo Yii::t('spot', 'There was an error when attempting to upload this file')?></h4>
      <h4><?php echo Yii::t('spot', 'Please try again')?></a></h4>
    </div>
  </div>
  <div id="dropbox" class="spot-item" ng-init="spot.discodes=<?php echo $spot->discodes_id?>">
    <textarea ng-model="spot.content" ui-keypress="{enter: 'saveSpot(spot)'}"></textarea>
    <label class="text-center label-cover">
      <h4><?php echo Yii::t('spot', 'Drag your files here or begin to type info or links')?></h4>
      <span>
        <?php echo Yii::t('spot', 'You can store up to 25 MB inside one spot')?>
        <br />
        <?php echo Yii::t('spot', 'Use Ctrl+enter for a new paragraph')?>
      </span>
    </label>
  </div>
</div>
<div class="spot-content_row spot-options toggle-active">
  <?php $vcardActive=(isset($content) and isset($content['vcard']) and $content['vcard']==1)?'active':''?>
  <?php $privateActive=(isset($content) and isset($content['private']) and $content['private']==1)?'active':''?>

  <a class="checkbox vcard <?php echo $vcardActive;?>" href="javascript:;"  ng-click="getVcard(spot)">
    <i class="large"></i>
    <?php echo Yii::t('spots', 'Allow to download as a V-card');?>
  </a>
  <a class="checkbox private <?php echo $privateActive;?>" href="javascript:;" ng-click="getPrivate(spot)">
    <i class="large"></i>
    <?php echo Yii::t('spots', 'Make it private');?>
  </a>
</div>
</div>