<h4><?php echo Yii::t('spot', 'My bank cards')?>
    <a class="spot-button_block" ng-click="blockedWallet()">
        <span class="block">
        <i class="icon">&#xe606;</i>
        <?php echo Yii::t('spot', 'Block wallet')?>
        </span>
    </a>
</h4>
<div class="columns large-7 small-7">
    <div class="card-block">
        <table class="table table-card"
            ng-show="wallet.cards_count || wallet.linking_card">
            <tbody>
                <tr ng-repeat="card in wallet.cards"
                    ng-class="{'main-card': card.status==1}">
                    <td>
                        <span ng-hide="card.system">
                            <i class="icon">&#xe60d;</i>
                        </span>
                        <span ng-show="card.system">
                            <i class="icon">
                                <img class="ya-icon" src="/themes/mobispot/img/ya-ltl.jpg">
                            </i>
                        </span>
                        {{ card.type }} {{ card.pan }}
                    </td>
                    <td class="txt-right">
                        <a class="make-main"
                            ng-click='setPaymentCard(card.id, $event)'>
                            <?php echo Yii::t('spot', 'Make current')?>
                        </a>
                        <span class="main-indicator">
                            <?php echo Yii::t('spot', 'Current')?>
                        </span>
                        <a class="remove-card"
                            ng-click='removeCard(card.id)'>
                            <?php echo Yii::t('spot', 'Remove')?>
                        </a>
                    </td>
                </tr>
                <tr ng-show="wallet.linking_card">
                    <td class="wait-card" colspan="3">
                        <?php echo Yii::t('spot', 'Linking your card is in progress. Please wait a minute.')?>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="text-right" ng-init="wallet.card_edit = 0" ng-show="wallet.cards_count">
            <a ng-click="editCardList()" class="minor-link" ng-hide="wallet.card_edit">
                <i class="icon">&#xe009;</i>
                <?php echo Yii::t('spot', 'Edit the list')?>
            </a>
            <a ng-click="editCardList()" class="minor-link" ng-show="wallet.card_edit">
                <i class="icon">&#xe009;</i>
                <?php echo Yii::t('spot', 'Finish editing')?>
            </a>
        </div>
    </div>
    <p class="no-card"
        ng-show="!wallet.linking_card && !wallet.cards_count">
        <?php echo Yii::t('spot', 'You don’t have any bank cards linked with your spot.')?>
    </p>
</div>
<div class="columns large-5 small-5">
    <div class="m-auto-payment">
        <h5><?php echo Yii::t('spot', 'Choose a payment method')?></h5>
        <span class="sub-h"><?php echo Yii::t('spot', 'Link your bank cards or Yandex.Money account with your wallet to make payments using your spot')?></span>
        <ul class="pay-system">
            <li>
                <a class="cards" 
                    href="/spot/cardOfert/<?php echo $wallet->discodes_id?>">
                    <span><img src="/themes/mobispot/img/logo_cards_small.png"></span>
                    <label><?php echo Yii::t('spot', 'Link bank card')?></label>
                </a>
            </li>
            <li>
                <a class="ya-wallet"
                    href="/spot/addYMWallet?spot=<?php echo $wallet->discodes_id?>">
                    <span><img src="/themes/mobispot/img/yandex_money.png"></span>
                    <label><?php echo Yii::t('spot', 'Link yandex.wallet')?></label>
                </a>
            </li>
        </ul>
    </div>
</div>