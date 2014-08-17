<div class="row tab-item" ng-class="{active: (store.stage == 'delivery')}">
    <a class="tab-back"
        ng-click="store.stage = 'desc'" href="javascript:;">
        <i class="icon">&#xe602;&#xe602;</i>
    </a>
    <div class="small-9 large-9 column">
        <div class="column small-6 large-6">
        <form id="help-in" name="orderForm" class="custom">
            <div class="form-item">
                <h3><?php echo Yii::t('store', 'Customer')?></h3>
                <input name='name'
                        type="text"
                        ng-model="order.name"
                        placeholder="<?php echo Yii::t('store', 'Name')?>"
                        maxlength="300"
                        ng-minlength="2"
                        ng-class="{error: error.field}"
                        required >
                <input name='email'
                        type="email"
                        ng-model="order.email"
                        placeholder="<?php echo Yii::t('store', 'Email')?>"
                        ng-init="fillAllMessage='<?php echo $config['fillAllMessage'] ?>'"
                        maxlength="300"
                        ng-minlength="3"
                        ng-class="{error: error.field}"
                        required >
            </div>
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
        </form>
        </div>
        <div class="column small-6 large-6 form-info">
            <p>
            <?php echo Yii::t('store', 'If you have additional suggestions about the delivery or content of the demo kit, please contact us before you place and pay for your order, and we will sort it out quickly.') ?>
            </p>
            <br>
            <p>
            <?php echo Yii::t('store', 'All the fields must be filled. Please be careful.')?>
            </p>
        </div>
    </div>
    <div class="small-3 large-3 column">
        <div class="next-step">
            <h3><?php echo Yii::t('store', 'Final step')?></h3>
            <a class="form-button button button-round button-round_2line"
                href="javascript:;"
                ng-click="store.stage = 'shipping'">
                <?php echo Yii::t('store', 'Payment and shipping')?> >>
            </a>
        </div>
    </div>
</div>
