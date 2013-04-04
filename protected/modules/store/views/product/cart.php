<div ng-controller="CartCtrl" ng-init="CartInit('<?php echo Yii::app()->request->csrfToken; ?>', '<?php echo Yii::t('product', 'Cart is empty'); ?>')">
<div class="row">
	<div class="twelve columns singlebox-margin">
		<table class="twelve store-items store-items__bag">
			<tbody>
			<tr>
				<td colspan="2" ng-class="emptyClass()">
					<h1>{{empty}}</h1>
				</td>
			</tr>
			<tr ng-repeat="product in products | orderBy:'name'">
				<td>
						<div class="mainimageshell">
						<div class="viewwindow">
							<ul class="fullsizelist aslide" ng-style="product.listposition">
								<li ng-repeat="image in product.photo" class="aslide">
									<img class="large" ng-src="{{image}}" />
								</li>
							</ul>
						</div>
						</div>
						<div class="thumbsshell">
							<div ng-class="thumbClass(product.photo.length)">
								<ul class="aslide">
									<li ng-repeat="image in product.photo" class="aslide" ng-click="scrollTo(image,$index, product.jsID)">
										<div class="thumbwrapper">
											<img  class="thumbnail" ng-src="{{image}}" width="50">
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
						<div class="store-items__price store-items__close" ng-click="deleteItem(product.jsID)">${{product.selectedSize.price}}</div>
					</header>
					<div class="details">
						<div class="twelve clearfix">
							<div class="columns six">
								<span class="label label-left">Size</span>
									<ul class="choose inline  add-active">
										<li ng-repeat="size in product.size" ng-class="sizeClass(product.selectedSize.value, size.value)" ng-click="setSize(product.jsID, size)">{{size.value}}</li>
									</ul>
							</div>
							<div class="columns six inline choose">
								<span class="label label-left"><?php echo Yii::t('product', 'Quantity'); ?></span>
								<input type="number" ng-model="product.quantity" ng-change="changeQuantity()"/>
							</div>
						</div>
						<div class="columns twelve">
							<div class="label"><?php echo Yii::t('product', 'Choose your color'); ?></div>
							<ul class="choose-color add-active">
								<li ng-repeat="color in product.color" ng-class="colorClass(product.selectedColor, color)" ng-click="setColor(product.jsID, color)"><i class="bg-{{color}}"></i></li>
							</ul>
						</div>
					</div>
				</td>
			</tr>

			</tbody>
		</table>

		<div class="twelve total-amount clearfix">
			<h1 class="biggest-heading left"><?php echo Yii::t('cart', 'Total '); ?><img src="/themes/mobispot/images/icons/i-quick.2x.png" width="88">{{summ}}$</h1>
			<a class="spot-button right" ng-show="products.length > 0" href="" ng-click="checkOut()"><?php echo Yii::t('cart', 'Proceed to checkout'); ?></a>
		</div>
	</div>
</div>
	<div  ng-class="chekingOutClass()">
		<div class="row">
			<form class="customer-info clearfix">
				<div class="six columns">
					<h3><?php echo Yii::t('cart', 'New customer'); ?></h3>
					<input type="text" ng-model="customer.first_name" placeholder="First name"/>
					<input type="text" ng-model="customer.last_name" placeholder="Last name"/>
					<input type="email" ng-model="customer.email" placeholder="Email address" <?php if (!Yii::app()->user->isGuest) echo 'disabled'; ?>/>
				</div>
				<div class="six columns">
					<h3><?php echo Yii::t('cart', 'Delivery address'); ?></h3>
					<input type="text" ng-model="customer.target_first_name" placeholder="First name"/>
					<input type="text" ng-model="customer.target_last_name" placeholder="Last name"/>
					<input type="text" ng-model="customer.address" placeholder="Address"/>
					<input type="text" ng-model="customer.city" placeholder="City"/>
					<input type="text" ng-model="customer.zip" placeholder="Zip / Postal code"/>
					<input type="text" ng-model="customer.phone" placeholder="Phone"/>
					<input type="text" ng-model="customer.country" placeholder="Country"/>
					<a class="spot-button" href="" ng-click="saveCustomer()"><?php echo Yii::t('cart', 'Save'); ?></a>
				</div>
			</form>
		</div>
		<div class="row row__magrin-b buy-options">
			<div class="six columns">
				<h3><?php echo Yii::t('cart', 'Delivery'); ?></h3>
				<span><?php echo Yii::t('cart', 'Choose the most convenient delivery option'); ?></span>
			</div>
			<div class="six columns">
				<table class="table-reset delivery-options">
					<tbody class="add-active">
					<tr ng-repeat="delivery in deliveries" ng-class="deliveryClass(delivery.jsID)" ng-click="setDelivery(delivery.jsID)">
						<td><a href="" class="radio-link"><i class="large"></i>{{delivery.name}}</a></td>
						<td>{{delivery.period}}</td>
						<td class="text-right">${{delivery.price}}</td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="row buy-options">
			<div class="six columns">
				<h3><?php echo Yii::t('cart', 'Payment'); ?></h3>
				<span><?php echo Yii::t('cart', 'Choose the most convenient delivery option'); ?></span>
			</div>
			<div class="six columns">
				<ul class="add-active payment-options">
					<li ng-repeat="payment in payments" ng-class="paymentClass(payment.jsID)" ng-click="setPayment(payment.jsID)"><a href="" class="radio-link"><i class="large"></i>{{payment.name}}</a></li>
				</ul>
			</div>
		</div>
		<div class="row">
			<div class="twelve columns text-center">
				<h3 class="total-order"><?php echo Yii::t('cart', 'Total for this order:'); ?><span class="color"> ${{summ + (selectedDelivery.price - 0)}}</span></h3>
				<a class="round-button-large" href="" ng-click="buy()"><?php echo Yii::t('cart', 'Buy'); ?></a>
			</div>
		</div>
	</div>
</div>
