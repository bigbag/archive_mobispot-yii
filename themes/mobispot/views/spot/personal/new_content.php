<?php $dataKey = $key; ?>
<?php $socContent = (array) $content; ?>
<?php $socContent['dinamyc'] = true; ?>
<?php if(!empty($content['binded_link'])):?>
    <?php $socContent['soc_url'] = $content['binded_link']; ?>
<?php endif?>
<?php include(Yii::getPathOfAlias('webroot') . '/themes/mobispot/views/mobile/widget/spot/soc_content.php'); ?>
 