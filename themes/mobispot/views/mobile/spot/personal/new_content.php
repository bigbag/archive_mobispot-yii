<?php $dataKey = $key; ?>
<?php $socInfo = new SocInfo;?>
<?php if (isset($socContent) and !empty($socContent['block_type']) and !empty($socContent['soc_url'])
and ($socContent['block_type'] == SocContentBase::YOUTUBE_VIDEO)
): ?>
    <?php include(Yii::getPathOfAlias('webroot') . '/themes/mobispot/views/spot/personal/soc_block/'
        .$socContent['block_type']
        .'.php');
    ?>
<?php elseif (isset($socContent) and !empty($socContent['soc_url'])): ?>
    <?php include(Yii::getPathOfAlias('webroot') . '/themes/mobispot/views/mobile/spot/personal/soc_block/'
        .SocContentBase::TYPE_POST
        .'.php');
    ?>
<?php endif ?>