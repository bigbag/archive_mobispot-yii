<div class="row" 
    id="auto-payment" 
    ng-init="recurrent.history_id=<?php echo current($cards) ;?>">
    <div class="m-auto-payment bg-gray <?php echo ($auto)?'active':''?>">
        <div class="large-12 columns">
            <h3><?php echo Yii::t('corp_wallet', 'Автоплатежи');?></h3>
            <span class="sub-h">
                <?php echo Yii::t('corp_wallet', 'Система автопополнение баланса при остатке менее') ;?> 
                <?php echo $limit_autopayment ;?> 
                <?php echo Yii::t('corp_wallet', 'руб.');?>
            </span>
        </div>
        <div class="large-12 m-auto-block">
            <form id="enableReccurent" 
                class="item-area__right custom" 
                style="display: <?php echo ($auto)?'none':'block'?>;" name="recurrentForm">
                <div class="large-5 columns">
                    <label for="auto-payment"><?php echo Yii::t('corp_wallet', 'C какой карты');?></label>
                    <div class="content-row large-12 left g-clearfix">
                        <select class="medium" 
                            id="recurrent_card" 
                            ng-model="recurrent.history_id" 
                            required>
                            <?php foreach ($cards as $key=>$value): ?>
                            <option value="<?php echo $value;?>">
                                <?php echo $key;?>
                            </option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="large-4 columns">
                    <label for="auto-payment">
                        <?php echo Yii::t('corp_wallet', 'Сумма до которой пополнять');?>
                    </label>
                    <div class="clearfix form-line">
                        <div class="large-12 columns" ng-init="recurrent.amount=100">
                            <input id="p1" 
                                type="text" 
                                ng-pattern="/[0-9]+/" 
                                ng-model="recurrent.amount" 
                                placeholder="<?php echo Yii::t('corp_wallet', 'сумма,');?>"  
                                maxlength="50" required class="ng-pristine ng-invalid ng-invalid-required ng-valid-pattern b-pay-input">
                                <span class="right b-currency">
                                    <?php echo Yii::t('corp_wallet', 'руб.');?>
                                </span>
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
                <a class="terms settings-button"  id="j-settings">
                    <?php echo Yii::t('corp_wallet', 'Условия использования функции "Автопополнение"');?>
                </a>
            </form>
            
            <form id="disableReccurent" class="item-area__left custom" style="display: <?php echo ($auto)?'block':'none'?>;">
                <div class="m-card-block">
                    <h5><?php echo Yii::t('corp_wallet', 'Автоплатеж будет производится с карты:');?></h5>
                    <div class="m-card-cur m-card_<?php echo (!empty($auto))?PaymentLog::getSystemByPan($auto->card_pan):'uniteller'; ?>">
                        <div id="card_pan">
                            <?php echo Yii::t('corp_wallet', 'Карта: ');?>
                            <span class="m-card-info" id="auto-payment-card">
                                <?php echo (!empty($auto))?$auto->card_pan:'';?>
                            </span>
                        </div>
                        <div id="card_date">
                            <?php echo Yii::t('corp_wallet', 'Дата подключения: ');?>
                            <span class="m-card-info" id="auto-payment-date">
                                <?php echo (!empty($auto))?$auto->creation_date:''?>
                            </span>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="large-5 input-sum columns">
                        <h5><?php echo Yii::t('corp_wallet', 'Сумма до которой будет пополняться:');?></h5>
                        <div class="clearfix form-line">
                            <div class="large-12 columns text-right">
                                    <span class="m-card-info">
                                        <span id="auto-payment-summ">
                                            <?php echo (!empty($auto))?$auto->amount:''?>
                                        </span>
                                        <span class="right b-currency">
                                            <?php echo Yii::t('corp_wallet', 'руб.');?>
                                        </span>
                                    </span>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            
            <div class="large-3 apay-button columns">
                <a id="buttonApayOn" 
                    class="spot-button text-center on-apay button-disable"  
                    ng-click="enableRecurrent(recurrent, recurrentForm.$valid)">
                    <?php echo Yii::t('corp_wallet', 'Включить');?>
                </a>
                <a id="buttonApayOff" 
                    class="spot-button text-center off-apay"  
                    ng-click="disableRecurrent(payment.wallet)">
                    <?php echo Yii::t('corp_wallet', 'Отключить');?>
                </a>
            </div>
        </div>
    </div>
</div>