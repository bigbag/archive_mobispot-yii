<?php
$this->sliderImage = array('slider.jpg', 'slider.jpg', 'slider_corp.jpg');
?>
<div ng-click="action='none'">
    <ul id="slides" class="slides-container">
        <li style="background-image:url(/themes/mobispot/new/images/m11.jpg); ">
            <div class="container">
                <h1>Connect<br> digital & real </h1>
                <p>

                    Share your links & proﬁles easily.<br>
                    Be rewarded in real life for your<br>
                    Likes & Tweets on the web
                </p>
            </div>
        </li>
        <li style="background-image:url(/themes/mobispot/new/images/m21.jpg);">
            <div class="container blue">
                <h1>
                    Pay with<br>
                    a single tap
                </h1>
                <p>
                    Get rid of coins. Make purchase<br>
                    with real money or corporate one
                </p>
            </div>
        </li>
        <li style="background-image:url(/themes/mobispot/new/images/m31.jpg);">
            <div class="container">
                <h1>
                    Make it an<br>
                    easy ride
                </h1>
                <p>
                    Store tickets inside your spot. <br>
                    You will not lose or forget<br>
                    them anymore
                </p>
            </div>
        </li>
        <li style="background-image:url(/themes/mobispot/new/images/m41.jpg);">
            <div class="container blue">
                <h1>
                    Sign in faster
                </h1>
                <p>
                    Be recognized with a tap.<br>
                    Get rewards, discounts and <br>
                    personal services even faster

                </p>
            </div>
        </li>
    </ul>
</div>
<div class="slides-navigation">
    <a class="next" onclick="$('.slidesjs-next').click();">&#xe603;</a>
    <a class="prev" onclick="$('.slidesjs-previous').click();">&#xe602;</a>
</div>