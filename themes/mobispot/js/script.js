var $body = $('body');
var $popup = $('.popup');
var $element = new Object();
var toggleOpen = function (element) {
	$(element).toggleClass('open');
};

var addActive = function () {
	$(this).addClass('active').siblings().removeClass('active');
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
//document.body.appendChild(div);
var scrollWidth = div.offsetWidth - div.clientWidth;
//document.body.removeChild(div);


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

var aSpeed = 500;

var closeShowBlock = function(){
			$('.show.active').removeClass('active');
			$('.show-block.active').removeClass('active').fadeOut(aSpeed);
			try {
				startSlide();
			}catch(e) {
				return false;
			}

};
var closeLang = function(){
			$('.lang-list').fadeOut();
			$('.lang').removeClass('open');
};

function windowSize(){
		var winHeight = $(window).height();
		if(winHeight > 680){
				$('.first-screen').height(winHeight);
		}
}

$(window).on('load resize',windowSize);


$(window).load(function() {


	var firstScreenHeight = $('#first-scr').height() - 1;
	$(window).on('scroll', function(){
			var scro = $(this).scrollTop();

			if(scro > firstScreenHeight){
				$('#fp-main-nav').addClass('start');
			}
	});

	$('#first-scr').addClass('show-fs');
	$('.main').addClass('show-fs');

	$(".info-buttom, .nav-link").click(function() {
		var link = '#' + $(this).attr('href');
    $('html, body').animate({
        scrollTop: $(link).offset().top
    }, 400);
});

	var hatBarHeight = $('.hat-bar').height();
		$(window).on('scroll', function(){
		var scro = $(this).scrollTop();

		if(scro > hatBarHeight){
			$('.b-message').addClass('fixed');
		} else {
			$('.b-message').removeClass('fixed');
		}
});



	$(document).on('click','.add-active > *', addActive);
	$(document).on('click','.toggle-active > *', toggleActive);
	$(document).on('click','.store-items__close', function(){
		$(this).parents('tr').remove();
	});



	$('.settings-button').on('click', showPopup);
	$('.popup-button').on('click', showPopup);
	$('.button', '.popup').on('click', hidePopup);
	$(document).on('click','.popup',hidePopup);
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

	$(document).keydown(function(e){
				if(e.which === 27){
					closeShowBlock();
					closeLang();
				}
			});

			$(document).on('click', function(e){
				if (e && ((e.button == 3 || e.button == 2) || (e.which ==3 || e.which == 2))){
					return;
				}
				closeShowBlock();
			});
			$(document).on('click','.header-page', function(event){
				event.stopPropagation();
				closeLang();
			});

			$('.show').click(function(){
				var blockID = $(this).attr('href');

				if(!$(this).hasClass('active')){
					$('.show.active').removeClass('active');
					$(this).addClass('active');
					if($('.show-block').hasClass('active')){
						$('.show-block.active').removeClass('active').fadeOut(aSpeed, function(){
							$(blockID).fadeIn(aSpeed).addClass('active');
						});
					}	else	{
						$(blockID).fadeIn(aSpeed).addClass('active');

						try {
							stopSlide();
						} catch(e) {
							return false;
						}
					}
				}	else	{
					closeShowBlock();
				}
				closeLang();
				return false;
			});

		$(document).on('textchange','.wrapper.help input', function(){
			$(this).next('.f-hint').fadeOut(aSpeed);
		});

		$(document).on('click', '.lang .current', function(){
			if($(this).parent('.lang').hasClass('open')){
				closeLang();
			} else {
				closeShowBlock();
				$(this).parent('.lang').addClass('open');
				$('.lang-list').fadeIn();
			}
		});

			$(document).on('click', function(){
				closeLang();
			});
			$(document).on('click','.lang', function(event){
				event.stopPropagation();
			});

		$(document).on('click','.lang-list li', function(){
			var $that = $(this);
			$('.lang-list').fadeOut(function(){
				$that.addClass('current-lang').siblings().removeClass();
				var curLangImg = $that.find('img').clone();
				$('.current','.lang').html(curLangImg);
				$('.lang').removeClass('open');
			});
		});
});