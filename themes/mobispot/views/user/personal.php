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
  <div class="twelve columns" <?php if(strlen($defDiscodes)) echo 'ng-init="defOpen(\''.$defDiscodes.'\')"';?>>
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
    <a href="javascript:;" id="actSpot" class="add-spot toggle-box button round"><span class="m-tooltip"><?php echo Yii::t('spot', 'Add another spot')?></span></a>
  </div>
</div>

<div id="actSpotForm" class="slide-box add-spot-box">
  <div class="row popup-content">
    <div class="six centered column">
      <form id="add-spot" name="addSpotForm">
      <input type="text"
        ng-model="spot.code"
        name="code"
        placeholder="<?php echo Yii::t('spot', 'Spot activation code')?>"
        autocomplete="off"
        maxlength="10"
        required>
      <input type="text"
        name="name"
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
  <div class="row popup-content content-settings">
      <div class="column twelve">
      <ul class="add-active settings-list">
        <li id="renameSpot" class="toggle-box spot-action"  ng-click="actionSpot(spot, $event)">
          <?php echo Yii::t('spot', 'Rename spot')?>
        </li>
          <div class="sub-content text-center rename-spot" id="renameSpotForm">
            <div class="popup-row">
              <form name="renameSpotForm">
              <input
                type="text"
                class="b-short-input"
                ng-model="spot.newName"
                name="newName"
                placeholder="<?php echo Yii::t('spot', 'New Name')?>"
                autocomplete="off"
                maxlength="50"
                required>
                <a href="javascript:;" ng-click="setNewName(spot)" class="spot-button">
                  <?php echo Yii::t('spot', 'Save')?>
                </a>
              </form>
            </div>
          </div>
        <!-- <li ng-click="makeBusinessSpot(spot)">
          <?php echo Yii::t('spot', 'Make spot business')?>
        </li> -->
        <li id="invisibleSpot" class="toggle-box spot-action" ng-click="actionSpot(spot, $event)" ng-show="spot.invisible">
          <?php echo Yii::t('spot', 'Make spot invisible')?>
        </li>
          <div class="sub-content text-center confirm" id="invisibleSpotForm">
            <h4><?php echo Yii::t('spot', 'Are you sure?')?><h4>
            <p></p>
            <a class="button round" href="javascript:;" ng-click="confirmYes(spot)">
              <?php echo Yii::t('spot', 'Yes')?>
            </a>
            <a class="button round active" href="javascript:;" ng-click="confirmNo(spot)">
              <?php echo Yii::t('spot', 'No')?>
            </a>
          </div>
        <li id="visibleSpot" class="toggle-box spot-action" ng-click="actionSpot(spot, $event)" ng-hide="spot.invisible">
          <?php echo Yii::t('spot', 'Make spot visible')?>
        </li>
          <div class="sub-content text-center confirm" id="visibleSpotForm">
            <h4><?php echo Yii::t('spot', 'Are you sure?')?><h4>
            <p></p>
            <a class="button round" href="javascript:;" ng-click="confirmYes(spot)">
              <?php echo Yii::t('spot', 'Yes')?>
            </a>
            <a class="button round active" href="javascript:;" ng-click="confirmNo(spot)">
              <?php echo Yii::t('spot', 'No')?>
            </a>
          </div>
        <li id="cleanSpot" class="toggle-box spot-action" ng-click="actionSpot(spot, $event)">
          <?php echo Yii::t('spot', 'Clean spot')?>
        </li>
          <div class="sub-content text-center confirm" id="cleanSpotForm">
            <h4><?php echo Yii::t('spot', 'Are you sure?')?><h4>
            <p></p>
            <a class="button round" href="javascript:;" ng-click="confirmYes(spot)">
              <?php echo Yii::t('spot', 'Yes')?>
            </a>
            <a class="button round active" href="javascript:;" ng-click="confirmNo(spot)">
              <?php echo Yii::t('spot', 'No')?>
            </a>
          </div>
        <li id="delSpot" class="toggle-box spot-action" ng-click="actionSpot(spot, $event)">
          <?php echo Yii::t('spot', 'Delete your spot')?>
        </li>
          <div class="sub-content text-center confirm" id="delSpotForm">
            <h4><?php echo Yii::t('spot', 'Are you sure?')?><h4>
            <p></p>
            <a class="button round" href="javascript:;" ng-click="confirmYes(spot)">
              <?php echo Yii::t('spot', 'Yes')?>
            </a>
            <a class="button round active" href="javascript:;" ng-click="confirmNo(spot)">
              <?php echo Yii::t('spot', 'No')?>
            </a>
          </div>
      </ul>
    </div>
  </div>
  <div class="row popup-content content-wallet">
    <div class="twelve columns">
      <div class="slide-content">
        <div class="twelve columns">
          <div class="item-area item-area_w">
            <div class="six columns">
              <h3>Состояние счета
                <span class="b-account b-negative b-positive">
                  0 руб.
                </span>
              </h3>
            </div>
            <div class="six columns">
              <form name="paymentForm" class="custom item-area__right clearfix ng-pristine ng-invalid ng-invalid-required" action="https://test.wpay.uniteller.ru/pay/">
                <input id="unitell_shop_id" type="hidden" name="Shop_IDP" value="">
                <input id="unitell_customer" type="hidden" name="Customer_IDP" value="">
                <input id="unitell_order_id" type="hidden" name="Order_IDP" value="">
                <input id="unitell_subtotal" type="hidden" name="Subtotal_P" value="">
                <input id="unitell_signature" type="hidden" name="Signature" value="">
                <input id="unitell_url_ok" type="hidden" name="URL_RETURN_OK" value="">
                <input id="unitell_url_no" type="hidden" name="URL_RETURN_NO" value="">
                  <div class="row">
                    <div class="twelve columns">
                      <label for="payment">Введите сумму от 100 до 1000 руб.</label>
                    </div>
                  </div>
                  <div class="row form-line">
                    <div class="six columns">
                      <input id="payment" type="text" ng-pattern="/[0-9]+/" ng-model="payment.summ" placeholder="100руб." maxlength="50" required="" class="ng-pristine ng-invalid ng-invalid-required ng-valid-pattern">
                    </div>
                    <div class="six columns">
                      <a class="spot-button button-disable text-center" href="javascript:;" ng-click="addSumm(payment, $event)">Пополнить</a><br>
                    </div>
                  </div>
              </form>
            </div>
          </div>
        </div>
        <div class="twelve columns">
          <div class="item-area item-area_w">
            <div class="m-auto-payment active">
              <div class="six columns">
                <h3>Автоплатежи </h3>
                <div class="m-card-cur">
                  <div>Карта: <span>xxxx xxxx xxxx 1234</span></div>
                  <div>Дата подключения: <span>12.04.2013</span></div>
                </div>
              </div>
              <div class="six columns">
                <form class="sum-autopayment item-area__right">
                  <div class="row">
                    <div class="twelve columns">
                      <label for="payment">Введите сумму автоплатежа</label>
                    </div>
                  </div>
                  <div class="row form-line clearfix">
                    <div class="six columns">
                      <input id="auto-payment" type="text" ng-pattern="/[0-9]+/" ng-model="payment.summ" placeholder="100руб." maxlength="50" required="" class="ng-pristine ng-invalid ng-invalid-required ng-valid-pattern">
                    </div>
                    <div class="six columns">
                      <a class="spot-button text-center" href="javascript:;">Принять</a><br>
                    </div>
                  </div>
                </form>
              </div>
              <div class="twelve columns">
                <div class="m-agreement">
                  <div class="toggle-active">
                    <a href="javascript:;" class="radio-link"><i class="large"></i>Я согласен с условиями подключения автоплатежа</a>
                  </div>
                  <p class="sub-txt sub-txt-last">
                    *Включая автоплатежи вы соглашаетесь,
                    что баланс кампусной карты "Мобиспот" будет автоматически пополняться при остатке менее 100 руб.
                    Для пополнения будет использована банковская карта по которой вы последний раз совершали пополнение.
                  </p>
                  <a href="javascript:;" class="spot-button text-center button-disable" ng-click="setAuto()">Включить</a>
                </div>
                <div class="sum-autopayment">
                  <a href="javascript:;" class="spot-button text-center button-disable" ng-click="setAuto()">Выключить</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="twelve columns">
          <div class="item-area item-area_w  item-area_table">
            <h3>Последние операции</h3>
            <div class="m-table-wrapper">
              <table class="m-spot-table" ng-grid="gridOptions">
                <thead>
                <tr>
                  <th><div></sia><span>Дата и время</span></div></th>
                  <th><div><span>Место</span></div></th>
                  <th><div><span>Сумма</span></div></th>
                </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><div>12.10.2013, 20:00</div></td>
                    <td><div>Uilliam’s</div></td>
                    <td><div>50$</div></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>