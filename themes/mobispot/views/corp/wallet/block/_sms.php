<?php $phone = (!empty($sms_info['phone']))?$sms_info['phone']:'';?>

<div class="toggle-active" ng-init="sms.token=user.token;sms.savedPhone='<?php echo $phone;?>'">
    <a  id="WalletSmsInfo" 
        class="checkbox checkbox-h agree" 
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
            ng-init="sms.wallet_id=<?php echo $wallet->id;?>;sms.all_wallets=<?php echo $sms_info['all_wallets'];?>">
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
            <a class="checkbox agree <?php echo ($sms_info['all_wallets'])?'active':''?>"  ng-click="setSmsAllWallets(sms)">
                <i class="large"></i>
                <span ng-show="sms.savedPhone"> 
                    <?php echo Yii::t('corp_wallet', 'Один номер для всех кошельков'); ?>
                </span>
                <span ng-hide="sms.savedPhone"> 
                    <?php echo Yii::t('corp_wallet', 'Установить один номер и для всех остальных кошельков'); ?>
                </span>
            </a>
        </p>
        <div ng-show="sms.savedPhone" class="condition02">
            <h3><?php echo Yii::t('corp_wallet', 'Смс оповещение включено для номера:'); ?></h3>
            <p>{{sms.savedPhone}}</p>
            <a class="spot-button <?php echo empty($sms_info['phone'])?'dispaly-none':'';?>" 
                ng-click="cancelSms(sms)">
                <?php echo Yii::t('corp_wallet', 'Отключить'); ?>
            </a>
        </div>
    </div>
</div>