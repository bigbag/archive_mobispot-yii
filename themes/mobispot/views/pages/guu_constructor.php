<?php $this->pageTitle = Yii::t('general', 'Наши клиенты'); ?>
<?php $this->casingClass = 'clients'?>

    <div class="content-wrapper">
        <div class="content-block">
        <div class="row">
        <div class="large-12 columns form-block">
            <div id="customCard" class="guu-card" ng-controller="SpotController" ng-init="custom_card.token='<?php echo Yii::app()->request->csrfToken ?>'">
                
                <h1><?php echo Yii::t('spot', 'Персонализация карты')?></h1>
                <div class="personal-block">
                <div class="row">
                    <div class="column small-6 large-6">
                            <h5><span class="number">1</span> <?php echo Yii::t('spot', 'Персональные данные')?></h5>
                            <div class="personal-card vertical">
                                    <div class="upload-photo crop-wrapper">
                                        <image-crop
                                            data-id="crop-photo"
                                            data-inputid="input-photo"
                                            data-width="162"
                                            data-height="162"
                                            data-shape="square"
                                            data-step="imageCropStep"
                                            data-result="custom_card.photo_croped"
                                            ng-show="showImageCropper"
                                        ></image-crop>
                                        
                                        <label for="input-photo" class="face-holder">
                                        <span class="upload-holder"><?php echo Yii::t('spot', 'Загрузить фото')?></span> <i class="icon upload-holder">&#xE60F;</i>
                                        </label>
                                    </div>

                                <div class="owner-info">
                                    <textarea ng-model="custom_card.name" class="name" placeholder="<?php echo Yii::t('spot', 'Ваше имя')?>" maxlength="28"></textarea>
                                    <textarea class="position" ng-model="custom_card.position" placeholder="<?php echo Yii::t('spot', 'Должность')?>" maxlength="40"></textarea>
                                    <textarea class="department" ng-model="custom_card.department" placeholder="<?php echo Yii::t('spot', 'Отдел')?>" maxlength="40"></textarea>
                                </div>
                                
                                <span class="card-number" ng-init="custom_card.number='<?php echo $number;?>'">#{{custom_card.number}}</span>

                            </div>
                            </div>
                            <p class="step-description">
                                <?php echo Yii::t('spot', 'Внесите на карту все необходимые данные. Будьте внимательны:')?> <br>
                                <br>
                                - <?php echo Yii::t('spot', 'Фото будет обрезано до пропорций')?> <b>128x162</b> <br>
                                <br>
                                - <?php echo Yii::t('spot', 'Допустимые разширения для картинок:')?> <b>jpg, gif, png</b><br>
                            </p>
                    </div>
                </div>
                <div class="row">
                    <div class="column small-12 large-12">
                        <form class="custom" id="form-shipping" name="shippingForm">
                                <h5><span class="number">2</span><?php echo Yii::t('spot', 'Информация по доставке')?></h5>
                                            <div class="column small-4 large-4">
                                                <input
                                                        name='email'
                                                        type="email"
                                                        ng-model="custom_card.email"
                                                        placeholder="<?php echo Yii::t('spot', 'Email')?>"
                                                        ng-class="{error: error.custom_card}"
                                                        required>
                                                <input
                                                        name='name'
                                                        type="text"
                                                        ng-model="custom_card.shipping_name"
                                                        placeholder="<?php echo Yii::t('spot', 'Name')?>"
                                                        ng-class="{error: error.custom_card}"
                                                        required>
                                                <input
                                                        name='phone'
                                                        type="text"
                                                        ng-model="custom_card.phone"
                                                        placeholder="<?php echo Yii::t('spot', 'Phone')?>"
                                                        ng-class="{error: error.custom_card}"
                                                        required>
                                                <input
                                                        name='address'
                                                        type='text'
                                                        ng-model="custom_card.address"
                                                        placeholder="<?php echo Yii::t('spot', 'Address')?>"
                                                        ng-class="{error: error.custom_card}"
                                                        required>
                                                <input
                                                        name='city'
                                                        type='text'
                                                        ng-model="custom_card.city"
                                                        placeholder="<?php echo Yii::t('spot', 'City')?>"
                                                        ng-class="{error: error.custom_card}"
                                                        required>
                                                <input
                                                        name='zip'
                                                        type='text'
                                                        ng-model="custom_card.zip"
                                                        placeholder="<?php echo Yii::t('spot', 'Zip / Post code')?>"
                                                        ng-class="{error: error.custom_card}"
                                                        required>
                                                        <div class="info">
                                                            <p><?php echo Yii::t('spot', 'All the fields must be filled. Please be careful.')?></p>
                                                        </div>
                                                </div>
                                            

                                            <div class="column small-4 large-4">
                                                <p><?php echo Yii::t('spot', 'После прохождения проверки вы получите письмо-подтвержение на указанный вами электронный адрес.')?> </p>
                                                <a class="form-button button button-round" ng-click="orderGUUCard(custom_card, shippingForm.$valid, '<?php echo Yii::t('spot', 'Заказ оформлен')?>')" href="javascript:;"><?php echo Yii::t('spot', 'FINISH!')?></a>
                                            </div>
                                            <span></span>
                                        </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        </div>
        </div>
    </div>
