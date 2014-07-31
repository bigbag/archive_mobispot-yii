<?php $this->pageTitle = Yii::t('phone', 'Readers'); ?>
<?php $this->mainBackground = 'main_bg_2.jpg'?>
<div class="content-wrapper">
    <div class="content-block" ng-controller="PhonesController" ng-init="initPhones(<?php echo $phones ?>);initDevices(<?php echo $devices ?>)">
        <div class="row">
            <div class="large-12 columns form-block">
                <div>
                    <div class="row">
                        <div class="column large-12">
                            <h2 class="color">
                                <?php echo Yii::t('phone', 'Device compatibility') ?>
                            </h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-7 large-7 column">
                            <h5 class="two-line color">
                                <?php echo Yii::t('phone', 'Phones & tablets') ?>
                            </h5>
                            <p>
                                <?php echo Yii::t('phone', 'Spots can be read by many popular phones and tablets with NFC functionality.<br> Here is the list of currently supported devices:') ?>
                            </p>
                        </div>
                        <div class="small-5 large-5 column">
                            <h5 class="color two-line"><?php echo Yii::t('phone', 'Contactless readers') ?></h5>
                            <p>
                                <?php echo Yii::t('phone', 'We have tested and verified compatibility with the following readers:') ?>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-7 large-7 column">
                            <ul ng-model="phonesList" class="device-list">
                                <li ng-repeat="phones in phonesList" class="company">
                                    <h5>{{phones.brand}}</h5>
                                    <ul ng-model="phones.models">
                                        <li class="phone-name" ng-repeat="phone in phones.models">      {{phone.name}}</li>
                                    </ul>
                                </li>
                            </ul>
                            <p class="warn">
                                <?php echo Yii::t('phone', 'Special app needed. These devices must have special app to read the spots:') ?>
                            </p>
                            <ul ng-model="phonesList" class="device-list">
                                <li ng-repeat="phones in phonesList" class="company" ng-hide="!(phones.badModels.length > 0)">
                                    <h5>{{phones.brand}}</h5>
                                    <div class="bad-phones" ng-class="{show: phones.badModels}" ng-model="phones.badModels">
                                        <ul>
                                            <li class="phone-name" ng-repeat="phone in phones.badModels">
                                                {{phone.name}}</li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="small-5 large-5 column">
                            <ul ng-model="devicesList" class="device-list">
                                <li ng-repeat="device in devicesList" class="company">
                                    <h5>{{device.brand}}</h5>
                                    <ul ng-model="device.models">
                                        <li ng-repeat="phone in device.models" class="phone-name">{{phone.name}}</li>
                                    </ul>
                                </li>
                                </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <p><span class="warn"><?php echo Yii::t('phone', 'Please note: ') ?></span> <?php echo Yii::t('phone', 'Some devices specifications change regularly and depend on the sales region. For the most accurate information check with your retailer or mobile operator that NFC is enabled on your device.') ?></p>
    </div>
</div>
<div class="fc"></div>
