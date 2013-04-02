<div class="spot-item">
	<div class="item-area">
		<p class="item-area item-type__text"><?php echo CHtml::encode($content)?></p>
		<div class="spot-cover slow">
			<a class="button remove-spot round" ng-click="removeContent(spot, <?php echo $key;?>, $event)"></a>
      <a class="button edit-spot round" ng-click="editContent(spot, <?php echo $key;?>, $event)"></a>
			<div class="move-spot"><i></i><span><?php echo Yii::t('spots', 'Move your text');?></span></div>
		</div>
	</div>
</div>