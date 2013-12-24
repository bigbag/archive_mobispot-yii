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