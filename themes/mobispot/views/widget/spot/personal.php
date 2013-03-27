<?php if($spotContent):?>
<?php $content=$spotContent->content?>

  <?php foreach ($content['data'] as $row):?>
  <div class="spot-item">
    <div class="item-area">
      <p class="item-area item-type__text"><?php echo CHtml::encode($row)?></p>
      <div class="spot-cover slow">
        <a class="button remove-spot round" href="javascripts:;"></a>
        <a class="button edit-spot round" href="javascripts:;"></a>
        <div class="move-spot"><i></i><span><?php echo Yii::t('spots', 'Move your text');?></span></div>
      </div>
    </div>
  </div>
  <?php endforeach;?>
  <span ng-init="spot.vcard=<?php echo $content['vcard'];?>; spot.private=<?php echo $content['private'];?>;"></span>
<?php else:?>
  <span ng-init="spot.vcard=0; spot.private=0;"></span>
<?php endif;?>


<form ng-init="spot.discodes=<?php echo $spot->discodes_id?>">
<div class="spot-content_row">
  <div id="add-content" class="spot-item">
    <textarea  id="filedrag" ng-model="spot.content" ui-keypress="{enter: 'saveSpot(spot)'}"></textarea>
    <!-- <label class="text-center label-cover">
      <h4>Drag your files here or begin to type info or links</h4>
      <span>A maximum file size limit of 25mb for free accounts</span>
    </label> -->
  </div>
</div>
<div class="spot-content_row spot-options toggle-active">
  <a class="checkbox <?php echo ($content['vcard']==1)?'active':null;?>" href="javascript:;"  ng-click="getVcard(spot)">
    <i class="large"></i>
    <?php echo Yii::t('spots', 'Allow download spot as a card');?>
  </a>
  <a class="checkbox <?php echo ($content['private']==1)?'active':null;?>" href="javascript:;" ng-click="getPrivate(spot)">
    <i class="large"></i>
    <?php echo Yii::t('spots', 'Make it private');?>
  </a>
</div>
</form>