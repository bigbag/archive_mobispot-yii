<section class="wallet-block spot-content_row tabs-item">
<span ng-init="wallet.status=<?php echo $wallet->status; ?>"></span>
    <div id="setPayment" class="row popup-row" ng-class="{disable: wallet.status == -1}">
        <div class="">
            <div class="item-area item-area_w clearfix info-pick">
                <div class="row">
                    <div class="row wallet-block">
                        <h4><?php echo Yii::t('spot', 'Cards')?>
                            <a class="spot-button_block" ng-click="blockedWallet()">
                                <span class="block">
                                <i class="icon">&#xe606;</i>
                                <?php echo Yii::t('spot', 'block wallet')?>
                                </span>
                            </a>
                        </h4>
                        <div class="columns large-7 small-7">

                            <table class="table table-card">
                                <tbody>
                                    <tr class="main-card">
                                        <td><i class="icon">&#xe60d;</i>4315 52** **** 6679</td>
                                        <td class="txt-right">
                                            <a class="make-main" >
                                                <?php echo Yii::t('spot', 'make payment')?>
                                            </a>
                                            <span class="main-indicator">
                                                <?php echo Yii::t('spot', 'payment')?>
                                            </span>
                                            <a class="remove-card" href="#">
                                                <?php echo Yii::t('spot', 'Remove')?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><i class="icon">&#xe60d;</i>4318 34** **** 5493</td>
                                        <td class="txt-right">
                                        <a class="make-main">
                                            <?php echo Yii::t('spot', 'make payment')?>
                                        </a>
                                        <span class="main-indicator">
                                            <?php echo Yii::t('spot', 'payment')?>
                                        </span>
                                        <a class="remove-card" href="#">
                                            <?php echo Yii::t('spot', 'Remove')?>
                                        </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="text-right">
                                <a class="minor-link">
                                    <i class="icon">&#xe009;</i>
                                    <?php echo Yii::t('spot', 'Edit the list of cards')?>

                                </a>
                            </div>
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
                                    <a class="text-center" href="ofert.html">
                                        <i class="icon">&#xe60e;</i>
                                        <?php echo Yii::t('spot', 'Add a card')?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row last-operations">
                        <div class="item-area_table">
                            <h4><?php echo Yii::t('spot', 'Recent operations')?></h4>
                            <div class="m-table-wrapper">
                                <table class="m-spot-table">
                                    <tbody>
                                    <tr>
                                        <td><div>14.04.2014, 22:01</div></td>
                                        <td><div>Uilliam's, M. Bronnaya, 20a, Moscow, Russia </div></td>
                                        <td><div class="txt-right">-13.34$</div></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- <a href="javascripts:;" class="link-report">
                                <i class="icon">&#xe608;</i><?php echo Yii::t('spot', 'Statement of Account')?>
                            </a> -->
                        </div>
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