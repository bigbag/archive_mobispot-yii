<?php $folderUploads = substr(Yii::getPathOfAlias('webroot.uploads.spot.'), (strpos(Yii::getPathOfAlias('webroot.uploads.spot.'), Yii::getPathOfAlias('webroot'))+strlen(Yii::getPathOfAlias('webroot'))) ) . '/'; ?>
<?php foreach ($content['keys'] as $key=>$type){ ?>
	<?php if($type == 'text'): ?>
		<div class="spot-item">
			<p class="item-area item-type__text"><?php echo $content['data'][$key]; ?></p>
		</div>
	<?php elseif($type == 'image'): ?>
		<div class="item-area text-center">
			<img src="<?php echo $folderUploads.$content['data'][$key]; ?>">
		</div>	
	<?php elseif($type == 'file'): ?>
		<a href="<?php echo $folderUploads.$content['data'][$key]; ?>" class="item-area text-center">
			<div class="file-block">
				<span><?php echo $content['data'][$key]; ?></span>
				<img src="/themes/mobile/images/icons/i-files.2x.png" width="80">
			</div>
		</a>
	<?php elseif($type == 'soclink'): ?>
		<div class="spot-item">
			<div class="item-area type-mess">
				<div class="user-avatar round"><img src="<?php echo $content['data'][$key]['avatar']; ?>" height="90"></div><p><?php echo $content['data'][$key]['lastPost']; ?></p>
				<a href="<?php echo $content['data'][$key]['link']; ?>" class="spot-button soc-link" ><span>Follow me on</span> <i class="i-soc-twi round"></i></a>
			</div>
		</div>	
	<?php endif; ?>
<?php } ?>