'use strict';

function $id(id) {
  return document.getElementById(id);
}

function UserCtrl($scope, $http, $compile, $timeout) {
  $scope.$watch('user.email + user.password', function(user) {

    if ($scope.user && $scope.user.email && $scope.user.password) {
      angular.element('#sign-in .form-control a').removeClass('button-disable');
    }
  });

  //Авторизация
  $scope.login = function(user) {
    if (!user.email || !user.password) return false;
    $http.post('/service/login', user).success(function(data) {
      if(data.error == 'login_error_count') {
        $http.post('/ajax/getBlock', {content:'sign_captcha_form'}).success(function(data)       {
          if(data.error == 'no') {
            var form = $compile(data.content)($scope);
            $http.post('/ajax/getBlock', {content:'captcha'}).success(function(data)           {
              if(data.error == 'no') {
                angular.element('#signInForm').html(form);
                angular.element('#signInForm .captcha').html($compile(data.content)($scope));
              }
            });
          }
        });
      }
      else if (data.error == 'yes') {
        angular.element('#sign-in input[name=email]').addClass('error');
        angular.element('#sign-in input[name=password]').addClass('error');
      }
      else {
        $(location).attr('href','/user/personal');
      }
    });
  };

  $scope.initTimer = function(period){
    $http.post('/store/product/GetItemsInCart',{token: $scope.user.token}).success(function(data) {
      $scope.itemsInCart = data.itemsInCart;
    }).error(function(error){
      $scope.itemsInCart = 0;
    });
	if(period == 1000)
		var mytimeout = $timeout($scope.onFastTimeout, 1000);
	else
		var mytimeout = $timeout($scope.onTimeout, 10000);
  };

  $scope.onTimeout = function(){
    $http.post('/store/product/GetItemsInCart',{token: $scope.user.token}).success(function(data) {
      $scope.itemsInCart = data.itemsInCart;
    });

    var mytimeout = $timeout($scope.onTimeout, 10000);
  };

  $scope.onFastTimeout = function(){
    $http.post('/store/product/GetItemsInCart',{token: $scope.user.token}).success(function(data) {
      $scope.itemsInCart = data.itemsInCart;
    });

    var mytimeout = $timeout($scope.onFastTimeout, 1000);
  };

}

function HelpCtrl($scope, $http, $compile) {

  $scope.$watch('user.email + user.fName + user.question', function(user) {
    if ($scope.user.fName && $scope.user.email && $scope.user.question) {
      angular.element('#help-in .form-control a').removeClass('button-disable');
    }
  });


  $scope.send=function(user){
    $http.post('/ajax/sendQuestion', user).success(function(data) {
      if(data.error == 'no') {
        console.log(1);
      }
    });
  };
}

function SpotCtrl($scope, $http, $compile) {
   $scope.maxSize = 25*1024*1024;
   $scope.progress = 0;

  function output(msg) {
    var m = $id("messages");
    m.innerHTML = msg + m.innerHTML;
  }

  function fileDragHover(e) {
    e.stopPropagation();
    e.preventDefault();
    // angular.element('#dropbox').toggleClass(e.type == "dragover" ? "dropbox-hover" : "");
  }

  function fileSelectHandler(e) {
    fileDragHover(e);
    var files = e.target.files || e.dataTransfer.files;

    for (var i = 0, f; f = files[i]; i++) {
      $scope.uploadFile(f);
      // $scope.parseFile(f);
    }
  }

  function uploadProgress(evt) {
    $scope.$apply(function(){
      if (evt.lengthComputable) {
        $scope.progress = Math.round(evt.loaded * 100 / evt.total)
      } else {
        $scope.progress = 'unable to compute'
      }
    })
  }

  $scope.uploadComplete = function(e) {
    var result = e.target.responseText;
    if (result){
      var data = angular.fromJson(result);
      if(data.error == 'no') {
        var content = angular.element('#add-content');
        content.hide().before($compile(data.content)($scope));
      }
    }
  }

  function uploadProgress(evt) {
    $scope.$apply(function(){
      if (evt.lengthComputable) {
          $scope.progress = Math.round(evt.loaded * 100 / evt.total)
      } else {
          $scope.progress = 'unable to compute'
      }
    })
  }

  $scope.uploadFailed = function(e) {
    angular.element('#error-upload').show().delay(800).slideUp('slow');
  }

  $scope.uploadFile = function(file) {

    var xhr = new XMLHttpRequest();
    if (xhr.upload && file.size <= $scope.maxSize) {
      angular.element('#add-content').show();

      xhr.upload.onprogress = function(e) {
        if (e.lengthComputable) {
          $scope.progress = Math.round(e.loaded * 100 / e.total)
        } else {
          $scope.progress = 'unable to compute'
        }
      };

      xhr.upload.addEventListener("progress", uploadProgress, false)
      xhr.addEventListener("error", $scope.uploadFailed, false)
      xhr.addEventListener("load", $scope.uploadComplete, false)
      xhr.open("POST", "/spot/upload", true);
      xhr.setRequestHeader("X-File-Name", file.name);
      xhr.setRequestHeader("X-Discodes", $scope.spot.discodes);
      xhr.send(file);
    }
  }

  $scope.getVcard=function(spot){
    if (spot.vcard == 1) spot.vcard = 0;
    else spot.vcard = 1;
    $scope.setAttribute(spot);
  };

  $scope.getPrivate=function(spot) {
    if (spot.private == 1) spot.private = 0;
    else spot.private = 1;
    $scope.setAttribute(spot);
  };

  $scope.setAttribute=function(spot) {
    $http.post('/spot/spotAtributeSave', $scope.spot).success(function(data)           {
        if(data.error == 'no') {

        }
      });
  };

  $scope.accordion = function(e, token) {
    var spot = angular.element(e.currentTarget).parent();
    var discodes = spot.attr('id');
    var spotContent = spot.find('.spot-content');
    var spotHat = spot.find('.spot-hat');
    if (spotContent.attr('class') == null) {
      $http.post('/spot/spotView', {discodes:discodes, token:token}).success(function(data) {
          if(data.error == 'no') {
            var oldSpotContent = angular.element('.spot-content');
            angular.element('.spot-content_li').removeClass('open');
            oldSpotContent.slideUp('slow', function () {
              oldSpotContent.remove();
            });

            spotHat.after($compile(data.content)($scope));
            spot.find('.spot-content').slideToggle('slow', function () {
              spot.addClass('open');
            });

            $scope.spot.content='';

            var filedrag = $id('dropbox');
            if (filedrag) {
              var xhr = new XMLHttpRequest();
              if (xhr.upload) {
                filedrag.addEventListener("dragover", fileDragHover, false);
                filedrag.addEventListener("dragleave", fileDragHover, false);
                filedrag.addEventListener("drop", fileSelectHandler, false);
              }
            }
          }
      });
    }
    else {
      spot.removeClass('open');
      spotContent.slideUp('slow',
        function () {
          spotContent.prev().remove();
          spotContent.remove();
        });
    }
  }

  $scope.saveSpot=function(spot) {
    if (spot.content && spot.user) {
      $http.post('/spot/spotSave', spot).success(function(data) {
        if(data.error == 'no') {
          angular.element('#add-content').before($compile(data.content)($scope));
          spot.content='';
        }
      });
    }
  };

  $scope.removeContent=function(spot, key, e) {
    spot.key = key;
    $http.post('/spot/spotRemoveContent', spot).success(function(data) {
      if(data.error == 'no') {
        var spotItem = angular.element(e.currentTarget).parent().parent().parent();
        spotItem.remove();
      }
    });
  };

  $scope.editContent=function(spot, key) {
     spot.key = key;
    $http.post('/spot/spotEditContent', spot).success(function(data) {
      if(data.error == 'no') {

      }
    });
  };
}


function WalletCtrl($scope, $http, $timeout){
	$scope.ready = false;
	$scope.WalletInit = function(token){
			$scope.token = token;
			$http.post('/wallet/GetWallet', {token : $scope.token}).success(function(data) {
				$scope.wallet = data.wallet;
				$scope.history = data.history;
			}).error(function(error){
					alert(error);
			});
	};
	
	$scope.addByUniteller = function(){
		$scope.ready = false;
		$scope.tries = 0;
		
		$http.post('/wallet/GetUnitellerOrder', {token : $scope.token, newSumm: $scope.newSumm}).success(function(data) {
			$scope.order = data.order;
			$scope.ready = true;
		}).error(function(error){
			alert(error);
		});	
		
		var mytimeout = $timeout($scope.onTimeout, 100);
	}
	
	$scope.onTimeout = function(){
		if ($scope.ready && ($scope.order.idShop !== undefined)){
			document.getElementById('submitUnitell').click();
		}
		else if($scope.tries < 100){
			$scope.tries++;
			var mytimeout = $timeout($scope.onTimeout, 100);
		}
	};	

}


