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
            <h2><?php echo Yii::t('general', 'Начните использовать Ваш спот<br /> прямо сейчас')?></h2>
            <span class="error"></span>
            <form action="#" method="post" id="registration">

                <div class="txt-form">
                    <div class="txt-form-cl">
                        <input type="text" id="email" style="width:325px;" class="txt"
                               name="RegistrationForm[email]"
                               value="" placeholder="<?php echo Yii::t('user', 'Адрес электронной почты');?>"
                               autocomplete="off"/></div>
                </div>
                <div class="txt-form">
                    <div class="txt-form-cl">
                        <input type="text" id="password" style="width:325px;" class="txt"
                               name="RegistrationForm[password]"
                               value="" placeholder="<?php echo Yii::t('user', 'Пароль');?>" autocomplete="off"/>
                    </div>
                </div>
                <div class="txt-form">
                    <div class="txt-form-cl">
                        <input type="text" id="verifyPassword" style="width:325px;" class="txt"
                               name="RegistrationForm[verifyPassword]"
                               value="" placeholder="<?php echo Yii::t('user', 'Подтверждение пароля');?>"
                               autocomplete="off"/></div>
                </div>
                <div class="txt-form">
                    <div class="txt-form-cl">
                        <input type="text" id="activ_code" style="width:325px;" class="txt"
                               name="RegistrationForm[activ_code]"
                               value="" placeholder="<?php echo Yii::t('user', 'Код активации спота');?>"
                               autocomplete="off"/></div>
                </div>
                <div id="registration_captcha" style="display: none">
                    <?php echo Yii::t('user', 'Пожалуйста введите код показанный на картинке');?>
                    <div id="img-capt">
                        <?php $this->widget('CCaptcha', array(
                        'clickableImage' => true,
                        'showRefreshButton' => true,
                        'buttonType' => 'button',
                        'buttonOptions' =>
                        array('type' => 'image',
                            'src' => "/themes/mobispot/images/ico-refresh.png",
                            'width' => 21,
                        ),
                    ));?>
                    </div>
                    <div class="txt-form">
                        <div class="txt-form-cl">
                            <input type="text" id="verifyCode" style="width:325px;" class="txt"
                                   name="RegistrationForm[verifyCode]"
                                   value=""/></div>
                    </div>
                </div>
                <div id="terms" style="display: none;">
                    <input type="checkbox" name="RegistrationForm[terms]" value="1" class="niceCheck">
                    <span class="dop-txt">
                        <?php echo Yii::t('user', 'Я согласен с условиями предоставления сервиса');?>
                    </span>
                </div>

                <div class="btn-30">
                    <input type="hidden" name="token" id="token"
                           value="<?php echo Yii::app()->request->csrfToken?>">

                    <div><input type="submit" value="<?php echo Yii::t('user', 'Зарегистрироваться');?>"/></div>
                </div>
            </form>
            <?php else: ?>
            <h2><?php echo Yii::t('general', 'Мои споты');?></h2><span
                id="sort-spot"><span><?php echo Yii::t('general', 'По номерам')?></span> / <a
                href=""><?php echo Yii::t('general', 'По названию')?></a></span>
            <form action="/user/account" method="get">
                <div class="btn-form">
                    <div class="btn-form-cl"><a href="">492358</a><a href="" class="name-spot">Личный</a></div>
                </div>
                <div class="btn-form">
                    <div class="btn-form-cl"><a href="">492358</a><a href="" class="name-spot">Питомец</a></div>
                </div>
                <div class="btn-form">
                    <div class="btn-form-cl"><a href="">492358</a><a href="" class="name-spot">Ссылка</a></div>
                </div>
                <div class="btn-form">
                    <div class="btn-form-cl"><a href="">492358</a><a href="" class="name-spot">Личный</a></div>
                </div>

                        <span class="dop-txt"><a href=""><?php echo Yii::t('general', 'Показать ещё')?>
                            <span></span></a></span>
                <br/>
                <br/>

                <div class="btn-30">
                    <div><input type="submit" value="<?php echo Yii::t('general', 'Перейти в личный кабинет')?>"/>
                    </div>
                </div>

            </form>
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