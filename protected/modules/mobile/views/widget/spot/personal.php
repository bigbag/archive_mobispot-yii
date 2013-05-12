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
	<?php elseif($type == 'socnet'): ?>
		<div class="spot-item">
			<div class="item-area type-mess">
				<?php if(isset($content['data'][$key]['photo'])): ?>
					<div class="user-avatar round"><img src="<?php echo $content['data'][$key]['photo']; ?>" height="90">
					</div>
				<?php endif; ?>
				<?php if(isset($content['data'][$key]['last_status'])): ?>
					<p><?php echo $content['data'][$key]['last_status']; ?></p>
				<?php endif; ?>
				<?php if(isset($content['data'][$key]['vimeo_last_video'])): ?>
					<iframe src="http://player.vimeo.com/video/<?php echo $content['data'][$key]['vimeo_last_video']; ?>" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
				<?php endif; ?>
				<?php if(isset($content['data'][$key]['soc_url'])): ?>
					<a href="<?php echo $content['data'][$key]['soc_url']; ?>" class="spot-button soc-link" >
					<span><?php echo $content['data'][$key]['invite']; ?></span> <i class="<?php echo $content['data'][$key]['inviteClass']; ?> round"></i>
					</a>
				<?php endif; ?>			
			</div>
		</div>
	<?php endif; ?>
<?php } ?>