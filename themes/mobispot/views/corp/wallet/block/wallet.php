<li id="<?php echo $data->id;?>" class="spot-content_li bg-gray <?php echo ($data->status==PaymentWallet::STATUS_ACTIVE)?'':'invisible-spot'?>">
  <div class="spot-hat" ng-click="accordion($event, payment)">
    <h3><?php echo $data->name?></h3>
	<ul class="spot-hat-button">
		<li>
			<div>
				<a data-tooltip title="<?php echo Yii::t('wallet', 'Settings'); ?>" id="j-settings" class="tip-top icon-spot-button right text-center toggle-box icon" href="javascript:;">&#xe00f;</a>
			</div>
		</li>
	</ul>
  </div>
</li>