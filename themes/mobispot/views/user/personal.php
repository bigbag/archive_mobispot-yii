<div class="row">
  <div class="column twelve">
<button ng-click="add()">Add</button>
    <?php $this->widget('MListView', array(
      'dataProvider'=>$dataProvider,
      'itemView'=>'block/spots',
      'itemsTagName'=>'ul',
      'itemsCssClass'=>'spot-list',
      'enableSorting'=>false,
      'template'=>'{items} {pager}',
      'cssFile'=>false,
      'id'=>'spotslistview',
    )); ?>
  </div>
</div>
<div class="row">
  <div class="column twelve text-center toggle-active">
    <a href="javascript:;" id="actSpot" class="add-spot toggle-box button round"><span class="tooltip"><?php echo Yii::t('spot', 'Add another spot')?></span></a>
  </div>
</div>
<div id="actSpotForm" class="slide-box add-spot-box">
  <div class="row">
    <div class="six centered column">
      <input type="text" ng-model="spot.code" placeholder="<?php echo Yii::t('spot', 'Spot activation code')?>">
      <div class="form-row toggle-active">
        <a class="checkbox agree" href="javascript:;">
          <i></i>
          <?php echo Yii::t('spot', 'I agree to Mobispot Pages Terms')?>
        </a>
      </div>
      <div class="form-control">
        <a class="spot-button" href="#" ng-click="activate(spot)"><?php echo Yii::t('spot', 'Activate spot')?></a>
      </div>
    </div>
  </div>
</div>
<div class="popup slow bg-gray hide">
    <div class="row">
      <div class="column twelve">
        <ul class="add-active settings-list">
          <li class="active">Make spot business</li>
          <li>Make spot invisible</li>
          <li>Clean spot</li>
          <li>Delete your spot</li>
        </ul>
        <footer>
          <h4>Are you sure?</h4>
          <p>
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit,
            sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
            Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper
            suscipit lobortis nisl ut aliquip ex ea commodo consequat.
          </p>
          <a class="button round" href="javascript:;">Yes</a>
          <a class="button round active" href="javascript:;">No</a>
        </footer>
      </div>
    </div>
  </div>