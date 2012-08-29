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
                <?php if (Yii::app()->user->isGuest): ?>
                    <?php include('block/_not_auth.php'); ?>
                <?php else: ?>
                    <?php include('block/_auth.php'); ?>
                <?php endif;?>
                <div class="clear"></div>
            </div>
        </div>
        <div class="clear"></div>
        <div id="circle">
            <div id="carousel">
                <div>
                    <img src="/uploads/blocks/1.png" alt="fruit1" width="82" height="82"/><br/>
                    Личные споты
                    <span><h3>Личные споты</h3></span>
                </div>
                <div>
                    <img src="/uploads/blocks/2.png" alt="fruit2" width="82" height="82"/>
                    <br/>
                    Быстрые сслыки
                    <span><h3> Быстрые сслыки</h3></span>
                </div>
                <div>
                    <img src="/uploads/blocks/3.png" alt="fruit3" width="82" height="82"/>
                    <br/>
                    Файлы
                    <span><h3>Файлы</h3></span>
                </div>
                <div>
                    <img src="/uploads/blocks/4.png" alt="fruit4" width="82" height="82"/>
                    <br/>
                    Общение с клиентами
                    <span><h3>Общение с клиентами</h3></span>
                </div>
                <div>
                    <img src="/uploads/blocks/5.png" alt="fruit5" width="82" height="82"/>
                    <br/>
                    Купоны и скидки
                    <span><h3>Купоны и скидки</h3></span>
                </div>
                <div>
                    <img src="/uploads/blocks/1.png" alt="fruit1" width="82" height="82"/><br/>
                    Личные споты
                    <span><h3>Личные споты</h3></span>
                </div>
                <div>
                    <img src="/uploads/blocks/2.png" alt="fruit2" width="82" height="82"/>
                    <br/>
                    Быстрые сслыки
                    <span><h3> Быстрые сслыки</h3></span>
                </div>
                <div>
                    <img src="/uploads/blocks/3.png" alt="fruit3" width="82" height="82"/>
                    <br/>
                    Файлы
                    <span><h3>Файлы</h3></span>
                </div>
                <div>
                    <img src="/uploads/blocks/4.png" alt="fruit4" width="82" height="82"/>
                    <br/>
                    Общение с клиентами
                    <span><h3>Общение с клиентами</h3></span>
                </div>
            </div>
            <div class="clearfix"></div>
            <a class="prev" id="foo_prev" href="#"><span>prev</span></a>
            <a class="next" id="foo_next" href="#"><span>next</span></a>
        </div>
        <div class="clear"></div>

        <div id="bottom-menu">
            <ul>
                <li><a href="" id="but1"></a></li>
                <li><a href="" id="but2"></a></li>
                <li><a href="" id="but3"></a></li>
            </ul>
        </div>
        <div class="clear"></div>
    </div>

    <?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/js/jqurey.carousel.min.js'); ?>
    <script type="text/javascript">
        $(function () {
            $('#carousel').carouFredSel({
                auto:false,
                infinite:false,
                align:false,
                prev:"#foo_prev",
                next:"#foo_next",
                items:5,
                scroll:{
                    items:1
                }
            });
        });
    </script>