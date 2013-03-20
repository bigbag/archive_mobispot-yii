<li id="<?php echo $data->discodes_id;?>" class="spot-content_li bg-gray">
  <div class="spot-hat">
		<h3 ng-click="accordion($event)"><?php echo $data->name?></h3><a class="settings-button spot-button right text-center" href="javascript:;"><?php echo Yii::t('spots', 'Settings');?></a>
	</div>
	<div class="spot-content slide-content">
		<div class="spot-content_row">
			<div class="spot-item">
				<textarea></textarea>
				<label class="text-center label-cover">
					<h4>Drag your files here or begin to type info or links</h4>
					<span>A maximum file size limit of 25mb for free accounts</span>
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
	</div>
</li>