<?php $folderUploads = substr(Yii::getPathOfAlias('webroot.uploads.spot.'), (strpos(Yii::getPathOfAlias('webroot.uploads.spot.'), Yii::getPathOfAlias('webroot')) + strlen(Yii::getPathOfAlias('webroot')))) . '/'; ?>
<?php foreach ($content['keys'] as $key => $type): ?>
    <?php if ($type == 'text'): ?>
        <div class="spot-item">
            <p class="item-area item-type__text"><?php echo $this->hrefActivate($content['data'][$key]); ?></p>
        </div>
    <?php elseif ($type == 'image'): ?>
        <div class="item-area text-center">
            <a href="<?php echo $folderUploads . $content['data'][$key]; ?>">
                <img src="<?php echo $folderUploads . 'tmb_' . $content['data'][$key]; ?>">
            </a>
        </div>
    <?php elseif ($type == 'obj'): ?>
        <a href="<?php echo $folderUploads . $content['data'][$key]; ?>" class="item-area text-center">
            <div class="file-block">
                <span><?php echo substr(strchr($content['data'][$key], '_'), 1); ?></span>
                <img src="/themes/mobile/images/icons/i-files.2x.png" width="80">
            </div>
        </a>
    <?php elseif (($type == 'socnet') || ($type == 'content')): ?>
        <?php $socContent = $content['data'][$key]; ?> 
        <?php $dataKey = $key; ?>
        <?php include(Yii::getPathOfAlias('webroot') . '/themes/mobispot/views/mobile/widget/spot/soc_content.php'); ?>
    <?php endif; ?>
<?php endforeach; ?>