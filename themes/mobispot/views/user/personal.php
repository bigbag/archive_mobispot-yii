<div class="row">
  <div class="twelve columns spot-desc">
  <h3 class="color">Welcome back. Ready to make a change?</h3>

  <p>Your spots are listed below. Click on the spot name you want to edit.
  When it opens, you can change whatever you want.</p>

  <p>What else can you do? You can change your spot from a personal spot
  to a business spot, make your spot private, clean your spot, or even
  delete it.<p>

  <p>How much you share is up to you.</p>
  </div>
</div>

<div class="row">
  <div class="twelve columns">
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
      <form id="add-spot" name="addSpotForm">
      <input type="text"
        ng-model="spot.code"
        placeholder="<?php echo Yii::t('spot', 'Spot activation code')?>"
        autocomplete="off"
        maxlength="10"
        required>
      <input type="text"
        ng-model="spot.name"
        placeholder="<?php echo Yii::t('spot', 'Spot name')?>"
        autocomplete="off">
      <div class="form-row toggle-active">
        <a class="checkbox agree" href="javascript:;" ng-click="setTerms(spot)">
          <i></i>
          <?php echo Yii::t('spot', 'I agree to Mobispot Pages Terms')?>
        </a>
      </div>
      <div class="form-control">
        <a class="spot-button button-disable" href="javascript:;" ng-click="addSpot(spot)"><?php echo Yii::t('spot', 'Load a new spot')?></a>
      </div>
      </form>
    </div>
  </div>
</div>

<div id="spot-edit" class="spot-item hide">
  <div class="item-area">
    <textarea
      ui-keypress="{enter: 'saveContent(spot, $event)'}"
      ng-model="spot.content_new"
      ui-event="{ blur : 'hideSpotEdit()' }">
    </textarea>
  </div>
</div>

<div class="popup slow bg-gray hide">
  <div class="row content-settings">
    <div class="column twelve">
      <a href="javascript:;" class="button joyride-close-tip">X</a>
      <ul class="add-active settings-list">
        <li class="active" ng-click="renameSpot(spot)">
          <?php echo Yii::t('spot', 'Rename spot')?>
        </li>
        <li ng-click="makeBusinessSpot(spot)">
          <?php echo Yii::t('spot', 'Make spot business')?>
        </li>
        <li ng-click="renameSpot(spot)">
          <?php echo Yii::t('spot', 'Make spot invisible')?>
        </li>
        <li ng-click="cleanSpot(spot)">
          <?php echo Yii::t('spot', 'Clean spot')?>
        </li>
        <li ng-click="removeSpot(spot)">
          <?php echo Yii::t('spot', 'Delete your spot')?>
        </li>
      </ul>
      <footer>

        <div id="confirm" class="text-center">
          <h4><?php echo Yii::t('spot', 'Are you sure?')?></h4>
        <p></p>
          <a class="button round" href="javascript:;" ng-click="confirmYes(spot)">
            <?php echo Yii::t('spot', 'Yes')?>
          </a>
          <a class="button round active" href="javascript:;" ng-click="confirmNo(spot)">
            <?php echo Yii::t('spot', 'No')?>
          </a>
        </div>
      </footer>
    </div>
  </div>
  <div class="row content-wallet">
    <div class="column twelve">
      <a href="javascript:;" class="button joyride-close-tip">X</a>
      <div class="popup-row">
        <h3>Состояние счета: <span class="b-account b-negative b-positive">134$</span></h3>
        <input type="number" class="b-short-input" placeholder="0.00"><a href="#" class="spot-button active">Пополнить</a>
      </div>
      <div class="popup-row">
        <h3>Привязать карту: </h3>
        <a href="#" class="spot-button active">Привязать</a>
      </div>
      <div class="popup-row">
        <h4>Последние операции: </h4>
        <div class="m-table-wrapper">
        <table class="m-spot-table" ng-grid="gridOptions">
          <thead>
            <tr>
              <th class="active"><span> Дата и время </span></th>
              <th><span>Место</span></th>
              <th><span>Сумма</span></th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat="todo in staffRemoved|filter:search" class="m-t-cont-row">
              <td>21.03.2013</td>
              <td>Столовая</td>
              <td>2$</td>
            </tr>
            <tr ng-repeat="todo in staffRemoved|filter:search" class="m-t-cont-row">
              <td>22.03.2013</td>
              <td>Столовая</td>
              <td>10$</td>
            </tr>
            <tr ng-repeat="todo in staffRemoved|filter:search" class="m-t-cont-row">
              <td>23.03.2013</td>
              <td>Столовая</td>
              <td>6$</td>
            </tr>
          </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>