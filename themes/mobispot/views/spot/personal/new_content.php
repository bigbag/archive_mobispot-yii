<?php $dataKey = $key; ?>
<?php $socContent = (array) $content; ?>
<?php $socContent['dinamyc'] = true; ?>
<?php $socContent['soc_url'] = $content['binded_link']; ?>
<?php include(Yii::getPathOfAlias('webroot') . '/themes/mobispot/views/mobile/widget/spot/soc_content.php'); ?>
 