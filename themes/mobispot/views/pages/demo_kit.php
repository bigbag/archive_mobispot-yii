<?php $this->pageTitle = Yii::t('store', 'Mobispot demo-kit'); ?>
<?php $this->mainBackground = 'main-bg-w.png'?>
<?php $this->blockFooterScript = '<script src="/themes/mobispot/angular/app/controllers/demokit.js"></script>'?>

    <div class="content-wrapper" ng-controller="DemokitController" >
        <div class="content-block" id="demo-kit-block" ng-init="order.token='<?php echo Yii::app()->request->csrfToken ?>'">
        <div class="row">
        <div class="large-12 columns form-block">
            <div>
                <div class="row">
                    <div class="column large-12">
                        <ul class="get-up-nav">
                            <li class="active"  ng-click="dkitForm($event, '1')"><?php echo Yii::t('store', 'Step 1: General info')?></li>
                            <li ng-click="dkitForm($event, '2')"><?php echo Yii::t('store', 'Step 2: Delivery details')?></li>
                            <li ng-click="dkitForm($event, '3')"><?php echo Yii::t('store', 'Step 3: Payment and shipping')?></li>
                        </ul>
                    </div>
                </div>
                <div class="row tab-item active">
                    <div class="small-9 large-9 column">
                        <h2><?php echo Yii::t('store', 'Mobispot demo-kit')?></h2>
                        <p class="form-h clearfix">
                            <?php echo Yii::t('store', 'With our demo-kit you can create really stunning applications. Bring the magic of one tap to your apps for NFC handsets, POS terminals and simple contactless readers.')?> <br>

                        </p>
                        <div class="kit-items">
                            <table class="table">
                                <?php foreach ($config['product'] as $product): ?>
                                <tr ng-init="registerProduct(<?php echo $product['id']?>, <?php echo $product['price']?>)">
                                    <td>
                                        <?php /*
                                        <div class="img-w">
                                            <img ng-click="addProduct(<?php echo $product['id']?>)" src="<?php echo $product['img'] ?>">
                                            <span>x{{products.<?php echo $product['id']?>}}</span><a ng-click="addProduct(<?php echo $product['id']?>)" class="plus">+</a><a ng-click="deductProduct(<?php echo $product['id']?>)" class="minus" ng-show="products.<?php echo $product['id']?>">-</a>
                                        </div>
                                        */?>
                                        <div class="img-w">
                                            <img src="<?php echo $product['img'] ?>">
                                            <span>x<?php echo $config['defalutCountForAll']?>
                                        </div>
                                    <td>
                                        <?php echo $product['descr'] ?>
                                    </td>
                                    <?php if ($product['id'] == $config['product'][0]['id']): ?>
                                    <td rowspan="3" class="table-info"><a href="javascript:;"><?php echo Yii::t('store', 'API description in.pdf')?></a> <br>
                                        <?php echo Yii::t('store', 'If you need a description how to handle Spots in your application download')?>
                                    </td>
                                    <?php endif ?>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                    </div>
                </div>
                <div>
                <div class="small-3 large-3 column">
                    <div class="next-step" ng-init="summ=<?php echo $config['price']?>">
                        <h3><?php echo Yii::t('store', 'Price:')?> {{summ}} <?php echo Yii::t('store', 'USD')?></h3>
                        <p><?php echo Yii::t('store', 'Worldwide')?></p>
                        <a class="form-button button button-round" href="javascript:;" ng-click="dkitForm($event, '2')"><?php echo Yii::t('store', 'Make Order')?> >></a>
                    </div>
                </div>
            </div>
            </div>
                <div class="row tab-item">
                    <a class="tab-back" ng-click="dkitForm($event, '1')" href="javascript:;"><i class="icon">&#xe602;&#xe602;</i></a>
                    <div class="small-9 large-9 column">
                        <div class="column small-6 large-6">
                        <form id="help-in" name="helpForm" class="custom">
                            <div class="form-item">
                                <h3><?php echo Yii::t('store', 'Customer')?></h3>
                                <input
                                        name='name'
                                        type="text"
                                        ng-model="order.name"
                                        placeholder="<?php echo Yii::t('store', 'Name')?>"
                                        maxlength="300"
                                        ng-minlength="3"
                                        required >
                                <input
                                        name='email'
                                        type="email"
                                        ng-model="order.email"
                                        placeholder="<?php echo Yii::t('store', 'Email*')?>"
                                        ng-init="emailNeedMessage='<?php echo $config['emailNeedMessage'] ?>'"
                                        maxlength="300"
                                        ng-minlength="3"
                                        required >
                                </div>
                            <div class="form-item">
                            <h3><?php echo Yii::t('store', 'Delivery details')?></h3>
                            <input
                                    name='phone'
                                    type="text"
                                    ng-model="order.phone"
                                    placeholder="<?php echo Yii::t('store', 'Phone')?>">
                            <input
                                    name='address'
                                    type='text'
                                    ng-model="order.address"
                                    placeholder="<?php echo Yii::t('store', 'Address')?>"
                                    required >
                            <input
                                    name='city'
                                    type='text'
                                    ng-model="order.city"
                                    placeholder="<?php echo Yii::t('store', 'City')?>"
                                    required >
                            <input
                                    name='zip'
                                    type='text'
                                    ng-model="order.zip"
                                    placeholder="<?php echo Yii::t('store', 'Zip / Post code')?>"
                                    required >
                            <input
                                    name='country'
                                    type='text'
                                    ng-model="order.country"
                                    placeholder="<?php echo Yii::t('store', 'Country')?>"
                                    required >
                            </div>
                        </form>
                        </div>
                        <div class="column small-6 large-6 form-info">
                                <?php echo Yii::t('store', '*Все поля обязательны к заполнению. Пожалуйста будьте внимательны.')?>
                        </div>
                    </div>
                        <div class="small-3 large-3 column">
                                <div class="next-step">
                                    <h3><?php echo Yii::t('store', 'last step')?></h3>
                                    <a class="form-button button button-round button-round_2line" href="javascript:;" ng-click="dkitForm($event, '3', 1)"> <?php echo Yii::t('store', 'Payment and shipping')?> >></a>
                                </div>
                        </div>
                </div>
                <div class="row tab-item">
                <a class="tab-back" ng-click="dkitForm($event, '2')" href="javascript:;"><i class="icon">&#xe602;&#xe602;</i></a>
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
                                            <?php echo $shipping['name'] ?> | +<?php echo $shipping['price'] ?>$
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
                                <div class="row" ng-init="registerPayment(<?php echo $payment['id'] ?>, '<?php echo $payment['action'] ?>')">
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
                                <h3><?php echo Yii::t('store', 'Total:')?> {{total}} <?php echo Yii::t('store', 'USD')?></h3>
                                <p>{{summ}}$ + {{shippings[order.shipping]}}$ (Shipping)</p>
                            <a class="form-button button button-round"
                                ng-click="buyDemoKit(order)"
                                ng-init="finishButton='<?php echo Yii::t('store', 'FINISH!')?>';toMainMessage='<?php echo $config['toMainMessage']?>'"
                            >{{finishButton}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <div class="fc"></div>