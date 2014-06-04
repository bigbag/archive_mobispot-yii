<?php $this->pageTitle = Yii::t('spot', 'User agreement confirmation'); ?>
<?php $this->blockFooterScript = '<script src="/themes/mobispot/angular/app/controllers/spot.js"></script>'?>
<div class="content-wrapper" ng-controller="SpotController">
    <div>
        <?php if ($linking['error'] == 0): ?>
        <div class="row">
            <div class="content-block">
                <h2><?php echo Yii::t('spot', 'User agreement confirmation')?></h2>
                <p>
                    <?php echo Yii::t('spot', 'Please read and confirm that you accept the')?>
                    <a href="https://money.yandex.ru/doc.xml?id=522764" target="_blank">
                    <?php echo Yii::t('spot', 'Yandex.Money User Agreement')?>
                    </a>
                </p>
                <p>
                    <?php echo Yii::t('spot', 'Attention! To link the bank card with your spot we will have to charge you $0.029.')?>
                </p>
                <form action="<?php echo $linking['url']?>" method="POST" id="linking_card" >
                    <input type="hidden"
                        name="cps_context_id"
                        value="<?php echo $linking['params']['cps_context_id']?>" >
                    <input type="hidden"
                        name="paymentType"
                        value="<?php echo $linking['params']['paymentType']?>" >

                    <div class="checkbox">
                        <input id="spot_agree"
                            ng-model="card.terms"
                            ng-init="card.terms=0"
                            type="checkbox"
                            name="formSpot_agree"
                            value="0"
                            required
                            >
                        <label for="spot_agree">
                            <?php echo Yii::t('spot', 'Yes, I accept the agreement')?>
                        </label>
                    </div>
                    <br />
                </form>

                <a class="form-button on" ng-click="linkingCard(card)">
                    <?php echo Yii::t('spot', 'Link a bank card')?>
                </a>
            </div>
        </div>
        <?php else: ?>
        <div class="row" ng-init="countReset()">
            <div class="content-block not-available">
                <h2><?php echo Yii::t('spot', 'Service is currently not available')?></h2>
                <p><?php echo Yii::t('spot', 'Another attempt will be performed in')?>
                     <b>{{ reset_time }}</b>
                    <?php echo Yii::t('spot', 'seconds')?></p>
            </div>
        </div>
    <?php endif; ?>
    </div>
</div>
