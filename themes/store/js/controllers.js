'use strict';

/* Controllers */

function ProductCtrl($scope, $http) {
	
	$scope.StoreInit = function(token){
		$scope.token = token;
		$http.get('/store/product/GetPriceList').success(function(data) {
			$scope.products = data.products;
			$scope.itemsInCart = data.itemsInCart;
			for (var i = 0; i < $scope.products.length; i++) {
				$scope.products[i].jsID = i;
				$scope.products[i].selectedSize = $scope.products[i].size[0];
				$scope.products[i].selectedColor = $scope.products[i].color[0];
				$scope.products[i].quantity = 1;
			}
		}).error(function(error){
				alert(error);
		});
	}

	$scope.addToCart = function addToCart(jsID){
		$http.post(('/store/product/AddToCart'), {
			token: $scope.token,
			id : $scope.products[jsID].id,
			quantity : $scope.products[jsID].quantity,
			selectedColor : $scope.products[jsID].selectedColor,
			selectedSize : $scope.products[jsID].selectedSize		
		}).success(function(data, status) {
			if(data.error == 'no'){
				$scope.products[jsID].added = '(added)';
				$scope.itemsInCart = data.itemsInCart;

			}else
				alert(data.error);

		}).error(function(error){
			alert(error);
		});
	}
	
	$scope.sizeClass = function(selectedSize, size) {
		if (selectedSize === size) {
			return "active";
		} else {
			return "";
		}
	}
	
	$scope.colorClass = function(selectedColor, color) {
		if (selectedColor === color) {
			return "active";
		} else {
			return "";
		}
	}	
	
	$scope.setSize = function(jsID, size){
		$scope.products[jsID].selectedSize = size;
	}
	
	$scope.setColor = function(jsID, color){
		$scope.products[jsID].selectedColor = color;
	}
}


function CartCtrl($scope, $http) {
	$scope.CartInit = function(token){
		$scope.summ = 0;
		$scope.token = token;
		$http.post('/store/product/GetCart', { token : token}).success(function(data) {
			$scope.products = data.products;
		
			for (var i = 0; i < $scope.products.length; i++) {
				$scope.products[i].jsID = i;
				$scope.products[i].quantity = parseInt($scope.products[i].quantity);
				$scope.summ += parseFloat($scope.products[i].selectedSize.price)*$scope.products[i].quantity;
			}
			$scope.checkingOut = false;
		}).error(function(error){
				alert(error);
		});
	}

	$scope.emptyClass = function() {
		if ($scope.products.length > 0) {
			return "hide";
		} else {
			return "";
		}
	}	
	
	$scope.sizeClass = function(selectedSize, size) {
		if (selectedSize === size) {
			return "active";
		} else {
			return "";
		}
	}
	
	$scope.colorClass = function(selectedColor, color) {
		if (selectedColor === color) {
			return "active";
		} else {
			return "";
		}
	}	
	
	$scope.deliveryClass = function(jsID){
		if ($scope.deliveries[jsID].id == $scope.selectedDelivery.id)
			return "active";
		else
			return "";
	}

	$scope.paymentClass = function(jsID){
		if ($scope.payments[jsID].id == $scope.selectedPayment.id)
			return "active";
		else
			return "";
	}	
	
	$scope.chekingOutClass = function(){
		if(!$scope.checkingOut){
			return "hide";
		} else {
			return "";
		}
	}
	
	$scope.setSize = function(jsID, size){
		$scope.summ -= parseFloat($scope.products[jsID].selectedSize.price)*$scope.products[jsID].quantity;
		$scope.products[jsID].selectedSize = size;
		$scope.summ += parseFloat($scope.products[jsID].selectedSize.price)*$scope.products[jsID].quantity;;
	}
	
	$scope.setColor = function(jsID, color){
		$scope.products[jsID].selectedColor = color;
	}

	$scope.setDelivery = function(jsID){
		$scope.selectedDelivery = $scope.deliveries[jsID];
	}	
	
	$scope.setPayment = function(jsID){
		$scope.selectedPayment = $scope.payments[jsID];
	}
	
	$scope.changeQuantity = function(){
		$scope.summ = 0;
		for (var i = 0; i < $scope.products.length; i++) {
			if($scope.products[i].quantity < 0)
				$scope.products[i].quantity = 0;
			$scope.summ += parseFloat($scope.products[i].selectedSize.price)*$scope.products[i].quantity;
		}
	}
	
	$scope.checkOut = function(){
		if(!$scope.checkingOut){
			$scope.checkingOut = true;
			$http.post('/store/product/GetCustomer', {token: $scope.token}).success(function(data) {
				$scope.deliveries = data.delivery;
				$scope.payments = data.payment;
				$scope.customer = data.customer;
				for (var i = 0; i < $scope.deliveries.length; i++) {
					$scope.deliveries[i].jsID = i;
				}
				for (var i = 0; i < $scope.payments.length; i++) {
					$scope.payments[i].jsID = i;
				}
				$scope.selectedDelivery = $scope.deliveries[0];
				$scope.selectedPayment = $scope.payments[0];
			}).error(function(error){
				alert(error);
			});
		}
	}

	$scope.deleteItem = function(jsID){
		$http.post(('/store/product/DeleteFromCart'), {
			token: $scope.token,
			id : $scope.products[jsID].id,
			quantity : $scope.products[jsID].quantity,
			selectedColor : $scope.products[jsID].selectedColor,
			selectedSize : $scope.products[jsID].selectedSize	
		}).success(function(data, status) {
			if (data.error == 'no'){
				$scope.products.splice(jsID, 1);
				$scope.summ = 0;
				for (var i = 0; i < $scope.products.length; i++){
					$scope.products[i].jsID = i;
					$scope.summ += parseFloat($scope.products[i].selectedSize.price)*$scope.products[i].quantity;
				}
			}else
				alert(data.error);
		}).error(function(error){
				alert(error);
		});
	}
	
	$scope.saveCustomer = function(){
		$http.post(('/store/product/SaveCustomer'), {
			token: $scope.token,
			customer : $scope.customer
		}).success(function(data, status) {
			if (data.error == 'no')
				alert('Изменения сохранены');
			else
				alert(data.error);
		}).error(function(error){
				alert(error);
		});		
	}
	
}
