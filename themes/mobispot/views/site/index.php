<?php
$this->sliderImage = array('slider.jpg', 'slider.jpg', 'slider_corp.jpg');
?>
<div class="row">
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
</div>
<!-- Three-up Content Blocks -->

<div class="row spots-description">
    <div class="four columns">
        <img src="/themes/mobispot/images/icons/i-cloud.2x.png"  height="115"/>
        <h3 class="color"><?php echo Yii::t('general', 'Personal spot') ?></h3>
        <p><?php echo Yii::t('general', 'personal block desc') ?></p>
    </div>
    <div class="four columns">
        <img src="/themes/mobispot/images/icons/i-spot.2x.png"  height="115"/>
        <h3 class="color"><?php echo Yii::t('general', 'Digital wallet') ?></h3>
        <p><?php echo Yii::t('general', 'wallet block desc') ?></p>
    </div>
    <div class="four columns">
        <img src="/themes/mobispot/images/icons/i-person.2x.png"  height="115"/>
        <h3 class="color"><?php echo Yii::t('general', 'Easy ID') ?></h3>
        <p><?php echo Yii::t('general', 'easy id block desc') ?></p>
    </div>
</div>