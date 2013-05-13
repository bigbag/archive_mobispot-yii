			<div class="m-content-block" ng-controller="ProductCtrl" ng-init="StoreInit('<?php echo Yii::app()->request->csrfToken; ?>')">
			<table class="twelve store-items">
				<tbody>
				<tr ng-repeat="product in products">
					<td>
						<div class="mainimageshell">
						<div class="viewwindow">
							<ul class="fullsizelist aslide" ng-style="product.listposition">
								<li ng-repeat="image in product.photo" class="aslide">
									<img class="large" ng-src="<?php echo $imagePath; ?>{{image}}" />
								</li>
							</ul>
						</div>
						</div>
						<div class="thumbsshell">
							<div class="thumbswrapper">
								<ul class="aslide">
									<li ng-repeat="image in product.photo" ng-class="thumbLiClass($index)" ng-click="scrollTo(image,$index, product.jsID)">
										<div class="thumbwrapper">
											<img  class="thumbnail" ng-src="<?php echo $imagePath; ?>{{image}}" width="50">
										</div>
									</li>
								</ul>
							</div>
						</div>
					</td>
					<td class="store-items__description">
						<header>
							<h1>{{product.name}}</h1>
							<span>{{product.code}}</span>
							<div class="store-items__price">${{product.selectedSize.price}}</div>
						</header>
						<p>{{product.description}}</p>
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
									<input type="number" ng-model="product.quantity" />
								</div>
							</div>
							<div class="columns twelve" ng-show="product.color.length > 0">
								<div class="label"><?php echo Yii::t('store', 'Choose your color'); ?></div>
								<ul class="choose-color add-active">
									<li ng-repeat="color in product.color" ng-class="colorClass(product.selectedColor, color)" ng-click="setColor(product.jsID, color)"><i class="bg-{{color}}"></i></li>
								</ul>
							</div>
							<footer class="columns twelve">
								<a class="spot-button" href="" ng-click="addToCart(product.jsID)"><?php echo Yii::t('store', 'Add to cart'); ?></a><span ng-class="totalClass(product.totalInCart)"><?php echo Yii::t('store', 'Already in cart: '); ?>{{product.totalInCart}}</span>
							</footer>
						</div>
					</td>
				</tr>

				</tbody>
			</table><!--
			<div class="m-preload m-content-preload">
				<img src="/themes/mobispot/images/mobispot-loading%2040.gif">
			</div>
			-->
			</div>			
