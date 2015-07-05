<?php $folderUploads = substr(Yii::getPathOfAlias('webroot.uploads.spot.'), (strpos(Yii::getPathOfAlias('webroot.uploads.spot.'), Yii::getPathOfAlias('webroot')) + strlen(Yii::getPathOfAlias('webroot')))) . '/'; ?>
<?php $urlVal = new CUrlValidator; ?>
<?php foreach ($content['keys'] as $key => $type): ?>
    <?php if ($type == 'text' && $urlVal->validateValue($content['data'][$key])): ?>
        <div class="spot-item">
            <div class="item-area type-itembox">
                <div class="item-head">
                    <a href="<?php echo $content['data'][$key]; ?>" class="type-link">
                        <span class="link"><?php echo $content['data'][$key]; ?></span>
                    </a>
                </div>
            </div>
        </div>
    <?php elseif ($type == 'text'): ?>
        <div class="spot-item">
            <p class="item-area item-type__text"><?php echo YText::hrefActivate($content['data'][$key]); ?></p>
        </div>
    <?php elseif ($type == 'image'): ?>
        <div class="item-area text-center">
            <a href="<?php echo $folderUploads . $content['data'][$key]; ?>">
                <img src="<?php echo $folderUploads . 'tmb_' . $content['data'][$key]; ?>">
            </a>
        </div>
    <?php elseif ($type == 'obj'): ?>
        <div class="spot-item">
            <div class="item-area type-itembox">
                <div class="item-head">
                    <a href="<?php echo $folderUploads . $content['data'][$key]; ?>" class="type-link type-file">
                        <img src="/themes/mobile/images/icons/i-files.2x.png" height="36"> <span class="link"><?php echo substr(strchr($content['data'][$key], '_'), 1); ?></span>
                    </a>
                </div>

                <div class="item-body item-download">
                    <table class="j-list">
                        <tr>
                            <td><span><?php echo Yii::t('spot', 'Type') ?></span></td>
                            <td><?php echo substr(strchr($content['data'][$key], '.'), 1); ?></td>
                        </tr>
                        <tr>
                            <td><span><?php echo Yii::t('spot', 'Description')?></span></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><span><?php echo Yii::t('spot', 'Size') ?></span></td>
                            <td><?php echo SocInfo::showFileSize(Yii::getPathOfAlias('webroot.uploads.spot.').DIRECTORY_SEPARATOR.$content['data'][$key])?></td>
                        </tr>
                    </table>
                    <a href="<?php echo $folderUploads . $content['data'][$key]; ?>" class="spot-button soc-link" >
                        <div class="item-text">
                            <?php echo Yii::t('spot', 'Tap to Download') ?>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    <?php elseif (($type == 'socnet') || ($type == 'content')): ?>
        <?php $socContent = $content['data'][$key]; ?>
        <?php $dataKey = $key; ?>
        <?php include(Yii::getPathOfAlias('webroot') . '/themes/mobispot/views/mobile/widget/spot/soc_content.php'); ?>
    <?php endif; ?>
<?php endforeach; ?>
