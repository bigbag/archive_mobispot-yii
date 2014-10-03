<?php $this->pageTitle = Yii::t('store', 'Mobispot demo-kit'); ?>
<?php $this->casingClass = 'demo-kit spl-extra'; ?>

<div class="content-wrapper" ng-controller="DemokitController" >
    <div class="content-block"
        id="demo-kit-block"
        ng-init="order.token='<?php echo Yii::app()->request->csrfToken ?>'">
    <div class="row">
        <div class="large-12 columns form-block">
            <div>
                <div class="row demo-block">
                    <div class="small-12 large-12 column">
                        <h1><?php echo Yii::t('store', 'Mobispot demo-kit'); ?></h1>
                        <div class="api-info">
                                <a href="javascript:;"><?php echo Yii::t('store', 'API description in.pdf')?></a> <br>
                                        <?php echo Yii::t('store', 'If you need a description how to handle Spots in your application download this file.')?> 
                        </div>
                        <p class="form-h clearfix">
                            <?php echo Yii::t('store', 'With our demo-kit you can create really stunning applications. Bring the magic of one tap to your apps for NFC handsets, POS terminals and simple contactless readers.'); ?> <br>
                        </p>
                        <div>
                        
                        <table class="table demo-list">
                            <tr>
                            <?php foreach ($config['product'] as $product): ?>
                                <td ng-init="registerProduct(<?php echo $product['id']?>, <?php echo $product['price']?>)">
                                        <div class="img-w">
                                            <img class="wristband" src="<?php echo $product['img'] ?>">
                                            <span>x<?php echo $config['defalutCountForAll']?></span>
                                        </div>
                                        <?php echo $product['descr'] ?>
                                </td>
                            <?php endforeach; ?>
                            </tr>
                        </table>
                        </div>
                        <div class="kit-items">
                        <form id="help-in" name="orderForm" class="custom">
                            <table class="table">
                            <colgroup>
                                <col width="40%">
                            </colgroup>
                                <tr>
                                    <td class="table-info">
                                    <div class="form-item">
                                        <h3><?php echo Yii::t('store', 'Customer')?></h3>
                                        <input name='name'
                                            type="text"
                                            ng-model="order.name"
                                            placeholder="<?php echo Yii::t('store', 'Name')?>"
                                            maxlength="300"
                                            ng-minlength="1"
                                            ng-class="{error: error.field}"
                                            required >
                                        <input name='email'
                                                type="text"
                                                ng-model="order.email"
                                                placeholder="<?php echo Yii::t('store', 'Email')?>"
                                                ng-init="fillAllMessage='<?php echo $config['fillAllMessage'] ?>'"
                                                maxlength="300"
                                                ng-minlength="1"
                                                ng-class="{error: error.field}"
                                                required >
                                        </div>
                                    <div class="form-item">
                            </div>
                                    </td>
                                    <td>
                                        <?php include('block/demo_kit_shipping.php'); ?>
                                    </td>
                                    <td rowspan="2">
                                            <div class="next-step">
                                            <h3><?php echo Yii::t('store', 'Total:')?> <span>{{total}} <?php echo Yii::t('store', 'USD')?></span></h3>
                                            <p>
                <?php echo ('en' == Lang::getCurrentLang())?'$':''?>{{summ}}<?php echo ('en' == Lang::getCurrentLang())?'':'$'?>
                +
                <?php echo ('en' == Lang::getCurrentLang())?'$':''?>{{shippings[order.shipping]}}<?php echo ('en' == Lang::getCurrentLang())?'':'$'?>
                <?php echo Yii::t('store', '(Shipping)')?></p>

    <div class="show-address">
        <div>{{order.name}}</div>
        <div>{{order.email}}</div>
        <div>{{order.address}}<span ng-show="order.address && (order.city || order.country || order.zip)">,</span> {{order.city}}<span ng-show="order.city && (order.country || order.zip)">,</span> {{order.country}}<span ng-show="order.country && order.zip">,</span> {{order.zip}}</div>
        <div>{{order.phone}}</div>
    </div>
                                            <a class="form-button button button-round"
                                                ng-click="buyDemoKit(order)"
                                                ng-init="finishButton='<?php echo Yii::t('store', 'FINISH!')?>';toMainMessage='<?php echo $config['toMainMessage']?>'"
                                            >{{finishButton}}</a>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
<div class="form-item">
    <h3><?php echo Yii::t('store', 'Delivery details')?></h3>
    <input name='phone'
        type="text"
        ng-model="order.phone"
        placeholder="<?php echo Yii::t('store', 'Phone')?>"
        ng-class="{error: error.field}"
        required >
    <input name='address'
            type='text'
            ng-model="order.address"
            placeholder="<?php echo Yii::t('store', 'Address')?>"
            ng-class="{error: error.field}"
            required >
    <input name='city'
            type='text'
            ng-model="order.city"
            placeholder="<?php echo Yii::t('store', 'City')?>"
            ng-class="{error: error.field}"
            required >
    <input name='zip'
            type='text'
            ng-model="order.zip"
            placeholder="<?php echo Yii::t('store', 'Zip code')?>"
            ng-class="{error: error.field}"
            required >
    <input name='country'
            type='text'
            ng-model="order.country"
            placeholder="<?php echo Yii::t('store', 'Country')?>"
            ng-class="{error: error.field}"
            required >
</div>
                                    </td>
                                    <td>
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
                                    </td>
                                </tr>
                            </table>
                            <div class="info">
                                <p><?php echo Yii::t('store', 'All the fields must be filled. Please be careful.')?></p>
                                <p><?php echo Yii::t('store', 'If you have additional suggestions about the delivery or content of the demo kit, please <a href="mailto:helpme@mobispot.com">contact us</a> before you place and pay for your order, and we will sort it out quickly.') ?></p>
                            </div>
                            </form>
                    </div>
                </div>
                <div>
            </div>
            </div>
            </div>
        </div>
    </div>
</div>
<div class="fc"></div>
</div>