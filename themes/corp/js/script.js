var $body = $('body');
var $popup = $('.popup');
var $element = new Object();

var toggleOpen = function (element) {
	$(element).toggleClass('open');
};

var addActive = function () {
	if(!$(this).hasClass('no-active')){
		$(this).addClass('active').siblings().removeClass('active');
	};
};
var toggleActive = function () {
	if(!$(this).hasClass('active-sub')){
		$(this).toggleClass('active');
	}
};


var calculateHeightPage = function(){
	var winHeight = $(window).height();
	var docHeight =  $(document).height();
	if(docHeight > winHeight ){
			return true;
	} else {
		return false;

	}
}


var showPopup = function(){

	$element.showPopupButton = $(this);
	var popupId =  'popup-' + $(this).attr('id');
	$popup.removeClass('hide').attr('id', popupId).animate({opacity: 1}, 50, function(){
		$body.addClass('overflow-h');
		if(calculateHeightPage() && scrollWidth){
			$body.css('padding-right', scrollWidth);
		} else {
			$popup.css('padding-left', scrollWidth);
		}
	});
	return false;

};
var hidePopup = function(){
	if ($element.showPopupButton){
		$element.showPopupButton.removeClass('active');
		$popup.animate({opacity: 0}, 200, function(){
			$(this).addClass('hide');
			$body.removeClass('overflow-h').css('padding-right', '0');
			$popup.css('padding-left', '0');
		});

	}
};


var div = document.createElement('div');
div.style.overflowY = 'scroll';
div.style.width =  '50px';
div.style.height = '50px';
div.style.visibility = 'hidden';
document.body.appendChild(div);
var scrollWidth = div.offsetWidth - div.clientWidth;
document.body.removeChild(div);


var $iconBag = $('.icon-bag-link');
var $win = $(window);
var $marker = $('.bag-link');
var markerHeight =  $('.bag-link').height();
var markerHeight = markerHeight / 2;

var showHideBagIcon = function(speed){
	if ($win.scrollTop() + $win.height() - markerHeight >= $marker.offset().top) {
		$iconBag.fadeOut(speed)
	} else {
		$iconBag.fadeIn(speed)
	}
}

$(window).load(function() {
	$(document).on('click','.add-active > *', addActive);
	$(document).on('click','.toggle-active > *', toggleActive);
	$(document).on('click','.store-items__close', function(){
		$(this).parents('tr').remove();
	});



	$('.settings-button').on('click', showPopup);
	$('.popup-button').on('click', showPopup);
	$('.button', '.popup').on('click', hidePopup);
	$('.popup').on('click', function(event) {
		if ($(event.target).closest('.popup-form').length) return;

		hidePopup();

		event.stopPropagation();
	});

	$(document).on('click','.popup-content', function(event){
		event.stopPropagation();
	});

	$('.spot-list').on('click','.settings-button', showPopup);
	$('.spot-list').on('click','.button', hidePopup);
	$('.spot-list').on('click','.popup', hidePopup);

	$(document).keydown(function(e){
		if(e.which == 27){
			$popup.hasClass('hide')||hidePopup();
		}
	});

	var textArea = $('textarea');

	for(i=0; i<textArea.length; i++){
		if ( $(textArea[i]).val() ){
			$(textArea[i]).addClass('put')
		} else{
			$(textArea[i]).removeClass('put');
		}

	}
	$('.spot-list').on('input propertychange','textarea', function() {
		if($(this).val()){
			$(this).addClass('put');
		}else{
			$(this).removeClass('put');
		}

	});

	$(document).on('click', '.b-input-number span', function(e){
		var $numberInput = $(this).parent().find('input')
		var currentNumber = $numberInput.val();
			if($(this).hasClass('number-up')){
				!currentNumber?currentNumber = 1 : currentNumber++;
			} else{
				currentNumber < 1 ?currentNumber = 0 : currentNumber--;
			}
		$numberInput.val(currentNumber);
	});

	var $socMediaIcon = $('.spot-sub-slide a');
	$socMediaIcon.hover(function(){
		$socMediaIcon.not(this).stop().animate({opacity: 0.4}, 500);
	} , function(){
		$socMediaIcon.stop().animate({opacity: 1}, 500);
	});

});

