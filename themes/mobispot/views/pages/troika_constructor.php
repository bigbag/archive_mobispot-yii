<?php $this->pageTitle = Yii::t('general', 'Заказ карты с индивидуальным дизаном'); ?>
<?php $this->casingClass = 'clients'?>

    <div class="content-wrapper">
        <div class="content-block">
        <div class="row">
        <div class="large-12 columns form-block">
            <div id="constructor-troika" class="card-constructor"  ng-controller="ProductController" ng-init="transport_card.token='<?php echo Yii::app()->request->csrfToken ?>'">
                
                <h1><?php echo Yii::t('spot', 'Персонализация карты')?></h1>
                <div class="row personal-block">
                    <div class="column small-6 large-6 large-max">
                            <h5><span class="number">1</span> <?php echo Yii::t('spot', 'Персональные данные')?></h5>


            <div class="card-column">
                <img class="back" src="/themes/mobispot/img/troika-h.png">
                <div id="card-menu" class="personal-card vertical">
                    <a class="card-button top" ng-click="showCardPattern()"><?php echo Yii::t('spot', 'Собрать дизайн<br> по шаблону')?></a>
                    <span class="card-line"><?php echo Yii::t('spot', 'или')?></span>
                    
                    <form id="form-user-design" enctype="multipart/form-data" action="/spot/uploadImg">
                        <input type="hidden" name="img_type" value="user_design">
                        <input type="hidden" name="discodes_id">
                        <input type="hidden" name="token">
                        <div class="upload-design">
                            <card-crop
                                data-id="crop-design"
                                data-inputid="input-design"
                                data-width="321"
                                data-height="513"
                                data-lwidth="638"
                                data-lheight="1016"
                                data-shape="square"
                                data-step="imageCropStep"
                                data-result="transport_card.design_croped"
                                ng-show="showDesignCropper"
                            ></card-crop>
                            <label for="input-design" class="card-button bottom"><?php echo Yii::t('spot', 'Загрузить<br> готовый макет')?></label>
                        </div>
                    </form>
                </div>
                
                <div id="card-pattern" class="personal-card vertical">
                    <a ng-click="hideCardPattern()" class="crop-control delete">&#xe00b;</a>
                    <form id="form-photo" enctype="multipart/form-data" action="/spot/uploadImg">
                        <input type="hidden" name="img_type" value="transport_photo">
                        <input type="hidden" name="discodes_id">
                        <input type="hidden" name="token">
                        <div class="upload-photo">
                            <image-crop
                                data-id="crop-photo"
                                data-inputid="input-photo"
                                data-imgtype="photo"
                                data-width="165"
                                data-height="165"
                                data-shape="circle"
                                data-step="imageCropStep"
                                data-result="transport_card.photo_croped"
                                data-userimage="transport_card.photo"
                                data-minheight="165"
                                ng-show="showImageCropper"
                            ></image-crop>
                            <label for="input-photo" class="face-holder">
                            <span class="upload-holder"><?php echo Yii::t('spot', 'Загрузить фото')?></span> <i class="icon upload-holder">&#xE60F;</i>
                            </label>
                        </div>
                    </form>
                    
                    <div class="owner-info">
                        <textarea rows="2" ng-model="transport_card.name" class="name" placeholder="<?php echo Yii::t('spot', 'Ваше имя')?>" maxlength="23"></textarea>
                        <textarea class="position" rows="2" ng-model="transport_card.position" placeholder="<?php echo Yii::t('spot', 'Должность')?>" maxlength="34"></textarea>
                    </div>
                    <form id="form-logo" enctype="multipart/form-data" action="/spot/uploadImg">
                        <input type="hidden" name="img_type" value="transport_logo">
                        <input type="hidden" name="discodes_id">
                        <input type="hidden" name="token">
                        <div class="upload-logo">
                            <image-crop
                                data-id="crop-logo"
                                data-inputid="input-logo"
                                data-imgtype="logo"
                                data-width="230"
                                data-height="60"
                                data-shape="square"
                                data-step="imageCropStep"
                                data-result="transport_card.logo_croped"
                                data-userimage="transport_card.logo"
                                data-minheight="60"
                                ng-show="showLogoCropper"
                            ></image-crop>
                            <label for="input-logo" class="face-holder"><span class="upload-holder"><?php echo Yii::t('spot', 'Загрузить логотип')?></span></label>
                        </div>
                    </form>
                </div>
            </div>
        
                                <p class="step-description">
                                    <?php echo Yii::t('spot', 'Внесите на карту все необходимые данные. Будьте внимательны:')?> <br><br>
                                    <br>
                                    - <?php echo Yii::t('spot', 'Допустимые разширения для картинок:')?> <b>jpg, gif, png</b> <br><br>
                                    - <?php echo Yii::t('spot', 'Минимальный размер фото: ')?> <b>165x165</b> <br><br>
                                    - <?php echo Yii::t('spot', 'Максимальный допустимый размер изображений: ')?> <b>3648x2736</b> <br><br>
                                    - <?php echo Yii::t('spot', 'Минимальный и рекомендуемый размер лого: ')?> <b>230x60</b> <br><br>
                                    - <?php echo Yii::t('spot', 'Минимальный и рекомендуемый размер готового макета:')?> <b>638x1016</b><br><br>
                                </p>
                            </div>
                </div>
                <div class="row shipping-block">
                    <div class="column small-12 large-12">
                        <form class="custom" id="form-shipping" name="shippingForm">
                            <h5><span class="number">2</span><?php echo Yii::t('spot', 'Информация по доставке')?></h5>
                            <div class="column small-4 large-4">
                                <input
                                        name='email'
                                        type="email"
                                        ng-model="transport_card.email"
                                        placeholder="<?php echo Yii::t('spot', 'Email')?>"
                                        ng-class="{error: error.transport_card}"
                                        required>
                                <input
                                        name='name'
                                        type="text"
                                        ng-model="transport_card.shipping_name"
                                        placeholder="<?php echo Yii::t('spot', 'Имя')?>"
                                        ng-class="{error: error.transport_card}"
                                        required>
                                <input
                                        name='phone'
                                        type="text"
                                        ng-model="transport_card.phone"
                                        placeholder="<?php echo Yii::t('spot', 'Телефон')?>"
                                        ng-class="{error: error.transport_card}"
                                        required>
                                <input
                                        name='address'
                                        type='text'
                                        ng-model="transport_card.address"
                                        placeholder="<?php echo Yii::t('spot', 'Адрес')?>"
                                        ng-class="{error: error.transport_card}"
                                        required>
                                <input
                                        name='city'
                                        type='text'
                                        ng-model="transport_card.city"
                                        placeholder="<?php echo Yii::t('spot', 'Город')?>"
                                        ng-class="{error: error.transport_card}"
                                        required>
                                <input
                                        name='zip'
                                        type='text'
                                        ng-model="transport_card.zip"
                                        placeholder="<?php echo Yii::t('spot', 'Почтовый индекс')?>"
                                        ng-class="{error: error.transport_card}"
                                        required>
                                        <div class="info">
                                            <p><?php echo Yii::t('spot', 'Все поля обязательны к заполнению. Пожалуйста, будьте внимательны.')?></p>
                                        </div>
                            </div>
                            
                            <div class="column small-4 large-4">
                                <p><?php echo Yii::t('spot', 'После прохождения проверки вы получите письмо-подтвержение на указанный вами электронный адрес.')?> </p>
                                <a class="form-button button button-round" ng-click="mailTroikaCard(transport_card, shippingForm.$valid, '<?php echo Yii::t('spot', 'Заказ оформлен')?>')" href="javascript:;"><?php echo Yii::t('spot', 'ГОТОВО!')?></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        </div>
        </div>
    </div>
