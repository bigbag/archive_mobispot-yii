<div class="slide-content clearfix">
  <div id="setPayment" class="row popup-row">
    <div>
      <div class="item-area item-area_w clearfix">
        <div class="row">
            <div class="large-12 columns">
                <h3><?php echo Yii::t('wallet', 'Состояние счета');?>
                    <span class="b-account b-negative b-positive">
                        <?php echo $wallet->balance;?> <?php echo Yii::t('wallet', 'руб.');?>
                    </span>
                    <a id="block-button" class="spot-button spot-button_block <?php echo ($wallet->status==PaymentWallet::STATUS_ACTIVE)?'red-button':'green-button'?>"
                        href="javascript:;"
                        ng-click="block(<?php echo $wallet->id;?>)">
                      <?php if($wallet->status==PaymentWallet::STATUS_ACTIVE):?>
                      <?php echo Yii::t('wallet', 'Заблокировать');?>
                      <?php else:?>
                      <?php echo Yii::t('wallet', 'Разблокировать');?>
                      <?php endif;?>
                    </a>
                </h3>
            </div>
        </div>
    <div class="row">
            <div class="large-12 columns">
                <h2  style="color: #FF0050">Внимание!</h2>
            <p>Оставшиеся на вашем счету деньги будут использоваться для оплаты услуг
                до тех пор, пока не закончатся. После чего все платежи будут списываться напрямую с вашей банковской карты.
            </p>
            <p>Вы можете привязать к вашему кошельку карту пройдя <a href="/spot/cardOfert/<?php echo $wallet->discodes_id?>">по ссылке </a><p>
        </div>
    </div>
        <?php if ($history):?>
        <div class="cover"></div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="large-12 columns">
      <div id="block-history" class="item-area item-area_w  item-area_table">
        <h3><?php echo Yii::t('wallet', 'Последние 20 операций');?></h3>
        <div class="m-table-wrapper">
          <table id="table-history" class="m-spot-table" ng-grid="gridOptions">
          <thead>
            <tr>
              <th><div><?php echo Yii::t('wallet', '№');?></div></th>
              <th><div><?php echo Yii::t('wallet', 'Операция');?></div></th>
              <th><div><?php echo Yii::t('wallet', 'Дата');?></div></th>
              <th><div><?php echo Yii::t('wallet', 'Тип');?></div></th>
              <th><div><?php echo Yii::t('wallet', 'Сумма');?></div></th>
            </tr>
            <tr>
                <th><div><input type="text" style="width:5px; visibility: hidden"></div></th>
                <th><div><input type="text" class="b-pay-input" placeholder=<?php echo Yii::t('wallet', 'Введите&nbsp;название&nbsp;терминала');?> name="term"/></div></th>
                <th>
                    <div>
                        <input type="text" name="date" placeholder="<?php echo Yii::t('wallet', 'Введите дату');?>" id="filter-date" />
                    </div>
                </th>
                <th colspan="2"><div><a style="" class="spot-button text-center" href="javascript:;" ng-click="getHistory(<?php echo $wallet->id.', 1, 1';?>)"><?php echo Yii::t('wallet', 'Искать');?></a></div></th>
            </tr>
          </thead>
          <tbody >
            <?php include(Yii::getPathOfAlias('webroot') . '/themes/mobispot/views/corp/wallet/block/history.php'); ?>
          </tbody>
          </table>

        <div class="cover-loading">
            <img src="/themes/mobispot/images/mobispot-loading-40.gif">
        </div>
        </div>
      </div>
    </div>
  </div>
  <?php endif;?>
  <?php if (isset($actions) && !empty($actions['loyalties'])):?>
    <div id="wallet-actions" class="item-offers">
        <div class="twelve">
            <div class="item-area clearfix item-area_w  item-area_table">
                <h3><?php echo Yii::t('wallet', 'Специальные предложения');?><sup class="count"><?php echo $actions['total'];?></sup>
                    <a id="block-card" class="spot-button__link spot-button__g spot-button_block" href="/wallet/offers">
                        <?php echo Yii::t('wallet', 'Все имеющиеся');?>
                    </a>
                </h3>
                <div class="table-fltr add-active">
                    <a id="actions-actual" class="spot-button active" ng-click="getSpecialActions(<?php echo $wallet->id;?>, 1, <?php echo WalletLoyalty::STATUS_ACTUAL;?>, '')"><?php echo Yii::t('wallet', 'Актуальные');?></a>
                    <a id="actions-not-actual" class="spot-button" ng-click="getSpecialActions(<?php echo $wallet->id;?>, 1, <?php echo WalletLoyalty::STATUS_NOT_ACTUAL;?>, '')"><?php echo Yii::t('wallet', 'Прошедшие');?></a>
                    <input class="no-active" type="text" ng-model="actions.search" ng-init="actions.search=''" placeholder="<?php echo Yii::t('wallet', 'Поиск');?>">
                    <a id="button-search" class="spot-button text-center no-active" href="javascript:;" ng-click="getSpecialActions(<?php echo $wallet->id;?>, 1)"><?php echo Yii::t('wallet', 'Искать');?></a>
                </div>
                <div class="cover"></div>
            </div>
        </div>
    </div>
  <?php endif;?>
</div>
