<header class="header-page">
    <?php if (Yii::app()->user->isGuest): ?>
        <?php include('activ.php');?>
        <?php include('sign.php');?>
    <?php endif; ?>
  <div class="row row__head-slider">
    <div class="twelve">
        <div class="header-top">
          <div class="four columns">
            <h1 class="logo"><a href="/"><img src="/themes/mobispot/images/logo.png" /></a></h1>
          </div>
            <div class="eight columns">
                <ul class="nav-bar right">
                <?php if (Yii::app()->controller->id!='site' and Yii::app()->controller->action->id!='index'): ?>
                    <li>
                        <a class="spot-button" href="/pages/business">Business</a>
                    </li>
                    <li>
                        <a class="spot-button" href="/pages/corporate">Corporate</a>
                    </li>
                <?php endif; ?>
                    <li>
                        <a class="spot-button" href="http://store.mobispot.com">Store</a>
                    </li>
                <?php if (Yii::app()->user->isGuest): ?>
                    <li>
                        <a id="actSpot" class="spot-button toggle-box" href="#actSpotForm">Activate spot</a>
                    </li>
                    <li>
                        <a id="signIn" class="spot-button toggle-box" href="#signInForm">Sign in</a>
                    </li>

                <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="bubbles-slider">
                  <div id="slider">
                    <?php if (Yii::app()->controller->id=='site' and Yii::app()->controller->action->id=='index'): ?>
                        <img src="/themes/mobispot/images/slider.jpg" />
                        <img src="/themes/mobispot/images/slider.jpg" />
                        <img src="/themes/mobispot/images/slider.jpg" />
                    <?php else:?>
                        <img src="/themes/mobispot/images/slider.jpg" />
                    <?php endif;?>
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