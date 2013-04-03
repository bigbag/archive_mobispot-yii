<a class="settings-button spot-button right text-center" href="javascript:;"><?php echo Yii::t('spots', 'Settings');?></a>
<div class="spot-content slide-content">
<?php if(!empty($spotContent->content)):?>
<?php $content=$spotContent->content?>
<?php if(isset($content['data'])):?>
  <?php foreach ($content['data'] as $key=>$value):?>
  <div class="spot-item">
    <div class="item-area">
      <p class="item-area item-type__text"><?php echo CHtml::encode($value)?></p>
      <div class="spot-cover slow">
        <a class="button remove-spot round" ng-click="removeContent(spot, <?php echo $key;?>, $event)"></a>
        <a class="button edit-spot round" ng-click="editContent(spot, <?php echo $key;?>, $event)"></a>
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

<form ng-init="spot.discodes=<?php echo $spot->discodes_id?>">
<div class="spot-content_row">
  <div id="add-content" class="spot-item">
    <textarea ng-model="spot.content" ui-keypress="{enter: 'saveSpot(spot)'}"></textarea>
    <label class="text-center label-cover">
      <h4>Drag your files here or begin to type info or links</h4>
      <span>
        A maximum file size limit of 25mb for free accounts.<br />
        Use Ctrl+enter for a new paragraph.
      </span>
    </label>
  </div>
</div>
<div class="spot-content_row spot-options toggle-active">
  <?php $vcardActive=(isset($content) and isset($content['vcard']) and $content['vcard']==1)?'active':''?>
  <?php $privateActive=(isset($content) and isset($content['private']) and $content['private']==1)?'active':''?>

  <a class="checkbox vcard <?php echo $vcardActive;?>" href="javascript:;"  ng-click="getVcard(spot)">
    <i class="large"></i>
    <?php echo Yii::t('spots', 'Allow download spot as a card');?>
  </a>
  <a class="checkbox private <?php echo $privateActive;?>" href="javascript:;" ng-click="getPrivate(spot)">
    <i class="large"></i>
    <?php echo Yii::t('spots', 'Make it private');?>
  </a>
</div>
</form>
</div>