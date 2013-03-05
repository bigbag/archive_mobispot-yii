<header class="header-page">
    <?php if (Yii::app()->user->isGuest): ?>
        <?php include('activ.php');?>
        <?php include('sign.php');?>
    <?php endif; ?>
  <div class="row row__head-slider">
    <div class="twelve">
        <div class="header-top">
            <?php if (!Yii::app()->user->isGuest): ?>
            <?php $userInfo=$this->userInfo()?>
            <ul class="login-bar">
                <li><a href="#"><?php echo $userInfo->name;?></a></li>
                <!-- <li><a href="#">Shopping bag (2)</a></li> -->
            </ul>
            <?php endif; ?>
          <div class="four columns">
            <h1 class="logo"><a href="/"><img src="/themes/mobispot/images/logo.png" /></a></h1>
          </div>
            <div class="eight columns">
                <?php include('menu.php');?>
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
                        <a href="/pages/personal" class="bubble">
                            <h4>Personal</h4>
                            <p>Has millions of songs, from massive hits to rare gems to cult classic</p>
                            <b></b>
                        </a>
                        <a href="/pages/business" class="bubble">
                            <h4>Business</h4>
                            <p>Has millions of songs, from massive hits to rare gems to cult classic</p>
                            <b></b>
                        </a>
                        <a href="/pages/corporate" class="bubble">
                            <h4>Corporate</h4>
                            <p>Has millions of songs, from massive hits to rare gems to cult classic</p>
                            <b></b>
                        </a>
                  </div>
            </div>
        </div>
    </div>
</header>