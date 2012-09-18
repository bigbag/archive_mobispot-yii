<?php $this->beginContent('layouts/all'); ?>
<div id="main-container">
    <div id="cont-block" class="center">
        <div id="video-block">
            <h2 style="text-align: center"><?php echo Yii::t('general', 'Храните и передавайте информацию<br /> по-новому. С помощью NFC')?></h2>

            <div id="video-present">
                <div id="video-shadow">
                    <iframe
                            src="<?php echo Yii::app()->par->load('videoDesktopUrl'); ?>?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff"
                            width="390" height="220" frameborder="0" webkitAllowFullScreen mozallowfullscreen
                            allowFullScreen></iframe>
                </div>
            </div>
        </div>
        <div id="registration-block">
            <div id="registration-form">
                <?php echo $content;?>
                <div class="clear"></div>
            </div>
        </div>
        <div class="clear"></div>
        <div id="cap" style="margin-top: 50px;"></div>
        <div class="prev" id="foo_prev" style="display: none;"></div>
        <div id="circle">
            <div id="carousel">
                <div class="circle_image" id="1">
                    <img src="/uploads/blocks/1.png" alt="fruit1" width="82" height="82"/><br/>
                    Личные споты
                    <span><h3>Личные споты</h3></span>
                </div>
                <div class="circle_image" id="2">
                    <img src="/uploads/blocks/2.png" alt="fruit1" width="82" height="82"/><br/>
                    Личные споты
                    <span><h3>Личные споты</h3></span>
                </div>
                <div class="circle_image" id="3">
                    <img src="/uploads/blocks/3.png" alt="fruit1" width="82" height="82"/><br/>
                    Личные споты
                    <span><h3>Личные споты</h3></span>
                </div>
                <div class="circle_image" id="4">
                    <img src="/uploads/blocks/4.png" alt="fruit1" width="82" height="82"/><br/>
                    Личные споты
                    <span><h3>Личные споты</h3></span>
                </div>
                <div class="circle_image" id="5">
                    <img src="/uploads/blocks/5.png" alt="fruit1" width="82" height="82"/><br/>
                    Личные споты
                    <span><h3>Личные споты</h3></span>
                </div>
                <div class="circle_image" id="6" style="display: none;">
                    <img src="/uploads/blocks/1.png" alt="fruit1" width="82" height="82"/><br/>
                    Личные споты
                    <span><h3>Личные споты</h3></span>
                </div>
                <div class="circle_image" id="7" style="display: none;">
                    <img src="/uploads/blocks/2.png" alt="fruit1" width="82" height="82"/><br/>
                    Личные споты
                    <span><h3>Личные споты</h3></span>
                </div>
                <div class="circle_image" id="8" style="display: none;">
                    <img src="/uploads/blocks/3.png" alt="fruit1" width="82" height="82"/><br/>
                    Личные споты
                    <span><h3>Личные споты</h3></span>
                </div>
                <div class="circle_image" id="9" style="display: none;">
                    <img src="/uploads/blocks/4.png" alt="fruit1" width="82" height="82"/><br/>
                    Личные споты
                    <span><h3>Личные споты</h3></span>
                </div>
            </div>
        </div>

        <div class="next" id="foo_next"></div>
    </div>
    <input type="hidden" id="counter" value="1">

    <div class="clear"></div>

    <div id="bottom-menu">
        <ul>
            <li><a href="" id="but1"><img src="/uploads/blocks/ban1.png" alt="" width="271" height="82"/></a></li>
            <li><a href="" id="but2"><img src="/uploads/blocks/ban2.png" alt="" width="271" height="82"/></a></li>
            <li><a href="" id="but3"><img src="/uploads/blocks/ban3.png" alt="" width="271" height="82"/></a></li>
        </ul>
    </div>
    <div class="clear"></div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('div#foo_prev').click(function () {
            $('div#foo_next').show();
            var counter = $('input#counter').val() - 1;
            $('#carousel div#' + counter).show();
            $('#carousel div#' + (counter * 1 + 5)).hide();
            $('input#counter').val(counter);
            if (counter == 1) {
                $('div#foo_prev').hide();
                $('div#cap').show();
            }
            else $('div#foo_prev').show();
        });
        return false;
    });

    $(document).ready(function () {
        $('div#foo_next').click(function () {
            $('div#cap').hide();
            $('div#foo_prev').show();
            var counter = $('input#counter').val();
            $('#carousel div#' + counter).hide();
            $('#carousel div#' + (counter * 1 + 5)).show();
            $('input#counter').val(counter * 1 + 1);
            if (counter == 9 - 5) $('div#foo_next').hide();
        });
        return false;
    });
</script>
<?php $this->endContent(); ?>