<div id="constructor-troika" class="overlay-page card-constructor">
    <a href="javascript:;" ng-click="hideConstructorTroika()" class="close-button icon">&#xE00B;</a>
    <h1><?php echo Yii::t('spot', 'Персонализация карты')?></h1>
    <div class="personal-block">
        <div class="row">

            <div class="column small-6 medium-7 large-6 card-column">
                <img class="back" src="/themes/mobispot/img/troika-v.png">
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
                        <textarea ng-model="transport_card.name" class="name" placeholder="<?php echo Yii::t('spot', 'Ваше имя')?>" maxlength="22"></textarea>
                        <textarea class="position" ng-model="transport_card.position" placeholder="<?php echo Yii::t('spot', 'Должность')?>" maxlength="34"></textarea>
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
            <div class="column small-6 medium-5 large-6 descr-column">
                    <p class="step-description descr">
                        <?php echo Yii::t('spot', 'Внесите на карту все необходимые данные. Будьте внимательны:')?> <br>
                        <br>
                        - <?php echo Yii::t('spot', 'Допустимые разширения для картинок:')?> <b>jpg, gif, png</b><br>
                        <br>
                        - <?php echo Yii::t('spot', 'Минимальный размер фото: ')?> <b>165x165</b> <br><br>
                        - <?php echo Yii::t('spot', 'Максимальный допустимый размер изображений: ')?> <b>3648x2736</b> <br><br>
                        - <?php echo Yii::t('spot', 'Минимальный и рекомендуемый размер лого: ')?> <b>230x60</b> <br><br>
                        - <?php echo Yii::t('spot', 'Минимальный и рекомендуемый размер готового макета:')?> <b>638x1016</b><br>
                        <br>
                    </p>
                    <p class="step-description bottom">
                        <img src="/themes/mobispot/img/exclamation.png">
                        <?php echo Yii::t('spot', 'Не используйте изображения,<br>защищенные авторским правом.<br>Карта будет проверена на содержание.')?> <br>
                    </p>
                    
                    <a class="form-button button button-round store" ng-click="addTransportCard(transport_card);" href="javascript:;"><?php echo Yii::t('store', 'Готово!')?></a>
            </div>
        </div>
    </div>
</div>    