<?php
  $this->sliderImage=array('slider.jpg', 'slider.jpg', 'slider_corp.jpg');
?>
<div class="row">
  <div class="twelve columns textSlider-box">
    <div id="textSlider">
      <div data-caption="#captionOne">
        <h1><?php echo Yii::t('slider', 'text slider 1')?></h1>
      </div>
      <div data-caption="#captionTwo">
        <h1><?php echo Yii::t('slider', 'text slider 2')?></h1>
      </div>
      <div data-caption="#captionThree">
        <h1><?php echo Yii::t('slider', 'text slider 3')?></h1>
      </div>
      <div data-caption="#captionThree">
        <h1><?php echo Yii::t('slider', 'text slider 4')?></h1>
      </div>
      <div data-caption="#captionThree">
        <h1><?php echo Yii::t('slider', 'text slider 5')?></h1>
      </div>
    </div>
  </div>
</div>
<!-- Three-up Content Blocks -->

<div class="row spots-description">
  <div class="four columns">
    <img src="/themes/mobispot/images/icons/i-personal.png" />
    <h3 class="color"><?php echo Yii::t('general', 'Personal spot')?></h3>
    <p><?php echo Yii::t('general', 'personal block desc')?></p>
  </div>
  <div class="four columns">
    <img src="/themes/mobispot/images/icons/i-files.png" />
    <h3 class="color"><?php echo Yii::t('general', 'Files')?></h3>
    <p><?php echo Yii::t('general', 'files block desc')?></p>
  </div>
  <div class="four columns">
    <img src="/themes/mobispot/images/icons/i-quick.png" />
    <h3 class="color"><?php echo Yii::t('general', 'Quick link')?></h3>
    <p><?php echo Yii::t('general', 'quik link block desc')?></p>
  </div>
</div>
<div class="row spots-description">
  <div class="four columns">
    <img src="/themes/mobispot/images/icons/i-communication.png" />
    <h3 class="color"><?php echo Yii::t('general', 'Comunication with customers')?></h3>
    <p><?php echo Yii::t('general', 'comunication block desc')?></p>
  </div>
  <div class="four columns end">
    <img src="/themes/mobispot/images/icons/i-coupons.png" />
    <h3 class="color"><?php echo Yii::t('general', 'Coupon and discounts')?></h3>
    <p><?php echo Yii::t('general', 'coupon block desc')?></p>
    </div>
</div>