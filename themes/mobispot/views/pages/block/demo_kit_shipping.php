<div class="row tab-item">
    <a class="tab-back"
        ng-click="dkitForm($event, '2')"
        href="javascript:;">
        <i class="icon">&#xe602;&#xe602;</i>
    </a>
    <div class="small-9 large-9 column">
        <h3><?php echo Yii::t('store', 'Address')?></h3>
        <div class="show-address">
            <div>{{order.name}}</div>
            <div>{{order.email}}</div>
            <div>{{order.address}}, {{order.city}}, {{order.country}}, {{order.zip}}</div>
            <div>{{order.phone}}</div>

        </div>
        <div class="small-6 large-6 columns">
            <h3><?php echo Yii::t('store', 'Shipping')?></h3>
            <div class="shipping-form">
                <?php foreach ($config['shipping'] as $shipping):?>
                <div class="row" ng-init="registerShipping(<?php echo $shipping['id'] ?>, <?php echo $shipping['price'] ?>)">
                    <div class="radio">
                        <input
                            id="shiping<?php echo $shipping['id'] ?>"
                            type="radio"
                            name="shipping"
                            value="<?php echo $shipping['id'] ?>"
                            <?php if ($shipping['id'] == $config['shipping'][0]['id']):?>
                                checked
                                ng-init="setShipping(<?php echo $shipping['id'] ?>)"
                            <?php endif ?>
                        >
                        <label
                            for="shiping<?php echo $shipping['id'] ?>"
                            ng-click="setShipping(<?php echo $shipping['id'] ?>)"
                        >
                            <?php echo $shipping['name'] ?> |
                            <?php echo $shipping['descr'] ?>
                        </label>
                    </div>
                </div>
                <?php endforeach ?>
            </div>
        </div>

        <div class="small-6 large-6 columns">
            <h3><?php echo Yii::t('store', 'Payment')?></h3>
            <div class="shipping-form">
                <?php foreach ($config['payment'] as $payment): ?>
                <div class="row"
                    ng-init="registerPayment(<?php echo $payment['id'] ?>, '<?php echo $payment['action'] ?>')">
                    <div class="radio">
                        <input
                            id="payment<?php echo $payment['id'] ?>"
                            type="radio"
                            name="payment"
                            value="<?php echo $payment['id'] ?>"
                            <?php if ($payment['id'] == $config['payment'][0]['id']):?>
                            checked
                            ng-init="setPayment(<?php echo $payment['id'] ?>)"
                            <?php endif ?>
                            >
                        <label
                            for="payment<?php echo $payment['id'] ?>"
                            ng-click="setPayment(<?php echo $payment['id'] ?>)"
                        >
                            <?php echo $payment['name'] ?>
                        </label>
                    </div>
                </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
    <div class="small-3 large-3 column">
        <div class="next-step">
                <h3>
                    <?php echo Yii::t('store', 'Total:')?> {{total}} <?php echo Yii::t('store', 'USD')?>
                    </h3>
                <p>
                <?php echo ('en' == Lang::getCurrentLang())?'$':''?>{{summ}}<?php echo ('en' == Lang::getCurrentLang())?'':'$'?>
                +
                <?php echo ('en' == Lang::getCurrentLang())?'$':''?>{{shippings[order.shipping]}}<?php echo ('en' == Lang::getCurrentLang())?'':'$'?>
                <?php echo Yii::t('store', '(Shipping)')?></p>
            <a class="form-button button button-round"
                ng-click="buyDemoKit(order)"
                ng-init="finishButton='<?php echo Yii::t('store', 'FINISH!')?>';toMainMessage='<?php echo $config['toMainMessage']?>'"
            >{{finishButton}}</a>
        </div>
    </div>
</div>