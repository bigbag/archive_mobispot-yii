<div class="first-screen">
    <article class="text-block">
        <h1><?php echo Yii::t('general', 'Connect digital<br> & real via NFC') ?></h1>
            <p><?php echo Yii::t('general', 'Pay. Ride. Share. Get rewards.') ?></p>
            <a class="info-buttom" ng-click="showInfo()" href="/pages/demoKit"><?php echo Yii::t('general', 'Get our demo-kit') ?></a>
    </article>
    <footer class="footer-page">
        <ul class="left">
            <li>
                <a href="/readers">
                    <?php echo Yii::t('phone', 'Device compatibility'); ?>
                </a>
            </li>
            <li>
                <a href="mailto:helpme@mobispot.com">
                    <?php echo Yii::t('general', 'Email us'); ?>
                </a>
            </li>
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
                    <li class="<?php echo ('zh_tw' == Yii::app()->language)?'current-lang':'' ?>">
                        <a href="/service/lang/zh_tw">
                            <img src="/themes/mobispot/img/lang-icon_zh_tw.png">中文繁體
                        </a>
                    </li>
                </ul>
            <span class="current"><img src="/themes/mobispot/img/lang-icon_<?php echo Yii::app()->language ?>.png"></span>
            </li>
        </ul>
    </footer>
</div>
<div id="info" class="info-screen">
    <acticle class="main">
    <a href="javacsript:;" data-scroll-index="0" data-scroll-nav="0" class="about first"><i class="icon">&#xe613;</i><?php echo Yii::t('general', 'Our devices'); ?></a>
    <ul id="infoNav" class="screen-nav">
        <li data-scroll-nav="1">
            <a href="#payment">
                <?php echo Yii::t('general', 'Payments'); ?>
                </a>
            </li>
        <li data-scroll-nav="2">
            <a href="#">
                <?php echo Yii::t('general', 'Social links'); ?>
            </a>
        </li>
        <li data-scroll-nav="3">
            <a href="#">
                <?php echo Yii::t('general', 'Coupons'); ?>
            </a>
        </li>
        <li data-scroll-nav="4">
            <a href="#">
                <?php echo Yii::t('general', 'Tickets'); ?>
                </a>
            </li>
        <li data-scroll-nav="5">
            <a href="#">
                <?php echo Yii::t('general', 'Work with us'); ?>
            </a>
        </li>
    </ul>
        <div id="devices" class="info-item">
            <header>
                <h1><?php echo Yii::t('general', 'Gather all your contactless cards in one device.<br> Then wear it.'); ?> </h1>
            </header>
            <div class="products-list" ng-controller="SlideController">
                <article id="slider-wristband" ng-init="">
                    <h3><?php echo Yii::t('store', 'Wristband'); ?></h3>
                    <p>
                        <?php echo Yii::t('store', 'Unique NFC wristband from Mobispot. Waterproof and sexy.'); ?>
                    </p>
                    <ul class="color-list">
                        <li ng-click="fadeTo(wristband, 1)"
                            style="background: #0062FF"></li>
                        <li ng-click="fadeTo(wristband, 3)"
                            style="background: #5AC0B9" ></li>
                        <li ng-click="fadeTo(wristband, 4)"
                            style="background: #d5d850" ></li>
                        <li ng-click="fadeTo(wristband, 2)"
                            style="background: #AB2640" ></li>
                        <li ng-click="fadeTo(wristband, 12)"
                            style="background: #c7cacc" ></li>
                        <li ng-click="fadeTo(wristband, 0)"
                            style="background: #000"></li>
                        <li class="wri-p1 wri-pattern"
                            ng-click="fadeTo(wristband, 5)"
                            style="background: #5AC0B9" ></li>
                        <li class="wri-p6 wri-pattern"
                            ng-click="fadeTo(wristband, 10)"
                            style="background: #5AC0B9" ></li>
                        <li class="wri-p3 wri-pattern"
                            ng-click="fadeTo(wristband, 7)"
                            style="background: #AB2640" ></li>
                        <li class="wri-p7 wri-pattern"
                            ng-click="fadeTo(wristband, 11)"
                            style="background: #AB2640" ></li>
                        <li class="wri-p4 wri-pattern"
                            ng-click="fadeTo(wristband, 8)"
                            style="background: #000" ></li>
                        <li class="wri-p5 wri-pattern"
                            ng-click="fadeTo(wristband, 9)"
                            style="background: #000" ></li>
                        <li class="wri-p2 wri-pattern"
                            ng-click="fadeTo(wristband, 6)"
                            style="background: #0062FF" ></li>
                    </ul>
                <div class="img-wrapper mainimageshell viewwindow">
                    <ul class="fullsizelist aslide">
                        <li ng-repeat="slide in wristband.slides" class="aslide">
                            <img id="wristband_{{slide.id}}"
                               class="large f-slide"
                               ng-src="/themes/mobispot/img/a_slider/{{slide.img}}" />
                        </li>
                    </ul>
                </div>
                </article>
                <article class="left" id="slider-cards">
                    <h3><?php echo Yii::t('store', 'Card'); ?></h3>
                    <p>
                        <?php echo Yii::t('store', 'Choice of conservative ones. If you get bored - draw something on it.'); ?>
                    </p>
                    <ul class="color-list">
                            <li ng-click="fadeTo(cards, 1)"
                                style="background: #0062FF"></li>
                            <li ng-click="fadeTo(cards, 2)"
                                style="background: #5AC0B9" ></li>
                            <li ng-click="fadeTo(cards, 4)"
                                style="background: #d5d850" ></li>
                            <li ng-click="fadeTo(cards, 3)"
                                style="background: #AB2640" ></li>
                            <li class="white"
                                ng-click="fadeTo(cards, 5)"
                                style="background: #fff" ></li>
                            <li ng-click="fadeTo(cards, 0)"
                                style="background: #000"></li>
                    </ul>
                    <div class="img-wrapper mainimageshell viewwindow">
                        <ul class="fullsizelist aslide">
                            <li ng-repeat="slide in cards.slides"
                                class="aslide">
                                <img id="cards_{{slide.id}}"
                                    class="large f-slide"
                                    ng-src="/themes/mobispot/img/a_slider/{{slide.img}}" />
                            </li>
                        </ul>
                    </div>
                </article>
                <article class="keyfob" id="slider-keyfobs">
                    <h3><?php echo Yii::t('store', 'Keyfob'); ?></h3>
                    <p><?php echo Yii::t('store', 'Occupies no space in your pocket but brings all the power of NFC.'); ?></p>
                    <ul class="color-list">
                        <li ng-click="fadeTo(keyfobs, 4)"
                            style="background: #0062FF" ></li>
                        <li ng-click="fadeTo(keyfobs, 2)"
                            style="background: #5AC0B9" ></li>
                        <li ng-click="fadeTo(keyfobs, 3)"
                            style="background: #d5d850" ></li>
                        <li ng-click="fadeTo(keyfobs, 1)"
                            style="background: #AB2640" ></li>
                        <li class="white"
                            ng-click="fadeTo(keyfobs, 5)"
                            style="background: #fff" ></li>
                        <li ng-click="fadeTo(keyfobs, 0)"
                            style="background: #000"></li>
                    </ul>
                    <div class="img-wrapper mainimageshell viewwindow">
                        <ul class="fullsizelist aslide">
                            <li ng-repeat="slide in keyfobs.slides"
                                class="aslide">
                                <img id="keyfobs_{{slide.id}}"
                                    class="large f-slide"
                                    ng-src="/themes/mobispot/img/a_slider/{{slide.img}}" />
                            </li>
                        </ul>
                    </div>
                </article>
            </div>
        </div>
        <a href="javacsript:;" data-scroll-nav="1" data-scroll-index="1" class="about"><i class="icon">&#xe613;</i><?php echo Yii::t('general', 'Payments'); ?></a>
        <div  id="payment" class="info-item">
        <div class="wrapper">
            <header>
                <h1>
                    <?php echo Yii::t('general', 'Pay with a tap, not with cash'); ?>
                </h1>
                <p class="sub-text">
                    <?php echo Yii::t('general', 'Spend less time paying for lunch, spend more time eating it. Mobispot works with your campus payment scheme.'); ?>
                </p>
            </header>
        </div>
        <table class="info-table pay-logo">
            <colgroup><col width="37%">
            <col width="26%">

            <col width="37%">
            </colgroup>
            <tbody>
                <tr>
                    <td></td>
                    <td>
                        <div class="img-wrapper">
                            <img src="/themes/mobispot/img/info/pay-logo.png" alt="pay-logo">
                        </div>
                    </td>
                    <td>
                        <p><?php echo Yii::t('general', 'Look for the payment reader with our logo in your campus.'); ?></p>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="wrapper">
            <article  class="payment-item img-left">
                <h3>
                    <?php echo Yii::t('general', 'Make your wristband pay for you'); ?>
                </h3>

                <div class="item-body">
                    <div class="img-wrapper brdr">
                        <img src="/themes/mobispot/img/info/defoult01.png">
                    </div>
                </div>
                <h5><?php echo Yii::t('general', 'Link a bank card'); ?></h5>
                <p>
                    <?php echo Yii::t('general', 'Once registered your Spot link it to your bank card - fast and absolutely secure. Now your wristband’s payment feature is powered.'); ?>
                </p>
            </article>
            <div class="double-block">
                <table class="info-table">
                    <colgroup>
                        <col width="45%">
                        <col width="10%">
                        <col width="45%">
                    </colgroup>
                    <tr>
                        <td><h3><?php echo Yii::t('general', 'Tap to pay'); ?></h3></td>
                        <td></td>
                        <td><h3><?php echo Yii::t('general', 'Manage spendings'); ?></h3></td>
                    </tr>

                    <tr>
                        <td>
                            <p>
                                <?php echo Yii::t('general', 'Find Mobispot payment reader in your campus. Tap your wristband to the reader to purchase coffee, snacks or lunch.'); ?>
                            </p>
                        </td>
                        <td></td>
                        <td>
                            <p>
                                <?php echo Yii::t('general', 'Track all your spendings at your personal account. Link even more banking cards to have several sources of money for your in-campus payments.'); ?>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td>
                                <div class="img-wrapper">
                                    <img src="/themes/mobispot/img/info/defoult02.jpg">
                                </div>
                        </td>
                        <td></td>
                        <td>
                            <div class="img-wrapper">
                                    <img src="/themes/mobispot/img/info/defoult03.jpg">
                                </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        </div>
        <a href="javacsript:;" data-scroll-nav="2" data-scroll-index="2" class="about"><i class="icon">&#xe613;</i><?php echo Yii::t('general', 'Social links'); ?></a>
        <div id="soc" class="info-item">
            <header>
                <h1><?php echo Yii::t('general', 'Make a lasting connection'); ?></h1>

                <p class="sub-text">
                    <?php echo Yii::t('general', 'Met someone? Share your details instantly with Mobispot. Like something? Share it, and brands can share right back.'); ?>
                </p>
            </header>
            <div class="triple">
                <table class="info-table">
                    <colgroup>
                        <col width="33.33%">
                        <col width="33.33%">
                        <col width="33.33%">
                    </colgroup>
                    <tr>
                        <td>
                            <h3><?php echo Yii::t('general', 'Connect digital<br> and real life'); ?></h3>
                        </td>
                        <td><h3><?php echo Yii::t('general', 'Make friends'); ?></h3></td>
                        <td><h3><?php echo Yii::t('general', 'Get rewards'); ?></h3></td>
                    </tr>
                    <tr>
                        <td>
                            <p>
                                <?php echo Yii::t('general', 'All your social networks accounts are connected to your wristband just with a few clicks.'); ?>
                            </p>
                        </td>
                        <td>
                            <p>
                                <?php echo Yii::t('general', 'When somebody wants to add you as a friend he can just tap your wristband with NFC phone. It’s easier than searching.'); ?>
                            </p>
                        </td>
                        <td>
                            <p>
                                <?php echo Yii::t('general', 'Follow some brands on the web? We will help you to find retailers who are grateful for your likes, shares and re-tweets. Just tap your wristband at the cashdesk to claim for a reward.'); ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="img-wrapper">
                                <img src="/themes/mobispot/img/info/IMG_9261.jpg">
                            </div>
                        </td>
                        <td>
                            <div class="img-wrapper">
                                <img src="/themes/mobispot/img/info/IMG_9478.jpg">
                            </div>
                        </td>
                        <td>
                            <div class="img-wrapper">
                                <img src="/themes/mobispot/img/info/get-rewards.jpg">
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <a href="javacsript:;" data-scroll-nav="3" data-scroll-index="3" class="about"><i class="icon">&#xe613;</i><?php echo Yii::t('general', 'Coupons'); ?></a>
        <div id="coupon" class="info-item">
        <div class="wrapper">
            <header>
                <h1><?php echo Yii::t('general', 'One tap is all it takes'); ?></h1>
                <p class="sub-text">
                    <?php echo Yii::t('general', 'Save time, carry less. You can keep your loyalty cards, tickets and membership details on your Spot.'); ?>
                </p>
        </header>
        <article  class="payment-item txt-r">
            <h3><?php echo Yii::t('general', 'Reduce the amount of plastic in your pocket'); ?></h3>
            <h5><?php echo Yii::t('general', 'Find your favorite retailers'); ?></h5>
            <p>
                <?php echo Yii::t('general', 'Visit the “Coupons” tab to look which retailers can treat your wristband as a loyalty card.'); ?>
            </p>
        </article>
            <div class="double-block">
                <table class="info-table">
                    <colgroup>
                        <col width="45%">
                        <col width="10%">
                        <col width="45%">
                    </colgroup>

                    <tr>
                        <td><h3><?php echo Yii::t('general', 'Participate in campaigns'); ?></h3></td>
                        <td></td>
                        <td><h3><?php echo Yii::t('general', 'Get your discount'); ?></h3></td>
                    </tr>
                    <tr>
                        <td>
                            <p>
                                <?php echo Yii::t('general', 'Choose the discount campaign you would like to take part. Sometimes reatilers may ask you to follow them or post a nice pic to Instagram.'); ?>
                            </p>
                        </td>
                        <td></td>
                        <td>
                            <p>
                                <?php echo Yii::t('general', 'Find an NFC reader at the cashdesk and tap it when check-out.'); ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="img-wrapper">
                                <img src="/themes/mobispot/img/info/coupons.jpg">
                            </div>
                        </td>
                        <td></td>
                        <td>
                            <div class="img-wrapper">
                                <img src="/themes/mobispot/img/info/get-discount.jpg">
                            </div>
                        </td>
                    </tr>
                </table>
                </div>
            </div>
        </div>
        <a href="#info" data-scroll-nav="4" data-scroll-index="4" class="about"><i class="icon">&#xe613;</i><?php echo Yii::t('general', 'Tickets'); ?></a>
        <div id="transport" class="info-item">
            <header>
                <h1><?php echo Yii::t('general', 'All your tickets in one place'); ?></h1>
                <p class="sub-text">
                    <?php echo Yii::t('general', 'If you want your tickets close to hand, put them on your wrist.'); ?>
                </p>
            </header>
            <article  class="payment-item img-right">
                <div class="item-body img-right">

                    <p>
                    <?php echo Yii::t('general', 'We are constantly working with transport service providers to bring you smart and handy wearable tickets. We will certainly inform you when you are able to pay for a ride with our NFC wristband in your hometown.'); ?>
                </p>
                    <div class="img-wrapper">
                        <img src="/themes/mobispot/img/info/IMG_9593-0.jpg">
                    </div>
                </div>
            </article>
        </div>
        <a href="javacsript:;" data-scroll-nav="5" data-scroll-index="5" class="about"><i class="icon">&#xe613;</i><?php echo Yii::t('general', 'Work with us'); ?></a>
        <div id="dev" class="info-item">
            <header>
                <h3>
                    <?php echo Yii::t('general', 'Would you like to enhance<br>
                    your project<br>
                    with modern features?<br>
                    We will bring you NFC <br>
                    and wearables<br>
                     at a time.  <br>'); ?>
                </h3>
            </header>
            <article  class="payment-item">
                <p>
                    <?php echo Yii::t('general', 'Campuses, retailers, e-wallets, transportation companies are welcomed.'); ?>
                </p>
                <p>
                    <?php echo Yii::t('general', 'Come on, drop a line to '); ?> <a href="mailto:hola@mobispot.com">hola@mobispot.com</a>
                </p>
            </article>
        </div>
    </acticle>
</div>
