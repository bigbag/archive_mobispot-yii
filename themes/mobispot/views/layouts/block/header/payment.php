<header class="header-page">
  <?php if (Yii::app()->user->isGuest): ?>
  <div class="m-page-hat">
    <?php include('block/activ.php');?>
    <?php include('block/sign.php');?>
    </div>
  <?php endif; ?>
  <div class="row row__head-slider">
    <div class="twelve">
      <div class="header-top">
        <div class="four columns">
          <h1 class="logo"><a href="/"><img src="/themes/mobispot/images/logo.png" /></a></h1>
        </div>
        <div class="eight columns">
          <ul class="nav-bar right">
            <li>
              <a class="spot-button" href="/store">
                <?php echo Yii::t('menu', 'Store')?>
              </a>
            </li>
            <?php if (Yii::app()->user->isGuest): ?>
            <li>
              <a id="actSpot" class="spot-button toggle-box" href="#actSpotForm">
                <?php echo Yii::t('menu', 'Activate spot')?>
              </a>
            </li>
            <li>
              <a id="signIn" class="spot-button toggle-box" href="#signInForm">
                <?php echo Yii::t('menu', 'Sign in')?>
              </a>
            </li>
            <?php else:?>
            <li>
              <a class="spot-button" href="/payment/waller/">
                <?php echo Yii::t('menu', 'Wallets')?>
              </a>
              <a class="spot-button" href="/site/logout/">
                <?php echo Yii::t('menu', 'Logout')?>
              </a>
            </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
      <div class="bubbles-slider">
        <div id="slider">
          <?php if($this->sliderImage):?>
            <?php foreach ($this->sliderImage as $file):?>
              <img src="/themes/mobispot/images/<?php echo $file;?>" />
            <?php endforeach;?>
          <?php endif;?>
        </div>
      </div>
    </div>
  </div>
</header>