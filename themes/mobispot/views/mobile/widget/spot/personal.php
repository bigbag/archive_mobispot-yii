<?php $folderUploads = substr(Yii::getPathOfAlias('webroot.uploads.spot.'), (strpos(Yii::getPathOfAlias('webroot.uploads.spot.'), Yii::getPathOfAlias('webroot'))+strlen(Yii::getPathOfAlias('webroot'))) ) . '/'; ?>
<?php foreach ($content['keys'] as $key=>$type): ?>
	<?php if($type == 'text'): ?>
		<div class="spot-item">
			<p class="item-area item-type__text"><?php echo $this->hrefActivate($content['data'][$key]); ?></p>
		</div>
	<?php elseif($type == 'image'): ?>
		<div class="item-area text-center">
			<img src="<?php echo $folderUploads.$content['data'][$key]; ?>">
		</div>
	<?php elseif($type == 'obj'): ?>
		<a href="<?php echo $folderUploads.$content['data'][$key]; ?>" class="item-area text-center">
			<div class="file-block">
				<span><?php echo substr(strchr($content['data'][$key], '_'), 1); ?></span>
				<img src="/themes/mobile/images/icons/i-files.2x.png" width="80">
			</div>
		</a>
	<?php elseif($type == 'socnet'): ?>
		<div class="spot-item">
			<div class="item-area type-mess">
				<?php if(isset($content['data'][$key]['photo'])): ?>
					<div class="default-avatar"><img src="<?php echo $content['data'][$key]['photo']; ?>">
					</div>
				<?php endif; ?>
				<?php if(isset($content['data'][$key]['last_status'])): ?>
					<p><?php echo $this->hrefActivate($content['data'][$key]['last_status']); ?></p>
				<?php endif; ?>
				<?php if(isset($content['data'][$key]['vimeo_last_video'])): ?>
					<iframe src="http://player.vimeo.com/video/<?php echo $content['data'][$key]['vimeo_last_video']; ?>" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
				<?php endif; ?>
				<?php if(isset($content['data'][$key]['last_img'])): ?>
					<div class="item-area text-center">
						<?php if(isset($content['data'][$key]['last_img_msg'])): ?>
							<p><?php echo $content['data'][$key]['last_img_msg']; ?></p>
						<?php endif; ?>
						<img src="<?php echo $content['data'][$key]['last_img']; ?>">
						<?php if(isset($content['data'][$key]['last_img_story'])): ?>
							<p><?php echo $content['data'][$key]['last_img_story']; ?></p>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				<?php if(isset($content['data'][$key]['place_lat']) && isset($content['data'][$key]['place_lng'])): ?>
					<div class="item-area text-center">
						<?php if(isset($content['data'][$key]['place_msg'])): ?>
							<p><?php echo $content['data'][$key]['place_msg']; ?></p>
						<?php endif; ?>
						<div id="map_canvas_<?php echo $key; ?>" style="width:400px; height:200px; margin:0 auto"></div>
						<script>
							var initLat = <?php echo $content['data'][$key]['place_lat']; ?>;
							var initLng = <?php echo $content['data'][$key]['place_lng']; ?>;
							var latlng = new google.maps.LatLng(initLat, initLng);

							var mapOptions = {
							  zoom: 9,
							  center: latlng,
							  mapTypeId: google.maps.MapTypeId.ROADMAP
							}
							map = new google.maps.Map(document.getElementById('map_canvas_<?php echo $key; ?>'), mapOptions);

							marker = new google.maps.Marker({
								map: map,
								position: latlng,
								draggable: false
							});
						</script>
						<p><?php echo $content['data'][$key]['place_name']; ?></p>
					</div>
				<?php endif; ?>
				<?php if(isset($content['data'][$key]['utube_video_link'])) {?>
					<?php if(isset($content['data'][$key]['utube_video_flash'])) {?>
						<div class="item-area text-center">
						<object>
						  <param name="movie" value="<?php echo $content['data'][$key]['utube_video_flash']; ?>"></param>
						  <param name="allowFullScreen" value="true"></param>
						  <embed src="<?php echo $content['data'][$key]['utube_video_flash']; ?>"
							type="application/x-shockwave-flash"
							width="640" height="480" 
							allowfullscreen="true"></embed>
						</object>
						</div>
					<?php }?>
				<?php }?>				
				<?php if(isset($content['data'][$key]['soc_url'])): ?>
					<a href="<?php echo $content['data'][$key]['soc_url']; ?>" class="spot-button soc-link" >
					<span><?php echo $content['data'][$key]['invite']; ?></span> <i class="<?php echo $content['data'][$key]['inviteClass']; ?> round"></i>
					</a>
				<?php endif; ?>

			</div>
		</div>
	<?php endif; ?>
<?php endforeach; ?>