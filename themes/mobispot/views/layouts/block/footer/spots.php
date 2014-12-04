<footer class="footer-page content">
    <ul class="left info-links">
        <li>
            <a href="/readers">
                <?php echo Yii::t('phone', 'Device compatibility'); ?>
            </a>
        </li>
        <li>
            <a href="mailto:helpme@mobispot.com">
                <?php echo Yii::t('general', 'Email us'); ?>
            </a>
        </li>
        <li class="lang">
            <ul class="lang-list">
                <li class="<?php echo ('en' == Yii::app()->language)?'current-lang':'' ?>">
                    <a href="/service/lang/en">
                        <img src="/themes/mobispot/img/lang-icon_en.png">English
                    </a>
                </li>
                <li class="<?php echo ('ru' == Yii::app()->language)?'current-lang':'' ?>">
                    <a href="/service/lang/ru">
                        <img src="/themes/mobispot/img/lang-icon_ru.png">Русский
                    </a>
                </li>
                <li class="<?php echo ('zh_cn' == Yii::app()->language)?'current-lang':'' ?>">
                    <a href="/service/lang/zh_cn">
                        <img src="/themes/mobispot/img/lang-icon_zh_cn.png">中文简体
                    </a>
                </li>
                <!-- <li class="<?php //echo ('zh_tw' == Yii::app()->language)?'current-lang':'' ?>">
                    <a href="/service/lang/zh_tw">
                        <img src="/themes/mobispot/img/lang-icon_zh_tw.png">中文繁體
                    </a>
                </li> -->
            </ul>
            <span class="current">
                <img src="/themes/mobispot/img/lang-icon_<?php echo Yii::app()->language ?>.png">
            </span>
        </li>
    </ul>
    <ul class="soc-link right">
        <li><a class="icon" href="https://twitter.com/heymobispot">&#xe001;</a></li>
        <li><a class="icon" href="http://www.facebook.com/heyMobispot">&#xe000;</a></li>

    </ul>
</footer>

<div id="customCard" class="overlay-page" ng-controller="SpotController">
    <a href="javascript:;" ng-click="hideCustomCard()" class="close-button icon">&#xE00B;</a>
    <h1><?php echo Yii::t('spot', 'Персонализация карты')?></h1>
    <p><?php //echo Yii::t('spot', 'Необходимо сверстать страницу, на которой будет создаваться кастомный дизайн траспортной карты.')?> </p>
    <div class="personal-block">
    <div class="row">
        <div class="column small-6 large-6">
                <h5><span class="number">1</span> <?php echo Yii::t('spot', 'Выберите тип карты')?></h5>
                <form class="custom" action="">
                    <div class="content-row large-6 left g-clearfix">
                    <?php $transport_types=TransportType::model()->findAll(); ?>
                        <?php foreach ($transport_types as $type):?>
                        <span ng-init="initTransportType(
                            '<?php echo $type->id; ?>',
                            '<?php echo $type->name; ?>',
                            '<?php echo $type->img; ?>')">
                        </span>
                        <?php endforeach; ?>
                        <span ng-init="selected_type = transport_types[0];setType(transport_types[0])"></span>
                        <select class="medium" ng-model="selected_type" ng-change="setType(selected_type)" ng-options="type as type.name for type in transport_types">
                        </select>
                    </div>
                    <div id="card-back" class="personal-card horizontal"></div>
                    <p class="step-description"></p>
                </form>
        </div>
        <div class="column small-6 large-6">
                <h5><span class="number">2</span> <?php echo Yii::t('spot', 'Персональные данные')?></h5>
                <div class="personal-card vertical">
                    <form id="form-photo" enctype="multipart/form-data" action="/spot/uploadImg">
                        <input type="hidden" name="img_type" value="transport_photo">
                        <input type="hidden" name="discodes_id">
                        <input type="hidden" name="token">
                        <div class="upload-photo">
                            <image-crop
                                data-id="crop-photo"
                                data-inputid="input-photo"
                                data-width="165"
                                data-height="165"
                                data-shape="circle"
                                data-step="imageCropStep"
                                data-result="custom_card.photo_croped"
                                ng-show="showImageCropper"
                            ></image-crop>
                            <label for="input-photo" class="face-holder">
                            <span class="upload-holder"><?php echo Yii::t('spot', 'Загрузить фото')?></span> <i class="icon upload-holder">&#xE60F;</i>
                            </label>
                        </div>

                    </form>
                    <div class="owner-info">
                        <textarea ng-model="custom_card.name" class="name" placeholder="<?php echo Yii::t('spot', 'Ваше имя')?>" maxlength="22"></textarea>
                        <textarea class="position" style="padding-bottom:15px;" ng-model="custom_card.position" placeholder="<?php echo Yii::t('spot', 'Должность')?>" maxlength="34"></textarea>
                    </div>
                    <form id="form-logo" enctype="multipart/form-data" action="/spot/uploadImg">
                        <input type="hidden" name="img_type" value="transport_logo">
                        <input type="hidden" name="discodes_id">
                        <input type="hidden" name="token">
                        <div class="upload-logo">
                            <image-crop
                                data-id="crop-logo"
                                data-inputid="input-logo"
                                data-width="230"
                                data-height="60"
                                data-shape="square"
                                data-step="imageCropStep"
                                data-result="custom_card.logo_croped"
                                ng-show="showLogoCropper"
                            ></image-crop>
                            <label for="input-logo" class="face-holder"><span class="upload-holder"><?php echo Yii::t('spot', 'Загрузить логотип')?></span></label>
                        </div>
                    </form>

                </div>
                <p class="step-description">
                    <?php echo Yii::t('spot', 'Внесите на карту все необходимые данные. Будьте внимательны:')?> <br>
                    <br>
                    - <?php echo Yii::t('spot', 'Фото будет обрезано до пропорций')?> <b>165x165</b> <br>
                    <br>
                    - <?php echo Yii::t('spot', 'Допустимые разширения для картинок:')?> <b>jpg, gif, png</b><br>
                    <br>
                    - <?php echo Yii::t('spot', 'Избегайте изображений обнаженной груди')?> <br>
                    <br>
                    - <?php echo Yii::t('spot', 'Длина имени не больше чем')?> <b>22</b> <?php echo Yii::t('spot', 'символа')?><br>
                    <br>
                    - <?php echo Yii::t('spot', 'Длина должности')?> <b>34</b> <?php echo Yii::t('spot', 'символа')?><br>
                        <br>
                    - <?php echo Yii::t('spot', 'Логотип будет образан до пропорций')?> <b>230x60</b>

                </p>
        </div>
    </div>
    <div class="row">
        <div class="column small-12 large-12">
            <form class="custom" id="form-shipping" name="shippingForm">
                    <h5><span class="number">3</span><?php echo Yii::t('spot', 'Информация по доставке')?></h5>
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
                                    <a class="form-button button button-round" ng-click="orderTransportCard(custom_card, shippingForm.$valid, '<?php echo Yii::t('spot', 'Заказ оформлен')?>')" href="javascript:;"><?php echo Yii::t('spot', 'FINISH!')?></a>
                                </div>
                                <span></span>
                            </div>
            </form>
        </div>
    </div>
</div>
