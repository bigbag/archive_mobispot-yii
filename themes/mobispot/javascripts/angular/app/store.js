'use strict';

/* Controllers */

function ProductCtrl($scope, $http) {

    $scope.StoreInit = function(token){
            $scope.token = token;
            $http.post('/store/product/GetPriceList', {token : $scope.token}).success(function(data) {
                $scope.products = data.products;
                $scope.settings = data.settings;
                //$scope.itemsInCart = data.itemsInCart;
                for (var i = 0; i < $scope.products.length; i++) {
                    $scope.products[i].jsID = i;
                    $scope.products[i].selectedSize = $scope.products[i].size[0];
                    $scope.products[i].selectedColor = $scope.products[i].color[0];
                    $scope.products[i].selectedSurface = $scope.products[i].surface[0];
                    $scope.products[i].quantity = 1;
                    $scope.products[i].listposition = {left:"0px"};
                    $scope.products[i].addText = $scope.settings.addToCart;
                    var tsTop = 90;
                    if ($scope.products[i].color.length > 0)
                        tsTop += 155;
                    if ($scope.products[i].photo.length > 3)
                        tsTop -= 56;
                    $scope.products[i].thumbShellStyle = {top:(tsTop+"px")};
                }
                $scope.inRequest = false;
            }).error(function(error){
                    alert(error);
            });

            angular.element('body').removeClass('overflow-h');
            angular.element('.m-cover-preload').fadeOut(600);            
    };
    
    var IMAGE_WIDTH = 242;    
        
    $scope.scrollTo = function(image,ind, jsID) {
        $scope.products[jsID].listposition = {left:(IMAGE_WIDTH * ind * -1) + "px"};
    };

    $scope.addToCart = function addToCart(jsID){
        if(!$scope.inRequest){
            $scope.inRequest = true;
            var added = false;
            if($scope.products[jsID].quantity == parseInt($scope.products[jsID].quantity)){
                $scope.products[jsID].totalInCart += parseInt($scope.products[jsID].quantity);
                added = true;
            }
            $http.post(('/store/product/AddToCart'), {
                token: $scope.token,
                id : $scope.products[jsID].id,
                quantity : parseInt($scope.products[jsID].quantity),
                selectedColor : $scope.products[jsID].selectedColor,
                selectedSurface : $scope.products[jsID].selectedSurface,
                selectedSize : $scope.products[jsID].selectedSize        
            }).success(function(data, status) {
                if(data.error == 'no'){
                    $scope.products[jsID].addText = $scope.settings.added;
                }else{
                    if(added)
                        $scope.products[jsID].totalInCart -= parseInt($scope.products[jsID].quantity);
                    alert(data.error);
                }
            }).error(function(error){
                if(added)
                    $scope.products[jsID].totalInCart -= parseInt($scope.products[jsID].quantity);
                alert(error);
            });

            $scope.inRequest = false;
        }
    };
    
    $scope.sizeClass = function(selectedSize, size) {
        if (selectedSize === size) {
            return "active";
        } else {
            return "";
        }
    };
    
    $scope.colorClass = function(selectedColor, color) {
        if (selectedColor === color) {
            return "active";
        } else {
            return "";
        }
    };

    $scope.surfaceClass = function(selectedSurface, surface) {
        if (selectedSurface === surface) {
            return "active";
        } else {
            return "";
        }
    };
    
    $scope.totalClass = function(totalInCart) {
        if (parseInt(totalInCart) > 0) {
            return "label";
        } else {
            return "hide";
        }
    };
    
    $scope.setSize = function(jsID, size){
        $scope.products[jsID].selectedSize = size;
        $scope.products[jsID].addText = $scope.settings.addToCart;
    };
    
    $scope.setColor = function(jsID, color){
        $scope.products[jsID].selectedColor = color
        $scope.products[jsID].addText = $scope.settings.addToCart;;
    };

    $scope.setSurface = function(jsID, surface){
        $scope.products[jsID].selectedSurface = surface;
        $scope.products[jsID].addText = $scope.settings.addToCart;
    };
    
    $scope.resetAddedText = function(jsID){
        $scope.products[jsID].addText = $scope.settings.addToCart;
    }
    
    $scope.thumbClass = function(len){
        if (len > 3)
            return "thumbswrapper xscrolled";
        else
            return "thumbswrapper";
    }
    
    $scope.thumbLiClass = function(ind){
        if ((ind % 3) == 0)
            return "brslide";
        else
            return "thimbslide";
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
                $scope.products[i].listposition = {left:"0px"};
            }
            $scope.checkingOut = false;
            $scope.inRequest = false;
        }).error(function(error){
                alert(error);
        });
        angular.element('body').removeClass('overflow-h');
        angular.element('.m-cover-preload').fadeOut(600);
    };

    var IMAGE_WIDTH = 242;    
        
    $scope.scrollTo = function(image,ind, jsID) {
        $scope.products[jsID].listposition = {left:(IMAGE_WIDTH * ind * -1) + "px"};
    };        
    
    $scope.emptyClass = function() {
        if ($scope.products.length > 0) {
            return "hide";
        } else {
            return "";
        }
    };
    
    $scope.sizeClass = function(selectedSize, size) {
        if (selectedSize === size) {
            return "active";
        } else {
            return "";
        }
    };
    
    $scope.colorClass = function(selectedColor, color) {
        if (selectedColor === color) {
            return "active";
        } else {
            return "";
        }
    };

    $scope.surfaceClass = function(selectedSurface, surface) {
        if (selectedSurface === surface) {
            return "active";
        } else {
            return "";
        }
    };    
    
    $scope.deliveryClass = function(jsID){
        if ($scope.deliveries[jsID].id == $scope.selectedDelivery.id)
            return "active";
        else
            return "";
    };

    $scope.paymentClass = function(jsID){
        if ($scope.payments[jsID].id == $scope.selectedPayment.id)
            return "active";
        else
            return "";
    };
    
    $scope.chekingOutClass = function(){
        if(!$scope.checkingOut){
            return "hide";
        } else {
            return "";
        }
    };
    
    $scope.setSize = function(jsID, size){
        $scope.summ -= parseFloat($scope.products[jsID].selectedSize.price)*$scope.products[jsID].quantity;
        $scope.products[jsID].selectedSize = size;
        $scope.summ += parseFloat($scope.products[jsID].selectedSize.price)*$scope.products[jsID].quantity;;
    };
    
    $scope.setColor = function(jsID, color){
        $scope.products[jsID].selectedColor = color;
    };

    $scope.setSurface = function(jsID, surface){
        $scope.products[jsID].selectedSurface = surface;
    };
    
    $scope.setDelivery = function(jsID){
        $scope.selectedDelivery = $scope.deliveries[jsID];
    };
    
    $scope.setPayment = function(jsID){
        $scope.selectedPayment = $scope.payments[jsID];
    };
    
    $scope.changeQuantity = function(){
        $scope.summ = 0;
        for (var i = 0; i < $scope.products.length; i++) {
            if($scope.products[i].quantity < 0)
                $scope.products[i].quantity = 0;
            $scope.summ += parseFloat($scope.products[i].selectedSize.price)*$scope.products[i].quantity;
        }
    };
    
    $scope.checkOut = function(){
        if(!$scope.checkingOut){
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
            $scope.checkingOut = true;
        }

    };

    $scope.deleteItem = function(jsID){
        if(!$scope.inRequest){
            $scope.inRequest = true;
            $http.post(('/store/product/DeleteFromCart'), {
                token: $scope.token,
                id : $scope.products[jsID].id,
                quantity : $scope.products[jsID].quantity,
                selectedColor : $scope.products[jsID].selectedColor,
                selectedSurface : $scope.products[jsID].selectedSurface,
                selectedSize : $scope.products[jsID].selectedSize    
            }).success(function(data, status) {
                if (data.error == 'no'){
                    $scope.products.splice(jsID, 1);
                    $scope.summ = 0;
                    for (var i = 0; i < $scope.products.length; i++){
                        $scope.products[i].jsID = i;                    
                        $scope.summ += parseFloat($scope.products[i].selectedSize.price)*$scope.products[i].quantity;
                    }
                    
                    if(!($scope.products.length > 0)){
                        window.location = "/store";
                    }                    
                }else
                    alert(data.error);
            }).error(function(error){
                    alert(error);
            });
            $scope.inRequest = false;
        }
    };
    
    $scope.saveCustomer = function(){
        if(!$scope.inRequest){
            $scope.inRequest = true;

            $http.post(('/store/product/SaveCustomer'), {
                token: $scope.token,
                customer : $scope.customer
            }).success(function(data, status) {
                if (data.error == 'no')
                    document.getElementById('proceedFinish').click();
                else
                    alert(data.error);
            }).error(function(error){
                    alert(error);
            });        

            $scope.inRequest = false;
        }
    };
    
    $scope.buy = function(){
        $http.post(('/store/product/Buy'), {
            token: $scope.token,
            customer : $scope.customer,
            products : $scope.products,
            delivery : $scope.selectedDelivery,
            payment     : $scope.selectedPayment
        }).success(function(data, status) {
            if (data.error == 'no')
                alert('Message sent!');
            else
                alert('Action error:' + data.error);
        }).error(function(error){
                alert('Connection error: '+ error);
        });        
    };
    
    $scope.thumbClass = function(len){
        if (len > 3)
            return "thumbswrapper xscrolled";
        else
            return "thumbswrapper";
    }    
    
    $scope.thumbLiClass = function(ind){
        if ((ind % 3) == 0)
            return "brslide";
        else
            return "thimbslide";
    }        
    
    
    $scope.valClass = function(isValid){
        if(isValid)
            return "";
        else
            return "error";
    }
    
}
