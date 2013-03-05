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
	$(this).toggleClass('active');
};

var showPopup = function(){
	$element.showPopupButton = $(this);
	$popup.removeClass('hide').animate({opacity: 1}, 50, function(){
		$body.addClass('overflow-h');
	});

};
var hidePopup = function(){
	$element.showPopupButton.removeClass('active');
	$popup.animate({opacity: 0}, 50, function(){
		$(this).addClass('hide');
		$body.removeClass('overflow-h');
	});

};

$(window).load(function() {
	$('.add-active > *').click(addActive);
	$('.toggle-active > *').click(toggleActive);
	$('.store-items__close').click(function(){
		$(this).parents('tr').remove();
	});

	$('label').click(function(){
		$(this).next().focus();
	});
	$('.settings-button').click(showPopup);
	$('.button', '.popup').click(hidePopup);

	$(document).keydown(function(e){
		if(e.which == 27){
			$popup.hasClass('hide')||hidePopup();
		}
	});
});

//Слайдеры
$(window).load(function() {
  $('#textSlider').orbit({
      fluid: '14x2',
      timer: true,
      advanceSpeed: 6000,
      bullets: true,
      bulletThumbs: true,
      directionalNav: false
  });

  $('#slider').orbit({
      animation: 'vertical-push',        // fade, horizontal-slide, vertical-slide, horizontal-push
      animationSpeed: 700,      // how fast animtions are
      timer: true,       // true or false to have the timer
      advanceSpeed: 10000,
      pauseOnHover: true,      // if you hover pauses the slider
      startClockOnMouseOut: true,    // if clock should start on MouseOut
      startClockOnMouseOutAfter: 1000,    // how long after MouseOut should the timer start again
      directionalNav: false,      // manual advancing directional navs
      bullets: true,       // true or false to activate the bullet navigation
      bulletThumbs: true,    // thumbnails for the bullets
      bulletHover: true // true or false to hover

  });

  var bubblesSliderBullets = $('li','.bubbles-slider .orbit-bullets');
  var bubblesContent = $('.bubble','.bubbles-content');
  var bubblesLink = $('a','.bubbles-content');
  for(i=0;i < bubblesSliderBullets.length;i++){
      $(bubblesSliderBullets[i]).append($(bubblesContent[i]));
  }
});

//Авторизация
$(document).ready(function() {
    $(document).on("click", "a.spot-button.login", function () {
    	var email = $('#sign-in input[name=email]').val();
    	var password = $('#sign-in input[name=password]').val();
    	var token = $('#sign-in input[name=token]').val();

    	if (email && password && token) {
    		$.ajax({
          url: "/ajax/login",
          data: ({email:email, password:password, token:token}),
          dataType: 'json',
          type:'POST',

          success: function (result) {
          	if (result.error){
          		if (result.error == 'no'){
          			$(location).attr('href','');
          		}
          		else if (result.error == 'yes'){
          			$('#sign-in input[name=email]').attr('class','error');
          			$('#sign-in input[name=password]').attr('class','error');
          		}
          	}
          }
         });
    	}
       return false;
    });
});