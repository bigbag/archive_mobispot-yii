
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