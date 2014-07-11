<article class="spot-link">
    <span ng-init="wallet.status=<?php echo $wallet->status; ?>;wallet.id=<?php echo $wallet->id; ?>;wallet.token=spot.token"></span>
    <div class="tabs-item">
        <hgroup>
            <h3>
                <?php echo Yii::t('spot', 'Cards list')?>
            </h3>
            <h4>
                <a ng-click="blockedWallet()" class="block-wallet b-link"><i class="icon">&#xe606;</i><?php echo Yii::t('spot', 'block wallet')?></a>
            </h4>
        </hgroup>
        <div class="card" ng-class="{blocked: wallet.status == -1}">
            <table class="card-list">
                <tr ng-repeat="card in wallet.cards" ng-class="{'main-card': card.status==1}">
                    <td><i class="icon">&#xe60d;</i>{{ card.pan }}</td>
                    <td>
                        <a class="make-main" ng-click='setPaymentCard(card.id, $event)'><?php echo Yii::t('spot', 'Make current')?></a>
                        <span class="main-ind"><?php echo Yii::t('spot', 'Current')?></span>
                    </td>
                </tr>


                <tr ng-show="wallet.linking_card">
                    <td class="wait-card" colspan="2">
                        <?php echo Yii::t('spot', 'Linking your card is in progress. Please wait a minute.')?>
                    </td>
                </tr>
                <tr ng-show="!wallet.linking_card && !wallet.cards_count">
                    <td class="wait-card empty" colspan="2">
                        <?php echo Yii::t('spot', 'You don’t have any bank cards linked with your spot.')?>
                    </td>
                </tr>
            </table>
            <div class="overlay">
                <p>
                    <i class="icon">&#xe606;</i><?php echo Yii::t('spot', 'Account is blocked ...')?> <a class="block-wallet" ng-click="blockedWallet()"><?php echo Yii::t('spot', 'Unblock')?></a>
                </p>
            </div>
        </div>
        <a href="/spot/cardOfert/<?php echo $wallet->discodes_id?>" class="b-link"> <i class="icon">&#xe60e;</i><?php echo Yii::t('spot', 'Link a bank card')?></a>
    </div>

    <div class="tabs-item">
        <h3>
            <?php echo Yii::t('spot', 'Last 5 operations')?>
        </h3>
        <table>
            <?php for($i=0; $i<5; $i++): ?>
                <?php if (!empty($history[$i])): ?>
                    <?php $row = $history[$i]; ?>
                    <tr>
                        <td><?php echo $row->creation_date; ?></td>
                        <td><?php echo $row->term->name; ?></td>
                        <td><?php echo $row->amount; ?></td>
                    </tr>
                <?php endif; ?>
            <?php endfor; ?>
        </table>
    </div>

</article>