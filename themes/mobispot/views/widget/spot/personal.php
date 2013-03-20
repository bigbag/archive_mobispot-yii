<?php if($spotContent):?>
<?php print_r($field);?>
<?php endif;?>


<div class="spot-content_row">
  <div class="spot-item">
    <textarea></textarea>
    <label class="text-center label-cover">
      <h4><?php echo Yii::t('spots', 'Drag your files here or begin to type info or links');?></h4>
      <span><?php echo Yii::t('spots', 'A maximum file size limit of 25mb for free accounts');?></span>
    </label>
  </div>
</div>
<div class="toggle-active">
  <a class="checkbox agree" href="javascript:;">
    <i></i><?php echo Yii::t('spots', 'Allow download spot as a card');?>
  </a>
</div>
<div class="toggle-active">
  <a class="checkbox agree" href="javascript:;">
    <i></i><?php echo Yii::t('spots', 'Make it private');?>
  </a>
</div>