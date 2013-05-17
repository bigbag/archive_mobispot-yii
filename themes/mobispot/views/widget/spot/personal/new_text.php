<div class="spot-item spot-block">
  <div class="item-area">
    <p class="item-area item-type__text"><?php echo CHtml::encode($content)?></p>
    <div class="spot-cover slow" ui-event="{dblclick : 'editContent(spot, <?php echo $key;?>, $event)'}">
      <div class="spot-activity">
        <a class="button bind-spot round" ng-click="bindSocial(spot, <?php echo $key;?>, $event)"></a>
        <a class="button edit-spot round" ng-click="editContent(spot, <?php echo $key;?>, $event)"></a>
        <a class="button remove-spot round" ng-click="removeContent(spot, <?php echo $key;?>, $event)"></a>
      </div>
      <div class="move-spot"><i></i><span><?php echo Yii::t('spots', 'Move your text');?></span></div>
    </div>
  </div>
</div>