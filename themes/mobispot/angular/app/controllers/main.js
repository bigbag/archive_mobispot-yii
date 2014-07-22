function mainCtrl($scope, $timeout) {


	$scope.showInfo = function(){
		$scope.stop();
		$('#overlay-info').addClass('show');
	}
	
	//Spot Tabs [Spot list / Wallet / Coupons]
	
	$scope.speed = 400;
	$scope.spotBlock = function(e, v){
		var $element = $(e.currentTarget);
		if(!$element.hasClass('active')){
			$element.addClass('active').siblings().removeClass('active');
			
			var type = $element.parent();
			if($(type).hasClass('spot-tabs')){
				var $tabsBlock = $element.parents('.spot-wrapper');
				var spotBlock = $tabsBlock.find('section.'+v);
			} else {
				var spotBlock = $('#'+v);
			}

			var blockSublings = spotBlock.siblings();

			blockSublings.stop().animate({
				opacity: 0
			},$scope.speed/2,function(){
				blockSublings.removeClass('active');
				spotBlock.addClass('active').animate({
					opacity: 1
				},$scope.speed)
			});
		}
	}

	//Spot Tabs end

	//Spot textarea focus

	$scope.inputFocus = function(){
		$('textarea','.spot-main-input').focus();
	}

	//Spot textarea focus end

//Spot info

	$scope.infoShow = function(e){
		if($scope.info){
			$scope.info = '';
		} else{
			$scope.info='show-info';
		}
	}
	$scope.escDown = function(e){
		if(e.keyCode === 27) {
			$scope.info = '';
			$scope.closePop();
			$('#overlay-info').removeClass('show');
		};
	}
	//Spot info end

// Spot AutoPay
$scope.autoPayOn = function(){
	var $autoPayAgree = $('#autoPayAgree');

	if($autoPayAgree.hasClass('active')){
		$scope.conditionAutoP='active';
	} else {
		$autoPayAgree.addClass('error');
		setTimeout(function() { $autoPayAgree.removeClass('error')}, 600);
	};
};
//Spot AutoPay end


// Bloked Wallet

$scope.blockedWallet = function(){
	var $wallet = $('#setPayment');
	$wallet.toggleClass('disable');
};
// Bloked Wallet end

// Spot visible/invisible
$scope.visibleSpot = function(){
	$('.spot-wrapper.active, .spot-list li.active', '.content-block').toggleClass('invisible');
}
// Spot visible/invisible end

// Spot open settings 

$scope.openSetting = function(spot){
	var spotId = '#'+spot;
	$('.spot-content_row', spotId).removeClass('active');
	$('.settings-block', spotId).addClass('active').animate({
					opacity: 1
				},$scope.speed);
	$('.spot-tabs a', spotId).removeClass('active');
	$('.settings', spotId).addClass('active');
}

	$scope.openVisibleSetting = function(spot){
		$scope.openSetting(spot);
		
		var $settingBlock = $('.toggle-visible');
		var srrollTop = $settingBlock.offset().top - 22;
		$('html, body').animate({
				scrollTop: srrollTop
			}, $scope.speed);

		$settingBlock.addClass('wink');
		setTimeout(function() { $settingBlock.removeClass('wink')}, 1200);
	}

// Spot open settings end


// Spot show popup
	$scope.showPop = function(popId){
		var $popup = $('#'+popId);
		$popup.animate({
			opacity: 1,
			zIndex: 999
		}, $scope.speed);
	};
// Spot show popup end

// Spot close popup
	$scope.closePop = function(){
		var $popup = $('.popup');
		$popup.animate({
			opacity: 0,
			zIndex: -10
		}, $scope.speed, function(){
			$scope.stop()
		});
	};
// Spot close popup end


$scope.editCardList = function(){
	$('#setPayment').toggleClass('edit');
	
}

$scope.spotMinHeight = function(){
	var listHeight = $('.spot-list').height();
	$('.spot-content').css('min-height', listHeight+20);
}

$scope.dkitForm = function(e, index){
	index = --index;
	
	var $tabItem = $('.tab-item');
	var $tabLink = $('li','.get-up-nav');
	$tabItem.removeClass('active');
	$tabLink.removeClass('active');
	$($tabItem[index]).addClass('active');
	$($tabLink[index]).addClass('active');

}

$scope.makeMainCard = function(e){
	var $element = $(e.currentTarget);
	$element.parents('.table-card').find('tr').removeClass('main-card');
	$element.parents('tr').addClass('main-card');
}

$scope.stopProp = function(e){
	e.stopPropagation();
}

var counterBase = 60, stopped;
$scope.counter = counterBase;

$scope.countdown = function() {
		stopped = $timeout(function() {
			$scope.counter--;
			$scope.countdown();
		}, 1000);
	};
		$scope.stop = function(){
			$timeout.cancel(stopped);
			$scope.resetCount();
		}
$scope.resetCount = function(){
	$scope.counter = counterBase;
} 


	$scope.setModal = function(content, type){
		resultModal.removeClass('m-negative');
		if (type == 'error') {
			resultModal.addClass('m-negative');
		}
		resultModal.show();
		resultContent.text(content);
		if($('html').hasClass('no-opacity')){
			setTimeout(function(){resultModal.hide}, 8000);
		} else {
			resultModal.fadeOut(8000);
		}
	};



	$scope.closeHint = function(e){
		var hintClose = e.currentTarget;
		var hint = $(hintClose).parent();

		if($(hint).hasClass('bottom')){
			var hintHW = $(hint).outerHeight();
			var or = 'bottom';

		}
		else if ($(hint).hasClass('left')) {
			var hintHW = $(hint).outerWidth();
			var or = 'left';
		}
		else {
			var hintHW = $(hint).outerWidth();
			var or = 'right';
		}

		var anim_styles = {opacity: 0};
		anim_styles[or] = -hintHW;



		$(hint).animate(anim_styles, 600, function(){
			$(hint).addClass('hide');
		});

	};

	$scope.showHint = function(e){

		var callHint = e.currentTarget;
		var hint = $(callHint).attr('href');

		if( $(hint).hasClass('hide')){

			if($(hint).hasClass('bottom')){
				var hintHW = $(hint).outerHeight();
				var or = 'bottom';
			}
			else if ($(hint).hasClass('left')) {
				var hintHW = $(hint).outerWidth();
				var or = 'left';
				var middle = hintHW / 2;
			}
			else {
				var hintHW = $(hint).outerWidth();
				var or = 'right';
				var middle = hintHW / 2;
			}

			var hint_styles = {};
			hint_styles[or] = -hintHW;
			if(middle){
				var mTop = 'margin-top';
				hint_styles[mTop] = -middle;
			}
			$(hint).removeClass('hide').css(hint_styles);

			var anim_styles = {opacity: 1};
			anim_styles[or] = 0;

			$(hint).animate(anim_styles, 600);



		}



	}

	var resultModal = angular.element('.m-result');
	var resultContent = resultModal.find('p');

		$scope.tiktak;
		$scope.myValue = 1;
		$scope.number = '';

		$scope.acceptNumber = function(){
			$scope.myValue = 0;
		}
		$scope.resetNumber = function(){
			$scope.myValue = 1;
		}

}