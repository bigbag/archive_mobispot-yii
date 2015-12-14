'use strict';

angular.module('mobispot').controller('ProductController',
  function($scope, $http, $compile, $timeout, contentService) {
    
    $scope.host_type = 'desktop';
    $scope.transport_card = {};
    $scope.simple_card = {};
    $scope.transport_types = [];
    $scope.prev_custom_card = {};
      
    $scope.StoreInit = function(){
            var data = {token: $scope.user.token};

            $http.post('/store/product/getPriceList', data).success(function(data) {
                $scope.products = data.products;
                $scope.settings = data.settings;

                for (var i = 0; i < $scope.products.length; i++) {
                    $scope.products[i].jsID = i;
                    $scope.products[i].selectedSize = $scope.products[i].size[0];
                    $scope.products[i].selectedColor = $scope.products[i].color[0];
                    $scope.products[i].selectedSurface = $scope.products[i].surface[0];
                    $scope.products[i].quantity = 1;
                    $scope.products[i].listposition = {left:"0px"};
                    $scope.products[i].addText = $scope.settings.addToCart;

                    if (typeof $scope.products[i].selectedColor != 'undefined' && typeof $scope.products[i].photo != 'undefined' && $scope.products[i].photo.length > 0)
                    {
                        var suffix = '_' + $scope.products[i].selectedColor;
                        for (var j = 0; j < $scope.products[i].photo.length; j++)
                        {
                            var name = $scope.products[i].photo[j].substring(0, $scope.products[i].photo[j].lastIndexOf('.'));
                            if (name.substr(name.length - suffix.length) == suffix)
                            {
                                $scope.products[i].listposition = {left:(IMAGE_WIDTH * j * -1) + "px"};
                                break;
                            }
                        }
                    }
                    /*
                    var tsTop = 90;
                    if ($scope.products[i].color.length > 0)
                        tsTop += 155;
                    if ($scope.products[i].photo.length > 3)
                        tsTop -= 56;
                    if ($scope.products[i].description.length > 0)
                        tsTop += ($scope.products[i].description.length/76.5) * 10;
                    $scope.products[i].thumbShellStyle = {top:(tsTop+"px")};
                    */
                }
                $scope.inRequest = false;
            });

            angular.element('body').removeClass('overflow-h');
            angular.element('.m-cover-preload').fadeOut(600);
    };

    var IMAGE_WIDTH = 242;

    $scope.scrollTo = function(image,ind, jsID) {
        $scope.products[jsID].listposition = {left:(IMAGE_WIDTH * ind * -1) + "px"};
    };

    $scope.addToCart = function addToCart(jsID){
        if($scope.products[jsID].quantity < 1) return false;
        
        if($scope.inRequest) return false;

        if ('troika' == $scope.products[jsID].type) {
          $scope.showConstructorTroika($scope.products[jsID], jsID);
          return false;
        }
        
        if ('simple' == $scope.products[jsID].type) {
          $scope.showConstructorSimple($scope.products[jsID], jsID);
          return false;
        }
            
        $scope.inRequest = true;        
        var data = {
            token: $scope.user.token,
            id : $scope.products[jsID].id,
            quantity : parseInt($scope.products[jsID].quantity),
            selectedColor : $scope.products[jsID].selectedColor,
            selectedSurface : $scope.products[jsID].selectedSurface,
            selectedSize : $scope.products[jsID].selectedSize
        };
        $http.post(('/store/product/addToCart'), data).success(function(data, status){
            if(data.error == 'no'){
                $scope.products[jsID].addText = $scope.settings.added;
                $scope.items.count += parseInt($scope.products[jsID].quantity);
                var basket = angular.element('a.icon-bag-link span');
                basket.text($scope.items.count);
            }
            $scope.inRequest = false;
        }).error(function(error){$scope.inRequest = false;});
    };
    
    
  $scope.addTransportCard = function(transport_card) {
     transport_card.token = $scope.user.token;
     $http.post(('/store/product/addCustomCard'), transport_card).success(function(data){
          if (data.error == 'no'){
            if (!angular.isUndefined($scope.transportId))
                $scope.products[$scope.transportId].addText = $scope.settings.added;
            $scope.items.count += 1;
            var basket = angular.element('a.icon-bag-link span');
            basket.text($scope.items.count);
          }
      });
  
    $scope.hideConstructorTroika();
  }
  
  $scope.addSimpleCard = function(simple_card) {
     $http.post(('/store/product/addCustomCard'), simple_card).success(function(data){
          if (data.error == 'no'){
            if (!angular.isUndefined($scope.simpleId))
                $scope.products[$scope.simpleId].addText = $scope.settings.added;
            $scope.items.count += 1;
            var basket = angular.element('a.icon-bag-link span');
            basket.text($scope.items.count);
          }
      });
  
    $scope.hideConstructorSimple();
  }
  
  //тригер на снятие ошибки для макета транспортной карты
  $scope.$watch('transport_card.shipping_name + transport_card.phone + transport_card.address + transport_card.city + transport_card.zip + transport_card.email', function() {
      $scope.error.transport_card = false;
  });
  
  //заказ тройки с отдельной страницы
  $scope.mailTroikaCard = function(transport_card, valid, message_text) {
    if (!valid) {
      $scope.error.transport_card = true;
      return false;
    }

    $http.post('/store/product/mailTroikaCard', transport_card).success(function(data) {
        if ('no' == data.error) {
          contentService.messageModal(message_text, $scope.host_type);
          setTimeout(function(){
            location.reload();
          }, 2000);
        } else {
          $scope.error.transport_card = true;
        }
    });
  }
 
 
  //Отображение кастомного макета транспотрной карты
  $scope.showConstructorTroika = function(product, jsID) {
    $scope.transport_card.id = product.id;
    $scope.transportId = jsID;
    $('#constructor-troika').addClass('show');
    $('body').css('overflow', 'hidden');
  }
  
  $scope.hideConstructorTroika = function() {
    $('#constructor-troika').removeClass('show');
    $('body').css('overflow', '');
  }
  
  //Отображение кастомного макета
  $scope.showConstructorSimple = function(product, jsID){
    $scope.simple_card.id = product.id;
    $scope.simpleId = jsID;
    $('#constructor-simple').addClass('show');
    $('body').css('overflow', 'hidden');
  }
  
  $scope.hideConstructorSimple = function() {
    $('#constructor-simple').removeClass('show');
    $('body').css('overflow', '');
  }
  
  $scope.initTransportType = function(type_id, type_name, type_img) {
    $scope.transport_types[$scope.transport_types.length] = {id:type_id, name:type_name, img:type_img};
  };
  
  $scope.showCardPattern = function() {
    angular.element('#card-menu').hide();
    angular.element('#card-pattern').show();
  }
  
  $scope.hideCardPattern = function() {
    angular.element('#card-menu').show();
    angular.element('#card-pattern').hide();
    
    $scope.clearFormImg('#form-photo');
    $scope.clearFormImg('#form-logo');
    
    delete($scope.transport_card.name);
    delete($scope.transport_card.position);
    delete($scope.transport_card.photo);
    delete($scope.transport_card.logo);
  }
  
  $scope.clearFormImg = function(form_selector)
  {
    var form = angular.element(form_selector);
    var form_label = form.find('label.face-holder');
    var img_crop = form.find('.ng-image-crop');
    var div_upload = form.find('.upload-photo');
    
    form_label.removeClass('hide');
    img_crop.addClass('hide');
    if (div_upload.length)
        div_upload.removeClass('noborder');
  }
  
  //Выбор задника транспортной карты
  $scope.setType = function(type) {
    $scope.transport_card.back = type.id;

    if (type.img){
      $('#card-back').css('background-image', 'url(/uploads/transport/' + type.img + ')');
    }
  }

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

    $scope.setSize = function(jsID, size){
        $scope.products[jsID].selectedSize = size;
        $scope.products[jsID].addText = $scope.settings.addToCart;
    };

    $scope.setColor = function(jsID, color){
        $scope.products[jsID].selectedColor = color;
        $scope.products[jsID].addText = $scope.settings.addToCart;

        if (typeof $scope.products[jsID].photo != 'undefined' && $scope.products[jsID].photo.length > 0){
            var suffix = '_' + color;
            for (var i = 0; i < $scope.products[jsID].photo.length; i++)
            {
                var name = $scope.products[jsID].photo[i].substring(0, $scope.products[jsID].photo[i].lastIndexOf('.'));
                if (name.substr(name.length - suffix.length) == suffix)
                {
                    $scope.products[jsID].listposition = {left:(IMAGE_WIDTH * i * -1) + "px"};
                    break;
                }
            }
        }
    };

    $scope.setSurface = function(jsID, surface){
        $scope.products[jsID].selectedSurface = surface;
        $scope.products[jsID].addText = $scope.settings.addToCart;
    };

    $scope.resetAddedText = function(jsID){
        $scope.products[jsID].addText = $scope.settings.addToCart;
        if($scope.products[jsID].quantity < 0){
            $scope.products[jsID].quantity = 0;
        }
    };

    $scope.thumbClass = function(len){
        if (len > 3)
            return "thumbswrapper xscrolled";
        else
            return "thumbswrapper";
    };
/*
    $scope.thumbLiClass = function(ind){
        if ((ind % 3) == 0)
            return "brslide";
        else
            return "thimbslide";
    }
*/
});


angular.module('mobispot').controller('CartController',
  function($scope, $http, $compile, $timeout, contentService) {
    $scope.promoError = false;
    $scope.customerError = false;
  
    $scope.CartInit = function(){
        $scope.summ = 0;
        var data = {token: $scope.user.token};

        $http.post('/store/product/GetCart', data).success(function(data) {
            $scope.products = data.products;
            $scope.discount = data.discount;
            if($scope.products.length <= 0){
               window.location = "/store";
            }
            for (var i = 0; i < $scope.products.length; i++) {
                $scope.products[i].jsID = i;
                $scope.products[i].quantity = parseInt($scope.products[i].quantity);
                $scope.summ += parseFloat($scope.products[i].selectedSize.price)*$scope.products[i].quantity;
                $scope.products[i].listposition = {left:"0px"};
                if (typeof $scope.products[i].selectedColor != 'undefined' && typeof $scope.products[i].photo != 'undefined' && $scope.products[i].photo.length > 0)
                {
                    var suffix = '_' + $scope.products[i].selectedColor;
                    for (var j = 0; j < $scope.products[i].photo.length; j++)
                    {
                        var name = $scope.products[i].photo[j].substring(0, $scope.products[i].photo[j].lastIndexOf('.'));
                        if (name.substr(name.length - suffix.length) == suffix)
                        {
                            $scope.products[i].listposition = {left:(IMAGE_WIDTH * j * -1) + "px"};
                            break;
                        }
                    }
                }
            }

            if ($scope.discount.products){
                if ($scope.discount.products.length > 0){
                    $scope.discount.summ = 0;
                    for (var i = 0; i < $scope.products.length; i++) {
                        for (var j = 0; j < $scope.discount.products.length; j++) {
                            if ($scope.products[i].id == $scope.discount.products[j].id_product){
                                $scope.discount.summ += $scope.discount.products[j].discount*parseInt($scope.products[i].quantity);
                                break;
                            }
                        }
                    }
                    if ($scope.discount.summ > 0)
                        $scope.summ -= $scope.discount.summ;
                }
            }

            $scope.checkingOut = false;
            $scope.inRequest = false;
        });

        angular.element('body').removeClass('overflow-h');
        angular.element('.m-cover-preload').fadeOut(600);
    };

    var IMAGE_WIDTH = 242;

    $scope.scrollTo = function(image,ind, jsID) {
        $scope.products[jsID].listposition = {left:(IMAGE_WIDTH * ind * -1) + "px"};
    };

    $scope.emptyClass = function() {
        if ($scope.products){
            if ($scope.products.length > 0) {
                return "hide";
            } else {
                return "";
            }
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
        $scope.summ += parseFloat($scope.products[jsID].selectedSize.price)*$scope.products[jsID].quantity;
    };

    $scope.setColor = function(jsID, color){
        var oldProduct = {id:$scope.products[jsID].id, quantity:$scope.products[jsID].quantity, selectedColor:$scope.products[jsID].selectedColor};
        if (typeof ($scope.products[jsID].selectedSize) != 'undefined')
            oldProduct.selectedSize = $scope.products[jsID].selectedSize;
        if (typeof ($scope.products[jsID].selectedSurface) != 'undefined')
            oldProduct.selectedSurface = $scope.products[jsID].selectedSurface;

        $scope.products[jsID].selectedColor = color;

        if (typeof $scope.products[jsID].photo != 'undefined' && $scope.products[jsID].photo.length > 0){
            var suffix = '_' + color;
            for (var i = 0; i < $scope.products[jsID].photo.length; i++)
            {
                var name = $scope.products[jsID].photo[i].substring(0, $scope.products[jsID].photo[i].lastIndexOf('.'));
                if (name.substr(name.length - suffix.length) == suffix)
                {
                    $scope.products[jsID].listposition = {left:(IMAGE_WIDTH * i * -1) + "px"};
                    break;
                }
            }
        }

        var data = {token: $scope.user.token, oldProduct:oldProduct, newProduct:$scope.products[jsID]};
        $http.post('/store/product/SaveProduct', data).success(function(data) {
            if (data.error != 'no'){
            }
        });
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

    $scope.changeQuantity = function(jsID){
        if (parseInt($scope.products[jsID].quantity) <= 0)
        {
            $scope.deleteItem(jsID);
        }
        else
        {
            $scope.summ = 0;
            for (var i = 0; i < $scope.products.length; i++) {
                $scope.summ += parseFloat($scope.products[i].selectedSize.price)*$scope.products[i].quantity;
            }

            if (typeof $scope.discount.products != 'undefined' && $scope.discount.products.length > 0){
                $scope.discount.summ = 0;
                for (var i = 0; i < $scope.products.length; i++) {
                    for (var j = 0; j < $scope.discount.products.length; j++) {
                        if ($scope.products[i].id == $scope.discount.products[j].id_product){
                            $scope.discount.summ += $scope.discount.products[j].discount*parseInt($scope.products[i].quantity);
                            break;
                        }
                    }
                }
                if ($scope.discount.summ > 0) {
                    $scope.summ -= $scope.discount.summ;
                }
            }

            var data = {token: $scope.user.token, oldProduct:$scope.products[jsID], newProduct:$scope.products[jsID]};
            $http.post('/store/product/SaveProduct', data).success(function(data) {
                if (data.error != 'no'){

                }
            });
        }
    };

    $scope.checkOut = function(){
        if ($scope.summ === 0) return false;

        if(!$scope.checkingOut){
             var data = {token: $scope.user.token};
            $http.post('/store/product/getCustomer', data).success(function(data) {
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
            });
            $scope.checkingOut = true;
        }
        angular.element('#proceedNextForm').removeClass('hide-content-box');
        $('html, body').animate({
          scrollTop: $('#proceedNextForm').offset().top
        }, 600);
    };

    $scope.deleteItem = function(jsID){
        if(!$scope.inRequest){
            $scope.inRequest = true;
            var data =
                {
                    token: $scope.user.token,
                    id : $scope.products[jsID].id,
                    quantity : $scope.products[jsID].quantity,
                    selectedColor : $scope.products[jsID].selectedColor,
                    selectedSurface : $scope.products[jsID].selectedSurface,
                    selectedSize : $scope.products[jsID].selectedSize
                };

            $http.post(('/store/product/deleteFromCart'), data).success(function(data, status) {
                if (data.error == 'no'){
                    $scope.products.splice(jsID, 1);
                    $scope.summ = 0;
                    for (var i = 0; i < $scope.products.length; i++){
                        $scope.products[i].jsID = i;
                        $scope.summ += parseFloat($scope.products[i].selectedSize.price)*$scope.products[i].quantity;
                    }
                    if ($scope.discount.products) {
                        if ($scope.discount.products.length > 0){
                            $scope.discount.summ = 0;
                            for (var i = 0; i < $scope.products.length; i++) {
                                for (var j = 0; j < $scope.discount.products.length; j++) {
                                    if ($scope.products[i].id == $scope.discount.products[j].id_product){
                                        $scope.discount.summ += $scope.discount.products[j].discount*parseInt($scope.products[i].quantity);
                                        break;
                                    }
                                }
                            }
                            if ($scope.discount.summ > 0){
                                $scope.summ -= $scope.discount.summ;
                            }
                        }
                    }


                    if($scope.products.length <= 0) {
                        window.location = "/store";
                    }
                }
            });
            $scope.inRequest = false;
        }
    };

    $scope.confirmPromo = function() {
        if(!$scope.inRequest) {
            $scope.inRequest = true;

            var data = {token: $scope.user.token, promoCode: $scope.discount.promoCode};
            $http.post(('/store/product/ConfirmPromo'), data).success(function(data, status) {
                if (data.error == 'no') {
                    $scope.promoError = false;
                    var oldDiscount = $scope.discount.summ;
                    $scope.discount = data.discount;
                    if (typeof $scope.discount.products != 'undefined' && $scope.discount.products.length > 0) {
                        $scope.discount.summ = 0;
                        for (var i = 0; i < $scope.products.length; i++) {
                            for (var j = 0; j < $scope.discount.products.length; j++) {
                                if ($scope.products[i].id == $scope.discount.products[j].id_product){
                                    $scope.discount.summ += $scope.discount.products[j].discount*parseInt($scope.products[i].quantity);
                                    break;
                                }
                            }
                        }
                        if ($scope.discount.summ > 0){
                            if (oldDiscount > 0){
                                $scope.summ += parseFloat(oldDiscount);
                            }
                            $scope.summ -= $scope.discount.summ;
                        }
                        else if (oldDiscount > 0){
                            $scope.summ += parseFloat(oldDiscount);
                        }
                    }
                }
                else
                {
                    $scope.promoError = true;
                    if ($scope.discount.summ > 0){
                        $scope.summ += parseFloat($scope.discount.summ);
                        $scope.discount.summ = 0;
                    }
                    $scope.result.message = data.error;
                    contentService.desktopModal('message');
                }
            }).error(function(error){
                $scope.promoError = true;
                if ($scope.discount.summ > 0){
                    $scope.summ += parseFloat($scope.discount.summ);
                    $scope.discount.summ = 0;
                }

            });
        }
        $scope.inRequest = false;
    };
    
    $scope.$watch('discount.promoCode', function()
    {
      $scope.promoError = false;
    });

    $scope.saveCustomer = function(valid) {
        if (!valid ) { 
            $scope.customerError = true;
            $scope.result.message = $scope.customerHint;
            contentService.desktopModal('message');
            return false;
        }
        if ($scope.summ === 0)  return false;

        if(!$scope.inRequest){
            $scope.inRequest = true;

            var data = {token: $scope.user.token, customer: $scope.customer};

            $http.post(('/store/product/saveCustomer'), data).success(function(data, status) {
                if (data.error == 'no'){
                    angular.element('#proceedFinishForm').removeClass('hide-content-box');
                    $('html, body').animate({
                      scrollTop: $('#proceedFinishForm').offset().top
                    }, 600);
                }
                else{
                    $scope.customerError = true;
                    $scope.result.message = data.error;
                    contentService.desktopModal('message');
                }
            });

            $scope.inRequest = false;
        }
    };
    
    $scope.$watch('customer.first_name + customer.last_name + customer.email + customer.target_first_name + customer.target_last_name + customer.phone + customer.address + customer.city + customer.zip + customer.country', function()
    {
      $scope.customerError = false;
    });

    $scope.buy = function(){

        if ($scope.summ === 0) return false;

        var data = {
            token: $scope.user.token,
            customer : $scope.customer,
            products : $scope.products,
            delivery : $scope.selectedDelivery,
            payment  : $scope.selectedPayment,
            discount : $scope.discount
        };
        
        $http.post(('/store/product/buy'), data).success(function(data, status) {
            if (data.error == 'no'){
                if ('email' == data.payment){
                    contentService.messageModal(data.message, $scope.host_type);
                    /*
                    $timeout(function(){
                        window.location = "/store";
                    }, 5000);
                    */
                }
                else {
                  angular.element('#proceedFinishForm').after($compile(data.content)($scope));
                  angular.element('#form-ym-pay').submit();
                }
            }
            else
               contentService.messageModal(data.error, $scope.host_type);
        });
    };

    $scope.thumbClass = function(len){
        if (len > 3)
            return "thumbswrapper xscrolled";
        else
            return "thumbswrapper";
    };

    $scope.valClass = function(isValid){
        if(isValid)
            return "";
        else
            return "error";
    };
});
