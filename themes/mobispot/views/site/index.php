<?php $this->blockFooterScript = '<script src="/themes/mobispot/js/jquery.slides.js"></script>
';?>

<span ng-init="getResolution()"></span>
<ul id="slides" class="slides-container">
    <li style="background-image:url(/themes/mobispot/img/slider/<?php echo $resolution?>/01.jpg); ">
        <div class="container">
            <h1>
                <?php echo Yii::t('general', 'Make a lasting<br> connection') ?>
            </h1>
            <p>
                <?php echo Yii::t('general', 'Met someone?<br> Share your details instantly with Mobispot.<br> Like something?<br> Share it, and brands can share right back.') ?>
            </p>
        </div>
    </li>
    <li style="background-image:url(/themes/mobispot/img/slider/<?php echo $resolution?>/02.jpg);">
        <div class="container blue">
            <h1>
                <?php echo Yii::t('general', 'Pay with a tap,<br> not with cash') ?>
            </h1>
            <p>
                <?php echo Yii::t('general', 'Spend less time paying for lunch,<br> spend more time eating it. Mobispot works<br> with your campus payment scheme.') ?>
            </p>
        </div>
    </li>
    <li style="background-image:url(/themes/mobispot/img/slider/<?php echo $resolution?>/03.jpg);">
        <div class="container">
            <h1>
                <?php echo Yii::t('general', 'All your tickets<br> in one place') ?>
            </h1>
            <p>
                <?php echo Yii::t('general', 'If you want your tickets close to hand,<br> put them on your wrist.') ?>
            </p>
        </div>
    </li>
    <li style="background-image:url(/themes/mobispot/img/slider/<?php echo $resolution?>/04.jpg);">
        <div class="container blue">
            <h1>
                <?php echo Yii::t('general', 'One tap is<br> all it takes') ?>
            </h1>
            <p>
                <?php echo Yii::t('general', 'Save time, carry less. You can keep<br> your loyalty cards, tickets and<br> membership details on your Spot.') ?>
            </p>
        </div>
    </li>
</ul>
<div class="slides-navigation">
    <a class="next" onclick="$('.slidesjs-next').click();">&#xe603;</a>
    <a class="prev" onclick="$('.slidesjs-previous').click();">&#xe602;</a>
</div>