<ul class="spot-hat-button">
<!--   <li>
    <a id="j-wallet" class="b-account settings-button wallet-button spot-button b-negative b-positive right tex5t-center" href="javascript:;">134$</a>
  </li> -->
  <li>
    <a id="j-settings" class="spot-button right text-center settings-button" href="javascript:;"ng-click="showSettings()">
      <?php echo Yii::t('spots', 'Settings');?>
    </a>
  </li>
</ul>
<div class="spot-content slide-content" ng-init="spot.status='<?php echo $spot->status;?>'">
<div  ng-models="keys" ui-sortable="sortableOptions" >
<?php if(!empty($spotContent->content)):?>
<?php $content=$spotContent->content?>

<?php if(isset($content['data']) and isset($content['keys'])):?>
  <?php $keys=(isset($content['keys'])?array_keys($content['keys']):array())?>
  <?php $keys='['.implode(',', $keys).']';?>
  <span ng-init="spot.vcard=<?php echo $content['vcard'];?>; spot.private=<?php echo $content['private'];?>; keys=<?php echo $keys;?>;"></span>

  <?php foreach ($content['data'] as $key=>$value):?>

  <div class="spot-item spot-block">
    <div class="item-area <?php echo (($content['keys'][$key]!='text') && ($content['keys'][$key]!='socnet'))?'text-center':''?>">
      <?php if ($content['keys'][$key]=='text'):?>
      <p class="item-area item-type__text" ng-init="spot.val.<?php echo $key; ?>='<?php echo CHtml::encode($value); ?>'">{{spot.val.<?php echo $key; ?>}}</p>
      <?php elseif ($content['keys'][$key]=='image'):?>
      <img src="/uploads/spot/tmb_<?php echo $value?>">
	  <?php elseif ($content['keys'][$key]=='socnet'):?>
      <p class="item-area item-type__text"><img src="/themes/mobile/images/icons/<?php $socInf = new SocInfo; echo $socInf->getSmallIcon($value); ?>" height="14" width="14" style="display: inline-block;">	 <?php echo CHtml::encode($value)?></p>
      <?php else:?>
      <a href="<?php echo CHtml::encode($value)?>">
        <img src="/themes/mobispot/images/icons/i-files.2x.png" width="80">
        <span><?php echo CHtml::encode(substr(strchr($value, '_'), 1))?></span>
      </a>
      <?php endif;?>
      <?php if ($content['keys'][$key]=='text'):?>
        <div class="spot-cover slow"  ui-event="{dblclick : 'editContent(spot, <?php echo $key;?>, $event)'}">
      <?php else:?>
        <div class="spot-cover slow">
      <?php endif;?>
        <div class="spot-activity">
          <?php if ($content['keys'][$key]=='text'):?>
            <a class="button bind-spot round" ng-click="bindSocial(spot, <?php echo $key;?>, $event)" ng-init="bindVisibility.<?php echo $key; ?>=<?php echo (SocInfo::isSocLink($value))?'true':'false'; ?>" ng-show="bindVisibility.<?php echo $key; ?>">&#xe005;</a>
            <a class="button edit-spot round" ng-click="editContent(spot, <?php echo $key;?>, $event)">&#xe009;</a>
          <?php endif;?>
          <?php if ($content['keys'][$key]=='socnet'):?>
            <a class="button unbind-spot round" ng-click="unBindSocial(spot, <?php echo $key;?>, $event)">&#xe003;</a>
          <?php endif;?>
          <a class="button remove-spot round" ng-click="removeContent(spot, <?php echo $key;?>, $event)">&#xe00b;</a>
        </div>

        <div class="move-spot"><i></i><span>
          <?php if ($content['keys'][$key]=='text'):?>
            <?php echo Yii::t('spots', 'Move your text');?>
          <?php elseif ($content['keys'][$key]=='image'):?>
            <?php echo Yii::t('spots', 'Move your image');?>
          <?php else:?>
            <?php echo Yii::t('spots', 'Move your file');?>
          <?php endif;?>
        </span></div>
      </div>
    </div>
  </div>
  <?php endforeach;?>

  <?php endif;?>
<?php else:?>
  <span ng-init="spot.vcard=0; spot.private=0"></span>
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
    <textarea ng-model="spot.content" ui-keypress="{enter: 'addContent(spot)'}">

    </textarea>
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
<!--
  <a class="checkbox vcard <?php echo $vcardActive;?>" href="javascript:;"  ng-click="getVcard(spot)">
    <i class="large"></i>
    <?php echo Yii::t('spots', 'Allow to download as a V-card');?>
  </a>
  <a class="checkbox private <?php echo $privateActive;?>" href="javascript:;" ng-click="getPrivate(spot)">
    <i class="large"></i>
    <?php echo Yii::t('spots', 'Make it private');?>
  </a> -->
</div>
</div>
