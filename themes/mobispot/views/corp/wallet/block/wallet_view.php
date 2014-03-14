<div class="slide-content clearfix">
    <div id="j-settingsForm" class="settings-block" style="display:none;">
        <div class="m-set-content">
            <div class="row">
                <h3><?php echo Yii::t('corp_wallet', 'Настройки'); ?></h3>
                <div class="settings-item sms-set">
                    <?php echo $this->renderPartial('//corp/wallet/block/_sms', array(
                        'wallet' => $wallet,
                        'sms_info' => $sms_info)
                    ); ?>
                </div>
            </div>
        </div>
    </div>
  <div id="setPayment" class="row popup-row">
    <div>
      <div class="item-area item-area_w clearfix">
        <div class="row">
            <div class="large-12 columns">
                <h3><?php echo Yii::t('corp_wallet', 'Состояние счета');?>
                    <span class="b-account b-negative b-positive">
                        <?php echo $wallet->balance;?> <?php echo Yii::t('corp_wallet', 'руб.');?>
                    </span>
                    <a id="block-button" 
                        class="spot-button spot-button_block <?php echo ($wallet->status==PaymentWallet::STATUS_ACTIVE)?'red-button':'green-button'?>"
                        ng-click="blockWallet(<?php echo $wallet->id;?>)">
                      <?php if($wallet->status==PaymentWallet::STATUS_ACTIVE):?>
                      <?php echo Yii::t('corp_wallet', 'Заблокировать');?>
                      <?php else:?>
                      <?php echo Yii::t('corp_wallet', 'Разблокировать');?>
                      <?php endif;?>
                    </a>
                </h3>
            </div>
            <div class="large-12 left columns">
                <form name="paymentForm" class="custom item-area__right clearfix ng-pristine ng-invalid ng-invalid-required clearfix" action="<?php echo Yii::app()->ut->getPayUrl();?>">
                <div id="payment-block">
                    <div class="row">
                        <div class="large-12 columns" ng-init="payment.wallet_id=<?php echo $wallet->id;?>;payment.balance=<?php echo $wallet->balance;?>">
                            <label for="payment">
                                <?php if($wallet->balance<801):?>
                                    <?php echo Yii::t('corp_wallet', 'Введите сумму от 100 до');?> <?php echo (1000-$wallet->balance);?> <?php echo Yii::t('corp_wallet', 'руб.');?>
                                <?php else:?>
                                    <?php echo Yii::t('corp_wallet', 'Вы можете пополнить кошелёк на 100 руб.');?>
                                <?php endif;?>
                            </label>
                        </div>
                    </div>
                    <div class="row form-line">
                        <div class="large-4 columns">
                            <input id="payment" type="text" ng-pattern="/[0-9]+/" ng-model="payment.amount" placeholder="<?php echo Yii::t('corp_wallet', 'сумма,');?>" maxlength="50" required="" class="ng-pristine ng-invalid ng-invalid-required ng-valid-pattern b-pay-input"><span class="right b-currency" ng-init="payment.amount=100;payment.status=<?php echo ($wallet->status);?>"><?php echo Yii::t('corp_wallet', 'руб.');?></span>
                        </div>
                        <div class="large-3 left columns">
                            <a id="add-button" class="spot-button button-disable text-center"  ng-click="addSumm(payment, $event)"><?php echo Yii::t('corp_wallet', 'Пополнить');?></a><br>
                        </div>
                        <span id="j-wallet" class="settings-button payment-rules right">
                            <?php echo Yii::t('corp_wallet', 'Условия использования и гарантии безопасности');?>
                        </span>
                    </div>
                </div>
                </form>
            </div>
        </div>

        <?php if ($cards): ?>
        <?php echo $this->renderPartial('//corp/wallet/block/_reccurent', array(
            'cards' => $cards,
            'auto' => $auto)
        ); ?>
        <div class="cover"></div>
        <?php endif;?>
      </div>
    </div>
  </div>
  <div class="row" ng-init="search.wallet_id=<?php echo $wallet->id;?>;search.limit=20">
    <div class="large-12 columns"  ng-init="getHistory(search)">
      <div id="block-history" class="item-area item-area_w item-area_table">
        <h3><?php echo Yii::t('corp_wallet', 'Последние 20 операций');?></h3>
        <div class="m-table-wrapper">
            <table id="table-history" class="m-spot-table">
            <thead>
                <tr>
                  <th><div><?php echo Yii::t('corp_wallet', 'Операция');?></div></th>
                  <th><div><?php echo Yii::t('corp_wallet', 'Дата');?></div></th>
<!--                   <th><div><?php echo Yii::t('corp_wallet', 'Тип');?></div></th> -->
                  <th><div><?php echo Yii::t('corp_wallet', 'Сумма');?></div></th>
                </tr>
                <tr>
                    <th>
                        <div>
                            <input type="text" name="term" class="b-pay-input" placeholder=<?php echo Yii::t('corp_wallet', 'Название терминала');?>/>
                        </div>
                    </th>
                    <th>
                        <div>
                            <input type="text" name="date" placeholder="<?php echo Yii::t('corp_wallet', 'Датa');?>" id="filter-date" />
                        </div>
                    </th>
                    <th colspan="2">
                        <div>
                            <a style="" class="spot-button text-center"  ng-click="getHistory(search)"><?php echo Yii::t('corp_wallet', 'Искать');?></a>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody >
                <tr ng-repeat="report in result" >
                    <td><div>{{report.desc}}</div></td>
                    <td><div>{{report.creation_date}}</div></td>
                    <!-- <td><div>{{report.type}}</div></td> -->
                    <td><div>{{report.amount}}</div></td>
                </tr>
                <tr class="m-table-bottom" ng-show="pagination.total > 1">
                    <td colspan="10">
                        <ui-pagination 
                            cur="pagination.cur" 
                            total="pagination.total" 
                            display="{{pagination.display}}">
                        </ui-pagination>
                    </td>
                </tr>
            </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
<!--   <?php if (isset($actions) && !empty($actions['loyalties'])):?>
    <div id="wallet-actions" class="item-offers">
        <div class="twelve">
            <div class="item-area clearfix item-area_w  item-area_table">
                <h3><?php echo Yii::t('corp_wallet', 'Специальные предложения');?><sup class="count"><?php echo $actions['total'];?></sup>
                    <a id="block-card" class="spot-button__link spot-button__g spot-button_block" href="/wallet/offers">
                        <?php echo Yii::t('corp_wallet', 'Все имеющиеся');?>
                    </a>
                </h3>
                <div class="table-fltr add-active">
                    <a id="actions-actual" 
                        class="spot-button active" 
                        ng-click="getSpecialActions(<?php echo $wallet->id;?>, 1, <?php echo WalletLoyalty::STATUS_ACTUAL;?>, '')">
                        <?php echo Yii::t('corp_wallet', 'Актуальные');?>
                    </a>
                    <a id="actions-not-actual" 
                        class="spot-button" 
                        ng-click="getSpecialActions(<?php echo $wallet->id;?>, 1, <?php echo WalletLoyalty::STATUS_NOT_ACTUAL;?>, '')">
                        <?php echo Yii::t('corp_wallet', 'Прошедшие');?>
                    </a>
                    <input class="no-active" 
                        type="text" 
                        ng-model="actions.search" 
                        ng-init="actions.search=''" 
                        placeholder="<?php echo Yii::t('corp_wallet', 'Поиск');?>">
                    <a id="button-search" 
                        class="spot-button text-center no-active" 
                         
                        ng-click="getSpecialActions(<?php echo $wallet->id;?>, 1)">
                        <?php echo Yii::t('corp_wallet', 'Искать');?>
                    </a>
                </div>
                <div class="m-table-wrapper">
                    <table id="actions-table" class="m-spot-table" ng-grid="gridOptions">
                        <thead>
                        <tr>
                            <th><div><span><?php echo Yii::t('corp_wallet', 'Магазин');?></span></div></th>
                            <th><div><span><?php echo Yii::t('corp_wallet', 'Условие');?></span></div></th>
                            <th><div><span><?php echo Yii::t('corp_wallet', 'Описание');?></span></div></th>
                            <th><div><span><?php echo Yii::t('corp_wallet', 'Период');?></span></div></th>
                            <th><div><span><?php echo Yii::t('corp_wallet', 'Бонус');?></span></div></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php include(Yii::getPathOfAlias('webroot') . '/themes/mobispot/views/corp/wallet/block/loyalty.php'); ?>
                        </tbody>
                    </table>
                </div>

                <div class="cover"></div>
            </div>
        </div>
    </div>
  <?php endif;?> -->
</div>
