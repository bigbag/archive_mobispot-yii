<?php $this->main_background = 'main_bg_2.jpg'?>
<div class="content-wrapper">
    <div class="content-block" ng-controller="PhonesController">
        <div class="row">
            <div class="large-12 columns form-block">
                <div>
                    <div class="row">
                        <div class="column large-12">
                            <h2 class="color">Device compatibility</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-7 large-7 column">
                            <h5 class="two-line color">
                                Phones & tablets
                            </h5>
                            <p>
                                Spots can be read by many popular phones and tablets with NFC functionality.<br> Here is the list of currently supported devices:
                            </p>
                        </div>
                        <div class="small-5 large-5 column">
                            <h5 class="color two-line">Contactless readers</h5>
                            <p>
                                Spots can be read by many popular contactless readers with MIFARE chips support. We have tested and verified compatibility with these devices:
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-7 large-7 column">
                            <ul ng-model="phonesList" class="device-list">
                                <li ng-repeat="phones in phonesList" class="company">
                                    <h5>{{phones.brand}}</h5>
                                    <ul ng-model="phones.models">
                                        <li ng-repeat="phone in phones.models"><a title="Official page {{phones.brand}} {{phone.name}}" href="{{phone.page}}">{{phone.name}}</a></li>
                                    </ul>

                                    <div class="bad-phones" ng-class="{show: phones.badModels}" ng-model="phones.badModels">
                                        <p>Special app needed. These devices must have Special app to read the spots:</p>
                                        <ul>
                                            <li ng-repeat="phone in phones.badModels">
                                                <a title="Official page {{phones.brand}} {{phone.name}}" href="{{phone.page}}">{{phone.name}}</a>   
                                            </li>
                                        </ul>
                                </li>
                                </ul>
                        </div>
                        <div class="small-5 large-5 column">
                            <ul ng-model="devicesList" class="device-list">
                                <li ng-repeat="device in devicesList" class="company">
                                    <h5>{{device.brand}}</h5>
                                    <ul ng-model="device.models">
                                        <li ng-repeat="phone in device.models"><a title="Official page {{device.brand}} {{phone.name}}" href="{{device.page}}">{{phone.name}}</a></li>
                                    </ul>
                                </li>
                                </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="fc"></div>