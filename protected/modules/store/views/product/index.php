<?php Yii::app()->getClientScript()->registerScriptFile('https://ajax.googleapis.com/ajax/libs/angularjs/1.0.5/angular.min.js');?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl.'/themes/store/js/app.js');?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl.'/themes/store/js/controllers.js');?>

			<div ng-controller="ProductCtrl" ng-init="StoreInit('<?php echo Yii::app()->request->csrfToken; ?>')">

			<table class="twelve store-items">
				<tbody>
				
				<tr ng-repeat="product in products">
					<td>
						<div class="slider-items" make-slider>
							<img ng-repeat="imgHref in product.photo" src="{{imgHref}}">
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
								<div class="columns six">
									<span class="label label-left"><?php echo Yii::t('product', 'Size'); ?></span>
									<ul class="choose inline  add-active">
										<li ng-repeat="size in product.size" ng-class="sizeClass(product.selectedSize.value, size.value)" ng-click="setSize(product.jsID, size)">{{size.value}}</li>
									</ul>
								</div>
								<div class="columns six inline choose">
									<span class="label label-left"><?php echo Yii::t('product', 'Quantity'); ?></span>
									<input type="number" ng-model="product.quantity">
								</div>
							</div>
							<div class="columns twelve">
								<div class="label"><?php echo Yii::t('product', 'Choose your color'); ?></div>
								<ul class="choose-color add-active">
									<li ng-repeat="color in product.color" ng-class="colorClass(product.selectedColor, color)" ng-click="setColor(product.jsID, color)"><i class="bg-{{color}}"></i></li>
								</ul>
							</div>
							<footer class="columns twelve">
								<a class="spot-button" href="" ng-click="addToCart(product.jsID)"><?php echo Yii::t('product', 'Add to cart'); ?></a><span class="label">{{product.added}}</span>
							</footer>
						</div>
					</td>
				</tr>
				
				</tbody>
			</table>
			</div>