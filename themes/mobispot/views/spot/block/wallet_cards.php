<h4><?php echo Yii::t('spot', 'My bank cards')?>
    <a class="spot-button_block" ng-click="blockedWallet()">
        <span class="block">
        <i class="icon">&#xe606;</i>
        <?php echo Yii::t('spot', 'Block wallet')?>
        </span>
    </a>
</h4>
<div class="columns large-7 small-7">
    <table class="table table-card">
        <tbody>
        <tr ng-repeat="card in wallet.cards"
            ng-class="{'main-card': card.status==1}">
            <td>
                {{ card.type }}
            </td>
            <td>
                <i class="icon">&#xe60d;</i>{{ card.pan }}
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
                    ng-click='removeCard(card.id, $event)'>
                    <?php echo Yii::t('spot', 'Remove')?>
                </a>
            </td>
        </tr>
        <!-- <tr>
            <td class="wait-card" colspan="2">
                <?php echo Yii::t('spot', 'Linking your card is in progress. Please wait a minute.')?>
            </td>
        </tr> -->
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
    <p class="no-card" ng-hide="wallet.cards_count">
        <?php echo Yii::t('spot', 'You don’t have any bank cards linked with your spot.')?>
    </p>
</div>
<div class="columns large-5 small-5">
    <div class="m-auto-payment bg-gray" ng-class="conditionAutoP">
        <span class="sub-h">
            <?php echo Yii::t('spot', 'Link your bank cards with your wallet to make payments using your spot')?>
        </span>
            <ul class="pay-system">
                <li>
                    <img src="/themes/mobispot/img/yandex_money.png">
                </li>
                <li>
                    <img src="/themes/mobispot/img/logo_cards_small.png">
                </li>
            </ul>
        <div class="apay-button columns">
            <a class="text-center"
                href="/spot/cardOfert/<?php echo $wallet->discodes_id?>">
                <i class="icon">&#xe60e;</i>
                <?php echo Yii::t('spot', 'Link a card')?>
            </a>
        </div>
    </div>
</div>
