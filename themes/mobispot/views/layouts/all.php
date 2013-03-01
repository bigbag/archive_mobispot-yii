<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en" ng-app="mobispot" ng-csp> <![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8" lang="en" ng-app="mobispot" ng-csp> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en" ng-app="mobispot" ng-csp> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" ng-app="mobispot" ng-csp> <!--<![endif]-->

<?php include('block/header.php');?>
<body>
    <div id="actSpotForm" class="slide-box">
        <div  class="row">
            <div class="seven columns centered">
                <h3>Start using your spot right now</h3>
            </div>
            <a href="javascript:;" class="slide-box-close"></a>
            <div class="five columns centered">
                <div class="choose-type">
                    <h6>Please tell us who you are</h6>
                    <div class="columns centered">
                        <a id="personSpot" class="radio-link six columns toggle-box toggle-box__sub" href="javascript:;"><i></i>Person</a>
                        <a id="companySpot" class="radio-link six columns toggle-box toggle-box__sub" href="javascript:;"><i></i>Company</a>
                    </div>
                </div>
            </div>
        </div>
        <div id="personSpotForm" class="bg-gray sub-slide-box">
            <div class="row">
                <div class="five columns centered">
                    <form>
                        <input class="error" type="email" placeholder="Email address">
                        <input type="password" placeholder="Password">
                        <input type="password" placeholder="Confirm your password">
                        <input type="text" placeholder="Spot activation code">
                        <div class="toggle-active">
                            <a class="checkbox agree" href="javascript:;"><i></i>I agree to Mobispot Pages Terms</a>
                        </div>
                        <div class="form-control">
                            <a class="spot-button" href="#">Activate spot</a>
                                <span class="right soc-link">
                                    <a href="#" class="i-soc-fac">&nbsp;</a>
                                    <a href="#" class="i-soc-twi">&nbsp;</a>
                                    <a href="#" class="i-soc-goo">&nbsp;</a>
                                </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="companySpotForm" class="bg-gray sub-slide-box">
            <div class="row">
                <div class="five columns centered">
                    <form>
                        <input class="error" type="email" placeholder="Email address">
                        <input type="password" placeholder="Password">
                        <input type="password" placeholder="Confirm your password">
                        <input type="text" placeholder="Spot activation code">
                        <div class="toggle-active">
                            <a class="checkbox agree" href="javascript:;"><i></i>I agree to Mobispot Pages Terms</a>
                        </div>
                        <div class="form-control">
                            <a class="spot-button" href="#">Activate spot</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="signInForm" class="slide-box">
        <div  class="row">
            <div class="seven columns centered">
                <h3>Sign in</h3>
            </div>
            <a href="javascript:;" class="slide-box-close"></a>
        </div>
        <div class="row">
            <div class="five columns centered">
                <form>
                    <input type="text" placeholder="Email address">
                    <input type="password" placeholder="Password">
                    <div class="form-control">
                        <a class="spot-button" href="#">Sign in</a>
                        <span class="right soc-link">
                            <a href="#" class="i-soc-fac">&nbsp;</a>
                            <a href="#" class="i-soc-twi">&nbsp;</a>
                            <a href="#" class="i-soc-goo">&nbsp;</a>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
  <div class="row row__head-slider">
    <div class="twelve">
        <div class="header-top">
          <div class="four columns">
            <h1 class="logo"><a href="/"><img src="/themes/mobispot/images/logo.png" /></a></h1>
          </div>
            <div class="eight columns">
                <ul class="nav-bar right">
                    <li><a class="spot-button" href="store.html">Store</a></li>
                    <li><a id="actSpot" class="spot-button toggle-box" href="#actSpotForm">Activate spot</a></li>
                    <li><a id="signIn" class="spot-button toggle-box" href="#signInForm">Sign in</a></li>
                </ul>
            </div>
        </div>
        <div class="bubbles-slider">
              <div id="slider">
                <img src="/themes/mobispot/images/slider.jpg" />
                <img src="/themes/mobispot/images/slider.jpg" />
                <img src="/themes/mobispot/images/slider.jpg" />
              </div>
              <div class="bubbles-content">
                    <a href="personal.html" class="bubble">
                        <h4>Personal</h4>
                        <p>Has millions of songs, from massive hits to rare gems to cult classic</p>
                        <b></b>
                    </a>
                    <a href="#" class="bubble">
                        <h4>Business</h4>
                        <p>Has millions of songs, from massive hits to rare gems to cult classic</p>
                        <b></b>
                    </a>
                    <a href="#" class="bubble">
                        <h4>Corporate</h4>
                        <p>Has millions of songs, from massive hits to rare gems to cult classic</p>
                        <b></b>
                    </a>
              </div>
            </div>
        </div>
    </div>
</header>
<div class="row">
    <div class="twelve columns textSlider-box">
        <div id="textSlider">
            <div data-caption="#captionOne">
                <h1> New ways to store and transmit<br> information via NFC</h1>
            </div>
            <div data-caption="#captionTwo">
                <h1> New ways to store and transmit<br> information via NFC</h1>
            </div>
            <div data-caption="#captionThree">
                <h1> New ways to store and transmit<br> information via NFC</h1>
            </div>
        </div>
    </div>
</div>
  <!-- Three-up Content Blocks -->

  <div class="row spots-description">

    <div class="four columns">
      <img src="/themes/mobispot/images/icons/i-personal.png" />
      <h3 class="color">Personal spot</h3>
      <p>Post information about yourself in spots and share it with anyone you want.</p>
    </div>

    <div class="four columns">
      <img src="/themes/mobispot/images/icons/i-files.png" />
      <h3 class="color">Files</h3>
      <p>Exchange files with your friends or customers. Show them pictures on their handset's screen or forward whatever you wnat directly to their mailboxes.</p>
    </div>

    <div class="four columns">
      <img src="/themes/mobispot/images/icons/i-quick.png" />
      <h3 class="color">Quick link</h3>
      <p>Provide access to the necessary websites, documents, and services without long
      searches and time-consuming navigation through site menus.</p>
    </div>
</div>
<div class="row spots-description">
     <div class="four columns">
      <img src="/themes/mobispot/images/icons/i-communication.png" />
      <h3 class="color">Comunication with customers</h3>
      <p>Tell existing and potential customers more
      about your business or find out what makes them unhappy.</p>
    </div>
     <div class="four columns end">
      <img src="/themes/mobispot/images/icons/i-coupons.png" />
      <h3 class="color">Coupon and discounts</h3>
      <p>Create and flexibly customize your own discount programs. Do not miss out on  potential customers – they are at arm's length from your coupon.</p>
    </div>
  </div>

</div>

<?php include('block/footer.php');?>
    <script src="themes/mobispot/javascripts/jquery/jquery.foundation.mediaQueryToggle.js"></script>
    <script src="themes/mobispot/javascripts/jquery/jquery.foundation.forms.js"></script>
    <script src="themes/mobispot/javascripts/jquery/jquery.event.move.js"></script>
    <script src="themes/mobispot/javascripts/jquery/jquery.event.swipe.js"></script>
    <script src="/themes/mobispot/javascripts/foundation/modernizr.foundation.js"></script>
    <script src="/themes/mobispot/javascripts/jquery/img-slider.min.js"></script>
    <script src="/themes/mobispot/javascripts/jquery/app.js"></script>
    <script src="/themes/mobispot/javascripts/jquery/slide-box.min.js"></script>
    <script src="/themes/mobispot/javascripts/jquery/script.js"></script>
    <script type="text/javascript">
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
                animation: 'vertical-push',                  // fade, horizontal-slide, vertical-slide, horizontal-push
                animationSpeed: 700,                // how fast animtions are
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
    </script>

    <script src="/themes/mobispot/javascripts/angular/app/app.js"></script>
    <script src="/themes/mobispot/javascripts/angular/app/services.js"></script>
    <script src="/themes/mobispot/javascripts/angular/app/controllers.js"></script>
    <script src="/themes/mobispot/javascripts/angular/app/filters.js"></script>
    <script src="/themes/mobispot/javascripts/angular/app/directives.js"></script>
</body>
</html>
