<div ng-controller="CartCtrl" ng-init="CartInit('<?php echo Yii::app()->request->csrfToken; ?>')">
    <div class="row">
        <div class="twelve columns singlebox-margin">
            <table class="twelve store-items store-items__bag">
                <tbody>
                    <tr>
                        <td id="emptyCart" colspan="2" ng-class="emptyClass()">
                            <h1><?php echo Yii::t('store', 'Cart is empty'); ?></h1>
                            <span><a class="spot-button" href="/store"><?php echo Yii::t('store', 'Back to the store'); ?></a></span>
                        </td>
                    </tr>
                    <tr ng-repeat="product in products | orderBy:'id'">
                        <td>
                            <div class="mainimageshell">
                                <div class="viewwindow">
                                    <ul class="fullsizelist aslide" ng-style="product.listposition">
                                        <li class="aslide">
                                            <img class="large" ng-src="<?php echo $imagePath; ?>{{product.photo[0]}}" />
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                        <td class="store-items__description">
                            <header>
                                <h1>{{product.name}}</h1>
                                <span>{{product.code}}</span>
                                <div class="store-items__price store-items__close" ng-click="deleteItem(product.jsID)">${{product.selectedSize.price}}</div>
                            </header>
                            <div class="details">
                                <div class="twelve clearfix">
                                    <div class="columns six" ng-show="product.size.length > 1">
                                        <span class="label label-left"><?php echo Yii::t('store', 'Size'); ?></span>
                                        <ul class="choose inline  add-active">
                                            <li ng-repeat="size in product.size" ng-class="sizeClass(product.selectedSize.value, size.value)" ng-click="setSize(product.jsID, size)">{{size.value}}</li>
                                        </ul>
                                    </div>
                                    <div class="columns six" ng-show="product.surface.length > 0">
                                        <span class="label label-left"><?php echo Yii::t('store', 'Surface'); ?></span>
                                        <ul class="choose inline add-active long">
                                            <li ng-repeat="surface in product.surface" ng-class="surfaceClass(product.selectedSurface, surface)" ng-click="setSurface(product.jsID, surface)">{{surface}}</li>
                                        </ul>
                                    </div>                            
                                    <div class="columns six inline choose">
                                        <span class="label label-left"><?php echo Yii::t('store', 'Quantity'); ?></span>
                                        <input type="number" ng-model="product.quantity" ng-change="changeQuantity()"/>
                                    </div>
                                </div>
                                <div class="columns twelve" ng-show="product.color.length > 0">
                                    <div class="label"><?php echo Yii::t('store', 'Choose your color'); ?></div>
                                    <ul class="choose-color add-active">
                                        <li ng-repeat="color in product.color" ng-class="colorClass(product.selectedColor, color)" ng-click="setColor(product.jsID, color)"><i class="bg-{{color}}"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>
            
            <div id="promoForm" class="six columns">
                <div class="label">Got a promo-code? Put it in here and get your discount.</div>
                <input type="text" name="promo" ng-model="discount.promoCode" placeholder="<?php echo Yii::t('store', 'Promo-code'); ?>">
                <a id="codeConfirm" class="spot-button right" ng-click="confirmPromo()"><?php echo Yii::t('store', 'Confirm'); ?></a>
            </div>

            <div class="twelve total-amount clearfix">
                <h1 class="biggest-heading left"><?php echo Yii::t('store', 'Total '); ?><img src="/themes/mobispot/images/icons/i-quick.2x.png" width="88">{{summ}}$</h1>
                <a id="proceedNext" class="spot-button toggle-box right slideToThis" href="javascript:;" ng-click="checkOut()"><?php echo Yii::t('store', 'Proceed to checkout'); ?></a>
            </div>
        </div>
    </div>

    <div id="proceedNextForm" class="row sub-proceed hide-content-box">
        <div class="row">
            <form name="formCustomer" class="customer-info clearfix">
                <div class="six columns">
                    <h3><?php echo Yii::t('store', 'New customer'); ?></h3>
                    <input type="text" ng-model="customer.first_name" placeholder="<?php echo Yii::t('store', 'First name'); ?>">
                    <input type="text" ng-model="customer.last_name" placeholder="<?php echo Yii::t('store', 'Last name'); ?>">
                    <input type="email" name="email" ng-model="customer.email" placeholder="<?php echo Yii::t('store', 'Email address'); ?>" required="" <?php if (!Yii::app()->user->isGuest) echo 'disabled'; ?>ng-class="valClass(formCustomer.email.$valid)">
                </div>
                <div class="six columns">
                    <h3><?php echo Yii::t('store', 'Delivery address'); ?></h3>
                    <input type="text" ng-model="customer.target_first_name" placeholder="<?php echo Yii::t('store', 'First name'); ?>">
                    <input type="text" ng-model="customer.target_last_name" placeholder="<?php echo Yii::t('store', 'Last name'); ?>">
                    <input type="text" name="address" ng-model="customer.address" placeholder="<?php echo Yii::t('store', 'Address'); ?>" required="" ng-class="valClass(formCustomer.address.$valid)">
                    <input type="text" name="city" ng-model="customer.city" placeholder="<?php echo Yii::t('store', 'City'); ?>" required="" ng-class="valClass(formCustomer.city.$valid)">
                    <input type="text" name="zip" ng-model="customer.zip" placeholder="<?php echo Yii::t('store', 'Zip / Postal code'); ?>" required="" ng-class="valClass(formCustomer.zip.$valid)">
                    <input type="text" name="phone" ng-model="customer.phone" placeholder="<?php echo Yii::t('store', 'Phone'); ?>" required="" ng-class="valClass(formCustomer.phone.$valid)">
                    <input type="text" name="country" ng-model="customer.country" placeholder="<?php echo Yii::t('store', 'Country'); ?>" required="" ng-class="valClass(formCustomer.country.$valid)">
                    <a class="spot-button toggle-box slideTo" style="cursor: pointer" ng-click="saveCustomer()"><?php echo Yii::t('store', 'Save'); ?></a>
                    <div style="visibility: hidden">
                        <a id="proceedFinish" class="spot-button toggle-box slideToThis" href="javascript:;">Save</a>
                    </div>
                </div>
            </form>

        </div>
        <div id="proceedFinishForm" class="hide-content-box">
            <div class="row row__magrin-b buy-options">
                <div class="six columns">
                    <h3><?php echo Yii::t('store', 'Delivery'); ?></h3>
                    <span><?php echo Yii::t('store', 'Choose the most convenient delivery option'); ?></span>
                </div>
                <div class="six columns">
                    <table class="table-reset delivery-options">
                        <tbody class="add-active">
                            <tr ng-repeat="delivery in deliveries" ng-class="deliveryClass(delivery.jsID)" ng-click="setDelivery(delivery.jsID)">
                                <td><a href="" class="radio-link"><i class="large"></i>{{delivery.name}}</a></td>
                                <td>{{delivery.period}}</td>
                                <td class="text-right">${{delivery.price}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row buy-options">
                <div class="six columns">
                    <h3><?php echo Yii::t('store', 'Payment'); ?></h3>
                    <span><?php echo Yii::t('store', 'Choose the most convenient delivery option'); ?></span>
                </div>
                <div class="six columns">
                    <ul class="add-active payment-options">
                        <li ng-repeat="payment in payments" ng-class="paymentClass(payment.jsID)" ng-click="setPayment(payment.jsID)"><a href="" class="radio-link"><i class="large"></i>{{payment.name}}</a></li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="twelve buy-box columns text-center">
                    <h3 class="total-order"><?php echo Yii::t('store', 'Total for this order:'); ?><span class="color"> ${{summ + (selectedDelivery.price - 0)}}</span></h3>
                    <a class="round-button-large" href="" ng-click="buy()"><?php echo Yii::t('store', 'Buy'); ?></a>
                </div>
            </div>
        </div>
            <div style="display: none;">
            <form id="payUniteller" action="<?php echo Yii::app()->ut->getPayUrl(); ?>">
                <input type="text" name="Shop_IDP"/>
                <input type="text" name="Order_IDP"/>
                <input type="text" name="Customer_IDP"/>
                <input type="text" name="Subtotal_P"/>
                <input type="text" name="Signature"/>
                <input type="text" name="URL_RETURN_OK"/>
                <input type="text" name="URL_RETURN_NO"/>
                <input id="submitUniteller" type="submit" value="Submit"/>
            </form>
            </div>
    </div>
</div>
