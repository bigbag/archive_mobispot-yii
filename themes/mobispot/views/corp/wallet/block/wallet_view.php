<div class="slide-content clearfix">
    <div id="j-settingsForm" class="settings-block" style="display:none;">
        <div class="m-set-content">
            <div class="row">
                <h3><?php echo Yii::t('corp_wallet', 'Настройки'); ?></h3>
                <div class="settings-item sms-set">
                    <div class="toggle-active">
                        <a  
                            id="WalletSmsInfo" 
                            class="checkbox checkbox-h agree<?php echo ($smsInfo['status'])?' status':'';?>" 
                            ng-click="ToggleSmsInfo(<?php echo $wallet->id;?>)">
                            <i class="large"></i>
                            <h3> <?php echo Yii::t('corp_wallet', 'SMS информирование'); ?></h3>
                        </a>
                        <div class="settings-item_form active-sub">
                            <p class="set-description">
                                <?php echo Yii::t('corp_wallet', ' СМС с предупреждением о скорой блокировке кошелька высылается, когда баланс опускается до 50 руб.') ;?>
                            </p>
                            <div class="condition01">
                            <form class="custom">
                                <label>
                                    <?php echo Yii::t('corp_wallet', '10 цифр, например, 9013214567');?>
                                </label>
                                <div class="content-row large-12 left g-clearfix">
                                    <select class="medium" 
                                        ng-model="sms.prefix" 
                                        required 
                                        ng-init="sms.prefix='+7'">
                                        <option value="+7">
                                            <?php echo Yii::t('corp_wallet', '+7 Россия'); ?>
                                        </option>
                                    </select>
                                </div>
                                <div class="floatleft">
                                    <input type="text" 
                                        name="phone" 
                                        ng-model="sms.phone" 
                                        placeholder="<?php echo Yii::t('corp_wallet', 'Номер телефона'); ?>" 
                                        ng-init="sms.phone=''" 
                                        maxlength="10"
                                        minlength="10"
                                        ng-minlength="10"
                                        ng-maxlength="10"
                                        required
                                        ng-change="removePhoneError()">
                                    <a id="smsForm" 
                                        ng-click="savePhone(<?php echo $wallet->id;?>)" 
                                        class="spot-button popup-button">
                                        <?php echo Yii::t('corp_wallet', 'Сохранить'); ?>
                                    </a>
                                </div>
                            </form>
                            </div>
                            <div class="toggle-active">
                                <a  
                                    id="UserSmsInfo" 
                                    class="checkbox checkbox-h agree<?php echo ($smsInfo['sms_all_wallets'])?' active':'';?>" 
                                    ng-click="SmsAllWallets(<?php echo $wallet->id;?>)">
                                    <i class="large"></i>
                                    <span> 
                                        <?php echo Yii::t('corp_wallet', 'Включить и для всех остальных кошельков'); ?>
                                    </span>
                                </a>
                            </div>
                            <div ng-show="sms.savedPhone" 
                                class="condition02" <?php echo empty($smsInfo['phone'])?'':' ng-init="sms.savedPhone =\''.$smsInfo['phone'].'\'"';?>>
                                <h3><?php echo Yii::t('corp_wallet', 'Смс оповещение включено для номера:'); ?></h3>
                                    <p>{{sms.savedPhone}}</p>
                                    <a class="spot-button <?php echo empty($smsInfo['phone'])?'dispaly-none':'';?>" 
                                        ng-click="cancelSms(<?php echo $wallet->id;?>, '')">
                                        <?php echo Yii::t('corp_wallet', 'Отменить'); ?>
                                    </a>
                            </div>
                        </div>
                    </div>
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
                         
                        ng-click="block(<?php echo $wallet->id;?>)">
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
                        <div class="large-12 columns" ng-init="payment.wallet='<?php echo $wallet->id;?>';payment.balance=<?php echo $wallet->balance;?>">
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

        <?php if ($history):?>
        <?php if ($cards): ?>
                    <?php $i = 1; ?>
                        <?php foreach ($cards as $key=>$value): ?>
                            <?php if ($i==1):?>
                                <?php $history_id=$value;?>
                            <?php endif;?>
                            <?php $i++ ; ?>
                        <?php endforeach;?>
        <div class="row" id="auto-payment" ng-init="recurrent.history_id=<?php echo $history_id;?>;newAutoPayment()">
            <div class="m-auto-payment bg-gray <?php echo ($auto)?'active':''?>">
                <div class="large-12 columns">

                        <h3><?php echo Yii::t('corp_wallet', 'Автоплатежи');?></h3>
                        <span class="sub-h"><?php echo Yii::t('corp_wallet', 'Система автопополнение баланса при остатке менее') 
                                    . ' '. $limit_autopayment . ' '. Yii::t('corp_wallet', 'руб.');?></span>
                </div>
                <div class="large-12 m-auto-block">
                    <form id="enableReccurent" class="item-area__right custom" style="display: <?php echo ($auto)?'none':'block'?>;" name="recurrentForm">
                        <div class="large-5 columns">
                            <label for="auto-payment"><?php echo Yii::t('corp_wallet', 'C какой карты');?></label>
                            <div class="content-row large-12 left g-clearfix">
                                <select class="medium" id="recurrent_card" ng-model="recurrent.history_id" required>
                                    <?php foreach ($cards as $key=>$value): ?>
                                    <option value="<?php echo $value;?>">
                                        <?php echo $key;?>
                                    </option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="large-4 columns">
                            <label for="auto-payment"><?php echo Yii::t('corp_wallet', 'Сумма до которой пополнять');?></label>
                            <div class="clearfix form-line">
                                <div class="large-12 columns" ng-init="recurrent.amount=100">
                                    <input id="p1" type="text" ng-pattern="/[0-9]+/" ng-model="recurrent.amount" placeholder="<?php echo Yii::t('corp_wallet', 'сумма,');?>"  maxlength="50" required class="ng-pristine ng-invalid ng-invalid-required ng-valid-pattern b-pay-input"><span class="right b-currency"><?php echo Yii::t('corp_wallet', 'руб.');?></span>
                                </div>
                            </div>
                        </div>

                        <p class="sub-txt sub-txt-last toggle-active">
                            <a class="checkbox agree"  ng-click="setRecurrentTerms(recurrent)">
                                <i class="large"></i>
                                <?php echo Yii::t('corp_wallet', '*Включая автоплатежи вы соглашаетесь,
                                что баланс кампусной карты "Мобиспот" будет автоматически пополняться при остатке менее') 
                                    . ' '. $limit_autopayment . ' '. Yii::t('corp_wallet', 'руб.');?>
                            </a>
                        </p>
                        <a class="terms settings-button"  id="j-settings"><?php echo Yii::t('corp_wallet', 'Условия использования функции "Автопополнение"');?></a>
                    </form>
                    
                    <form id="disableReccurent" class="item-area__left custom" style="display: <?php echo ($auto)?'block':'none'?>;">
                        <div class="m-card-block">
                            <h5><?php echo Yii::t('corp_wallet', 'Автоплатеж будет производится с карты:');?></h5>
                            <div class="m-card-cur m-card_<?php echo (!empty($auto))?PaymentLog::getSystemByPan($auto->card_pan):'uniteller'; ?>">
                                <div id="card_pan"><?php echo Yii::t('corp_wallet', 'Карта: ');?><span class="m-card-info" id="auto-payment-card"><?php echo (!empty($auto))?$auto->card_pan:'';?></span></div>
                                <div id="card_date"><?php echo Yii::t('corp_wallet', 'Дата подключения: ');?><span class="m-card-info" id="auto-payment-date"><?php echo (!empty($auto))?$auto->creation_date:''?></span></div>
                            </div>
                        </div>
                        <div>
                            <div class="large-5 input-sum columns">
                                <h5><?php echo Yii::t('corp_wallet', 'Сумма до которой будет пополняться:');?></h5>
                                <div class="clearfix form-line">
                                    <div class="large-12 columns text-right">
                                            <span class="m-card-info"><span id="auto-payment-summ"><?php echo (!empty($auto))?$auto->amount:''?></span><span class="right b-currency"><?php echo Yii::t('corp_wallet', 'руб.');?></span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    
                    <div class="large-3 apay-button columns">
                        <a id="buttonApayOn" class="spot-button text-center on-apay button-disable"  ng-click="enable_recurrent(recurrent, recurrentForm.$valid)"><?php echo Yii::t('corp_wallet', 'Включить');?></a>
                        <a id="buttonApayOff" class="spot-button text-center off-apay"  ng-click="disable_recurrent(payment.wallet)"><?php echo Yii::t('corp_wallet', 'Отключить');?></a>
                    </div>
                </div>
            </div>
        </div>
        <?php endif;?>
        <div class="cover"></div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="large-12 columns">
      <div id="block-history" class="item-area item-area_w  item-area_table">
        <h3><?php echo Yii::t('corp_wallet', 'Последние 20 операций');?></h3>
        <div class="m-table-wrapper">
          <table id="table-history" class="m-spot-table" ng-grid="gridOptions">
          <thead>
            <tr>
              <th><div><?php echo Yii::t('corp_wallet', '№');?></div></th>
              <th><div><?php echo Yii::t('corp_wallet', 'Операция');?></div></th>
              <th><div><?php echo Yii::t('corp_wallet', 'Дата');?></div></th>
              <th><div><?php echo Yii::t('corp_wallet', 'Тип');?></div></th>
              <th><div><?php echo Yii::t('corp_wallet', 'Сумма');?></div></th>
            </tr>
            <tr>
                <th><div><input type="text" style="width:5px; visibility: hidden"></div></th>
                <th><div><input type="text" class="b-pay-input" placeholder=<?php echo Yii::t('corp_wallet', 'Введите&nbsp;название&nbsp;терминала');?> name="term"/></div></th>
                <th>
                    <div>
                        <input type="text" name="date" placeholder="<?php echo Yii::t('corp_wallet', 'Введите дату');?>" id="filter-date" />
                    </div>
                </th>
                <th colspan="2"><div><a style="" class="spot-button text-center"  ng-click="getHistory(<?php echo $wallet->id.', 1, 1';?>)"><?php echo Yii::t('corp_wallet', 'Искать');?></a></div></th>
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
  <?php endif;?>
</div>
