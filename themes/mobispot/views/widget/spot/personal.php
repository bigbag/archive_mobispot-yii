<?php if($spotContent):?>
<?php print_r($field);?>

<?php else:?>
<span ng-init="spot.vcard=0; spot.private=0;"></span>
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
<div class="spot-content_row spot-options toggle-active">
  <a class="checkbox" href="javascript:;"  ng-click="getVcard(spot)">
    <i class="large"></i>
    <?php echo Yii::t('spots', 'Allow download spot as a card');?>
  </a>
  <a class="checkbox" href="javascript:;" ng-click="getPrivate(spot)">
    <i class="large"></i>
    <?php echo Yii::t('spots', 'Make it private');?>
  </a>
</div>
</form>