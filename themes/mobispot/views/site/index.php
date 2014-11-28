<?php $this->blockFooterScript = '<script>
    $(\'a[href^="#"]\').on(\'click\',function (e) {
        e.preventDefault();

        var target = this.hash,
        $target = $(target);

        $(\'html, body\').stop().animate({
            \'scrollTop\': $target.offset().top
        }, 600, \'swing\', function () {
            window.location.hash = target;
        });
    });
</script>'
?>

<div id="first-scr" class="first-screen">
    <article class="text-block">
        <h1><?php echo Yii::t('general', 'Forget about all these<br> plastic cards'); ?></h1>
            <p><?php echo Yii::t('general', 'Find out how to unite several<br> contactless features in one device'); ?></p>
            <a class="info-buttom" href="#fp-main-nav">
                <i class="icon">&#xE613;</i>
            </a>
    </article>
        <ul class="help-link">
                <li><a href="/demo-kit"><?php echo Yii::t('general', 'Get our demo-kit') ?></a></li>
                <li><a href="/readers"><?php echo Yii::t('phone', 'Device compatibility'); ?></a></li>
                <li><a href="mailto:helpme@mobispot.com"><?php echo Yii::t('general', 'Email us'); ?></a></li>
            </ul>
    <footer class="footer-page">

        <ul class="left">

            <li class="lang">
                <ul class="lang-list">
                    <li class="<?php echo ('en' == Yii::app()->language)?'current-lang':'' ?>">
                        <a href="/service/lang/en">
                            <img src="/themes/mobispot/img/lang-icon_en.png">English
                        </a>
                    </li>
                    <li class="<?php echo ('ru' == Yii::app()->language)?'current-lang':'' ?>">
                        <a href="/service/lang/ru">
                            <img src="/themes/mobispot/img/lang-icon_ru.png">Русский
                        </a>
                    </li>
                    <li class="<?php echo ('zh_cn' == Yii::app()->language)?'current-lang':'' ?>">
                        <a href="/service/lang/zh_cn">
                            <img src="/themes/mobispot/img/lang-icon_zh_cn.png">中文简体
                        </a>
                    </li>
                    <!-- <li class="<?php echo ('zh_tw' == Yii::app()->language)?'current-lang':'' ?>">
                        <a href="/service/lang/zh_tw">
                            <img src="/themes/mobispot/img/lang-icon_zh_tw.png">中文繁體
                        </a>
                    </li> -->
                </ul>
                <span class="current"><img src="/themes/mobispot/img/lang-icon_<?php echo Yii::app()->language ?>.png"></span>
            </li>
        </ul>
    </footer>
</div>
<div id="info" class="info-screen">
    <acticle class="main">
        <div id="fp-main-nav" class="second-screen">
            
            

            <div class="devices-pre">
            <h2 class="intro">
                    <?php echo Yii::t('general', 'One device instead of multiple cards'); ?>
                </h2>
                <div class="devices devices-left">
                    <ul class="main-nav">
                        <li class="nav-top">
                        <a class="nav-link" href="#payment">
                         <i class="icon">&#xE607;</i>
                            <h4><?php echo Yii::t('general', 'Access control'); ?></h4>
                            <p><?php echo Yii::t('general', 'Open your office or college doors using Mobispot wristband.'); ?></p>
                        </a>
                    </li>
                    <li class="nav-middle">
                        <a class="nav-link" href="#payment">
                         <i class="icon">&#xe61a;</i>
                            <h4><?php echo Yii::t('general', 'Personal ID'); ?></h4>
                            <p><?php echo Yii::t('general', 'Use Mobispot devices to identify yourself, it’s fast and secure.'); ?></p>
                        </a>
                    </li>
                        <li class="nav-bottom">
                            <a class="nav-link nav-link-blue" href="#transport">
                                <i class="icon">&#xe616;</i>
                                <h4><?php echo Yii::t('general', 'Transport'); ?></h4>
                                <p><?php echo Yii::t('general', 'Mobispot devices are compatible with transport ticketing systems of many cities around the world.'); ?></p>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="device-block" ng-controller="SlideController" id="slider-spots">
                                <div ng-mouseover="startColors()" ng-mouseleave="stopColors()" style="max-width: 100%;margin-bottom: 34px;margin-top: 80px;vertical-align: baseline;display: inline-block;height: auto;">
                                <img ng-repeat="slide in spots.slides" id="spots_{{slide.id}}"
                                   class="f-slide"
                                   ng-class="{display_none: slide.id != spots.current}"
                                   ng-src="/themes/mobispot/img/a_slider/{{slide.img}}" />
                                </div>

                    <ul class="device-type">
                        <li ng-click="fadeToWistbrands()" ng-class="{active: 'wristband' == spots.current_type}"><img src="/themes/mobispot/img/products/brace_blue.png"></li>
                        <li ng-click="fadeToCards()" ng-class="{active: 'card' == spots.current_type}"><img src="/themes/mobispot/img/products/card_red.png"></li>
                        <li ng-click="fadeToKeys()" ng-class="{active: 'key' == spots.current_type}"><img src="/themes/mobispot/img/products/key_green.png"></li>
                    </ul>
                    <p><?php echo Yii::t('general', 'Choose your Spot'); ?></p>
                </div>
                <div class="devices devices-right">
                    <ul class="main-nav">
                    <li class="nav-top">
                            <a class="nav-link" href="#soc">
                                <i class="icon">&#xE006;</i>
                                <h4><?php echo Yii::t('general', 'Payments'); ?></h4>
                                <p><?php echo Yii::t('general', 'Link your Spot to your bank card or e-wallet and just forget about necessity to carry cash.'); ?></p>
                            </a>
                    </li>
                    <li class="nav-middle">
                            <a class="nav-link" href="#soc">
                             <i class="icon">&#xE601;</i>
                                <h4><?php echo Yii::t('general', 'Loyalty cards'); ?></h4>
                                <p><?php echo Yii::t('general', 'No more need to take a new card to get the discount.'); ?></p>
                            </a>
                    </li>
                    <li class="nav-bottom">
                        <a class="nav-link" href="#coupon">
                             <i class="icon">&#xe617;</i>
                            <h4><?php echo Yii::t('general', 'Social links'); ?></h4>
                            <p><?php echo Yii::t('general', 'Share information about yourself easily and get rewards for your activity on the web.'); ?></p>
                        </a>
                    </li>
                </ul>
                </div>
            </div>
        </div>
        <div id="payment" class="info-item">
        <div class="wrapper">
            <header>
                <h2><?php echo Yii::t('general', 'Pass that you\'ll never forget'); ?></h2>
            </header>
            <p>
                <?php echo Yii::t('general', 'Open doors using Mobispot devices. Spots are compatible with the basic access control formats - Mifare and Em-marine. Registering the wristband in local access control system takes no more than a minute.'); ?>
            </p>
            <p>
                <?php echo Yii::t('general', 'Get rid of membership cards, passes and tickets. Use Spots instead of usual paper and plastic ID in gyms, hospitals, libraries etc.'); ?>
            </p>
        </div>
            
        </div>
        <div id="soc" class="info-item">
            <div class="wrapper">
                <header>
                    <h2><?php echo Yii::t('general', 'Reduce the amount of plastic in your pocket'); ?></h2>
                </header>
                        <p>
                            <?php echo Yii::t('general', 'Gather an infinite number of loyalty and membership cards in your Spot. There is no more need to take a new discount card in each store, activate new discounts and coupons just at the cashdesk or inside your Mobispot account.'); ?>
                        </p>
                        <p>
                            <?php echo Yii::t('general', 'Link wristband to your bank card - fast and secure. Look for an NFC reader with Mobispot logo in your campus and pay with one tap.'); ?>
                        </p>
                            <div class="ms-pay">
                                <img src="/themes/mobispot/img/pay-logo.png">
                            </div>
            </div>
        </div>
        <div id="coupon" class="info-item">
            <div class="wrapper">
                <header>
                    <h2><?php echo Yii::t('general', 'Connect digital and real'); ?></h2>
                </header>
                        <p>
                            <?php echo Yii::t('general', 'Get the discounts and bonuses in real stores for your “likes” and “clicks” on the web. 
When somebody wants to add you as a friend he can just tap your wristband with a phone.'); ?>
                        </p>
            </div>
        </div>
        <div id="transport" class="info-item">
            <div class="wrapper">
                <header>
                    <h2><?php echo Yii::t('general', 'All your tickets in one place'); ?></h2>
            </header>
                        <p>
                            <?php echo Yii::t('general', 'Our devices are compatible with the transport infrastructure in many cities around the world. We will let you know when you are able to pay for a ride with NFC wristband in your hometown.'); ?>
                    </p>
            </div>
        </div>

        <div id="dev" class="info-item">
            <header>
                <h3>
                    <?php echo Yii::t('general', 'Would like to use our<br> features in your project?'); ?>
                </h3>
                <p>
                    <?php echo Yii::t('general', 'We have a strong knowledge how different contactless applications work.<br> Our NFC devices are designed to be easily integrated into a wide range of applications.'); ?> 
                </p>
            </header>
            <article>
                    <p>
                        <?php echo Yii::t('general', 'Drop us a line'); ?> <a href="mailto:hola@mobispot.com">hola@mobispot.com</a> 
                    </p>
                
            </article>
        </div>


    </acticle>
</div>
