<h4><?php echo Yii::t('spot', 'My bank cards')?>
    <a class="spot-button_block" ng-click="blockedWallet()">
        <span class="block">
        <i class="icon">&#xe606;</i>
        <?php echo Yii::t('spot', 'Block this wallet!')?>
        </span>
    </a>
</h4>
<div class="columns large-7 small-7">
    <?php if($cards): ?>
    <table class="table table-card">
        <tbody>
        <?php foreach ($cards as $card):?>
        <?php $main_card = ($card->status==PaymentCard::STATUS_PAYMENT)?'main-card':''?>
        <tr class="<?php echo $main_card;?>">
            <td>
                <?php echo $card->type; ?>
            </td>
            <td>
                <i class="icon">&#xe60d;</i>
                <?php echo $card->pan; ?>
            </td>
            <td class="txt-right">
                <a class="make-main"
                    ng-click='setPaymentCard(<?php echo $card->id; ?>, $event)'>
                    <?php echo Yii::t('spot', 'Make current')?>
                </a>
                <span class="main-indicator">
                    <?php echo Yii::t('spot', 'Current')?>
                </span>
                <a class="remove-card"
                    ng-click='removeCard(<?php echo $card->id; ?>, $event)'>
                    <?php echo Yii::t('spot', 'Remove')?>
                </a>
            </td>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>
    <div class="text-right">
        <a ng-click="editCardList()" class="minor-link">
            <i class="icon">&#xe009;</i>
            <?php echo Yii::t('spot', 'Edit the list')?>
        </a>
    </div>
    <?php endif;?>
</div>
<div class="columns large-5 small-5">
    <div class="m-auto-payment bg-gray" ng-class="conditionAutoP">
        <span class="sub-h">
            <?php echo Yii::t('spot', 'To make payments using your spot, use:')?>
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
                <?php echo Yii::t('spot', 'Add a card')?>
            </a>
        </div>
    </div>
</div>