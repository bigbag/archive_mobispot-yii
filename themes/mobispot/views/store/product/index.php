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
                            <div class="columns six inline choose">
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
