<?php $this->mainBackground = 'main-bg-w.png'?>
<div class="content-wrapper">
<div class="content-block m-content-block store-content"
    ng-controller="ProductController"
    ng-init="StoreInit()">
    <table class="twelve store-items">
        <tbody>
            <tr ng-repeat="product in products">
                <td>
                    <div class="mainimageshell">
                        <div class="viewwindow">
                            <ul
                                class="fullsizelist aslide"
                                ng-style="product.listposition">
                                <li
                                    ng-repeat="image in product.photo"
                                    class="aslide">
                                    <img class="large" ng-src="<?php echo $imagePath; ?>{{image}}" />
                                </li>
                            </ul>
                        </div>
                    </div>
                </td>
                <td class="store-items__description">
                    <header>
                        <h1>{{product.name}}</h1>
                        <div class="store-items__price">
                            {{product.selectedSize.price}}<span class="icon currency">&#xe019;</span>
                        </div>
                    </header>
                    <p>
                        {{product.description}}
                    </p>
                    <div class="details">
                        <div class="twelve clearfix">
                            <div class="columns six"
                                ng-show="product.size.length > 1">
                                <span class="label label-left">
                                    <?php echo Yii::t('store', 'Size'); ?>
                                </span>
                                <ul class="choose inline add-active">
                                    <li
                                        ng-repeat="size in product.size"
                                        ng-class="sizeClass(product.selectedSize.value, size.value)"
                                        ng-click="setSize(product.jsID, size)">
                                        {{size.value}}
                                    </li>
                                </ul>
                            </div>
                            <div class="columns six" ng-show="product.surface.length > 0">
                                <span class="label label-left">
                                    <?php echo Yii::t('store', 'Surface'); ?>
                                </span>
                                <ul class="choose inline add-active long">
                                    <li
                                        ng-repeat="surface in product.surface"
                                        ng-class="surfaceClass(product.selectedSurface, surface)"
                                        ng-click="setSurface(product.jsID, surface)">
                                        {{surface}}
                                    </li>
                                </ul>
                            </div>
                            <div class="columns six inline choose" ng-show="product.type==1">
                                <span class="label label-left">
                                    <?php echo Yii::t('store', 'Quantity'); ?>
                                </span>
                                <input
                                    type="text"
                                    min="1"
                                    max="99"
                                    ng-model="product.quantity"
                                    ng-change="resetAddedText(product.jsID)" />
                            </div>
                        </div>
                        <div class="columns twelve" ng-show="product.color.length > 0">
                            <div class="label"><?php echo Yii::t('store', 'Choose your color'); ?></div>
                            <ul class="choose-color add-active">
                                <li ng-repeat="color in product.color" ng-class="colorClass(product.selectedColor, color)" ng-click="setColor(product.jsID, color)"><i class="bg-{{color}}"></i></li>
                            </ul>
                        </div>
                        <footer class="columns twelve">
                            <a
                                class="spot-button"

                                ng-click="addToCart(product.jsID)">{{product.addText}}</a>
                        </footer>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="bag-wrapper" ng-hide="items.count < 1">
        <a class="bag-link" href="/store/product/cart">
            <span class="icon">&#xe01a;</span>
            <h3><?php echo Yii::t('store', 'Added to cart: ')?> {{items.count}}<?php echo Yii::t('store', ' spot')?></h3>
            <div><?php echo Yii::t('store', 'Go to registration'); ?></div>
            <i>></i>
        </a>
    </div>
    <div class="bag-footer">
    </div>
    
    <?php //Troika ?>
    <?php include(Yii::getPathOfAlias('webroot') 
        . '/themes/mobispot/views/store/_troika_personalization.php');
    ?>
    
    <?php //<Simple custom card> ?>
        <div id="constructor-simple" class="overlay-page guu-card" ng-init="simple_card.token='<?php echo Yii::app()->request->csrfToken ?>'">
            <a href="javascript:;" ng-click="hideConstructorSimple()" class="close-button icon">&#xE00B;</a>
            <h1><?php echo Yii::t('spot', 'Персонализация карты')?></h1>
            <div class="personal-block">
            <div class="row">
                <div class="column small-6 large-6 large-max">
                        <div class="personal-card vertical" ng-style="{'background': 'url(/themes/mobispot/img/simple_card_frame.jpg) 0 0 no-repeat'}"
                            >
                                <div class="upload-photo crop-wrapper">
                                    <simple-crop
                                        data-id="crop-simple"
                                        data-inputid="input-simple"
                                        data-width="162"
                                        data-height="162"
                                        data-shape="square"
                                        data-step="imageCropStep"
                                        data-result="simple_card.photo_croped"
                                        ng-show="showSimpleCropper"
                                    ></simple-crop>
                                    <label for="input-simple" class="face-holder">
                                    <span class="upload-holder"><?php echo Yii::t('spot', 'Загрузить фото')?></span> <i class="icon upload-holder">&#xE60F;</i>
                                    </label>
                                </div>

                            <div class="owner-info">
                                <textarea ng-model="simple_card.name" class="name" placeholder="<?php echo Yii::t('spot', 'Ваше имя')?>" maxlength="42"></textarea>
                                <textarea class="position" ng-model="simple_card.position" placeholder="<?php echo Yii::t('spot', 'Должность')?>" maxlength="46"></textarea>
                                <textarea class="department" ng-model="simple_card.department" placeholder="<?php echo Yii::t('spot', 'Отдел')?>" maxlength="46"></textarea>
                            </div>
                            
                           <?php //<span class="card-number">#{{simple_card.number}}</span> ?>

                        </div>
                            <p class="step-description">
                                <?php echo Yii::t('spot', 'Внесите на карту все необходимые данные. Будьте внимательны:')?> <br><br>
                                <br>
                                - <?php echo Yii::t('spot', 'Рекомендуемый размер фото для загрузки: ')?> <b>128x162</b> <br><br>
                                - <?php echo Yii::t('spot', 'Минимальный размер фото: ')?> <b>128x162</b> <br><br>
                                - <?php echo Yii::t('spot', 'Максимальный размер фото: ')?> <b>3648x2736</b> <br><br>
                                - <?php echo Yii::t('spot', 'Фото будет обрезано до размера: ')?> <b>128x162</b> <br><br>
                                - <?php echo Yii::t('spot', 'Допустимые разширения для картинок:')?> <b>jpg, gif, png</b><br><br>
                            </p>

                </div>
            </div>
            <div class="row block">
                <a class="form-button button button-round store" ng-click="addSimpleCard(simple_card)" href="javascript:;"><?php echo Yii::t('store', 'FINISH!')?></a>
            </div>
        </div>
    <?php //</Simple custom card> ?> 
</div>

<div
    class="icon-bag-conteiner"
    ng-init="items.count=<?php echo $items_count;?>"
    ng-hide="items.count < 1">

    <a href="/store/product/cart" class="icon-bag-link">
        <img src="/themes/mobispot/images/icons/i-bag.2x.png" height="115">
        <span>{{items.count}}</span>
    </a>
</div>

</div>



