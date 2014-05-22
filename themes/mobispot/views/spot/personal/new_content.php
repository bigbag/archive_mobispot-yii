<?php $dataKey = $key; ?>
<?php $socContent = (array) $content; ?>
<?php $socContent['dinamic'] = true; ?>
<?php if(!empty($content['binded_link'])):?>
    <?php $socContent['soc_url'] = $content['binded_link']; ?>
<?php endif?>
<?php if(!empty($socContent['block_type'])): ?>
    <?php include(Yii::getPathOfAlias('webroot') . '/themes/mobispot/views/spot/personal/soc_block/'
        .$socContent['block_type']
        .'.php'); 
    ?>
<?php else:?>
        <?php include(Yii::getPathOfAlias('webroot') . '/themes/mobispot/views/mobile/widget/spot/soc_content.php'); ?>
<?php endif ?>
