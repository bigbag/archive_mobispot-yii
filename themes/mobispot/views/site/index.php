<?php
$this->sliderImage = array('slider.jpg', 'slider.jpg', 'slider_corp.jpg');
?>
<!-- <div class="row">
    <div class="twelve columns textSlider-box">
        <div id="textSlider">
            <div data-caption="#captionOne">
                <h1><?php echo Yii::t('slider', 'text slider 1') ?></h1>
            </div>
            <div data-caption="#captionTwo">
                <h1><?php echo Yii::t('slider', 'text slider 2') ?></h1>
            </div>
            <div data-caption="#captionThree">
                <h1><?php echo Yii::t('slider', 'text slider 3') ?></h1>
            </div>
        </div>
    </div>
</div> -->
<div class="row products-block">
    <h5>
        A new generation of wearable NFC devices is about to arrive.<br>
        Please meet "spots"!
    </h5>
    <div class="m-products row">
        <div class="four columns">
            <img src="/themes/mobispot/images/general/brace_black.png">
        </div>
        <div class="four columns">
            <img src="/themes/mobispot/images/general/key_green.png">
        </div>
        <div class="four columns">
            <img src="/themes/mobispot/images/general/card_blue.png">
        </div>
    </div>


    <div class="columns three">
        <input placeholder="Your email" type="email">
    </div>
    <div class="columns one">
        <a class="spot-button"><?php echo Yii::t('general', 'Send')?></a>
    </div>
    <p class="columns four input-des"><?php echo Yii::t('general', 'We will give you a brief letter when they are ready to be shipped (we don`t spam).')?> </p>
    <i></i>
</div>
<!-- Three-up Content Blocks -->
<div class="row spots-description">
    <div class="twelve columns">
        <div class="description-img">
            <img src="/themes/corp/images/icons/i-cloud.2x.png" height="115">
        </div>
        <h3 class="color"><?php echo Yii::t('general', 'Personal spot') ?></h3>
        <p><?php echo Yii::t('general', 'personal block desc') ?></p>
    </div>
    <div class="twelve columns">
        <div class="description-img">
            <img src="/themes/corp/images/icons/i-spot.2x.png" height="115">
        </div>
        <h3 class="color"><?php echo Yii::t('general', 'Digital wallet') ?></h3>
        <p><?php echo Yii::t('general', 'wallet block desc') ?></p>
    </div>
    <div class="twelve columns">
        <div class="description-img">
            <img src="/themes/corp/images/icons/i-person.2x.png" height="115">
        </div>
        <h3 class="color"><?php echo Yii::t('general', 'Easy ID') ?></h3>
        <p><?php echo Yii::t('general', 'easy id block desc') ?></p>
    </div>
</div>