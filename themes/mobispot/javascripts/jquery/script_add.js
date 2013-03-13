
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

// $(document).ready(function() {
//     $('#sign-in input[name=password]').one("keypress", function() {
//       var email = $('#sign-in input[name=email]').val();
//       if (email) {
//         $("#signInForm .spot-button.login").show();
//       }
//     });

//     $('#sign-in input[name=password]').keypress(function(e) {
//       if(e.which == 13) {
//         var email = $('#sign-in input[name=email]').val();
//         var password = $('#sign-in input[name=password]').val();
//         if (email && password) {
//           $("a.spot-button.login").trigger('click');
//         }
//       }
//     });

//     $(document).on("click", "a.spot-button.login", function () {
//     	var email = $('#sign-in input[name=email]').val();
//     	var password = $('#sign-in input[name=password]').val();
//     	var token = $('#sign-in input[name=token]').val();

//     	if (email && password && token) {
//     		$.ajax({
//           url: "/ajax/login",
//           data: ({email:email, password:password, token:token}),
//           dataType: 'json',
//           type:'POST',

//           success: function (result) {
//           	if (result.error){
//           		if (result.error == 'no'){
//           			$(location).attr('href','');
//           		}
//           		else if (result.error == 'yes'){
//           			$('#sign-in input[name=email]').attr('class','error');
//           			$('#sign-in input[name=password]').attr('class','error');
//           		}
//           	}
//           }
//          });
//     	}
//        return false;
//     });
// });