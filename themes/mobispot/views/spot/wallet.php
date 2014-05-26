<div class="spot-content">
    <section class="spot-wrapper active">
        <div class="spot-hat">
            <?php include('block/menu.php'); ?>
        </div>
        <div class="tabs-block">
            <section class="wallet-block spot-content_row tabs-item">
                <span ng-init="wallet.status=<?php echo $wallet->status; ?>"></span>
                <div class="row popup-row" ng-class="{disable: wallet.status == -1}">
                    <div class="">
                        <div class="item-area item-area_w clearfix info-pick">
                            <div class="row">
                                <div class="row wallet-block">
                                    <?php include('block/wallet_cards.php'); ?>
                                </div>
                                <div class="row last-operations">
                                    <?php include('block/wallet_history.php'); ?>
                                </div>
                                <div class="cover"></div>
                            </div>
                        </div>
                    </div>
                    <div class="block-information">
                        <i class="icon">&#xe606;</i><?php echo Yii::t('spot', 'Account is blocked ...')?>
                        <a href="javascript:;" ng-click="blockedWallet()">
                            <?php echo Yii::t('spot', 'Unblock')?>
                        </a>
                    </div>
                </div>
            </section>
        </div>
    </section>
</div>