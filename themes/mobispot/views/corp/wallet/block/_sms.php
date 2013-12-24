<div class="toggle-active">
    <a  id="WalletSmsInfo" 
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
        <form class="custom" name="smsForm" 
            ng-init="sms.wallet_id=<?php echo $wallet->id;?>;sms.all_wallets=0">
            <label>
                <?php echo Yii::t('corp_wallet', '10 цифр, например, 9013214567');?>
            </label>
            <div class="content-row large-12 left g-clearfix">
                <select class="medium" 
                    ng-model="sms.prefix"  
                    ng-init="sms.prefix='+7'"
                    required>
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
                    ng-pattern="/[0-9]+/" 
                    maxlength="10"
                    minlength="10"
                    ng-minlength="10"
                    ng-maxlength="10"
                    ng-change="removePhoneError()"
                    required>

                <a ng-click="savePhone(sms, smsForm.$valid)" 
                    class="spot-button popup-button">
                    <?php echo Yii::t('corp_wallet', 'Сохранить'); ?>
                </a>
            </div>
        </form>
        </div>
        <p class="sub-txt sub-txt-last toggle-active">
            <a class="checkbox agree"  ng-click="setSmsAllWallets(sms)">
                <i class="large"></i>
                <?php echo Yii::t('corp_wallet', 'Включить и для всех остальных кошельков'); ?>
            </a>
        </p>
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