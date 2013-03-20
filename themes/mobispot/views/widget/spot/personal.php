<?php if($spotContent):?>
<?php print_r($field);?>

<?php else:?>
<span ng-init="spot.vcard=1; spot.private=1;"></span>
<?php endif;?>

<form ng-submit="doSomething(spot)">
<div class="spot-content_row">
  <div class="spot-item">
    <textarea ng-model="spot.content" ></textarea>
    <label class="text-center label-cover">
      <h4>Drag your files here or begin to type info or links</h4>
      <span>A maximum file size limit of 25mb for free accounts</span>
    </label>
  </div>
</div>
<div class="toggle-active">
  <a class="checkbox agree" href="javascript:;" ng-click="getVcard(spot)">
    <i></i><?php echo Yii::t('spots', 'Allow download spot as a card');?>
  </a>
</div>
<div class="toggle-active">
  <a class="checkbox agree" href="javascript:;" ng-click="getPrivate(spot)">
    <i></i><?php echo Yii::t('spots', 'Make it private');?>
  </a>
</div>
</form>