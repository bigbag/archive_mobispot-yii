<div id="main-container">
    <div id="cont-block" class="center">
        <div id="video-block">
            <h2 style="text-align: center"><?php echo Yii::t('general', 'Храните и передавайте информацию<br /> по-новому. С помощью NFC')?></h2>
            <div id="video-present">
                <div id="video-shadow">
                    <iframe src="<?php echo Yii::app()->par->load('videoDesktopUrl'); ?>?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" width="390" height="220" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>

                </div>
            </div>
        </div>

        <div id="registration-block">
            <div id="registration-form">
                <?php if (Yii::app()->user->isGuest):?>
                <h2><?php echo Yii::t('general', 'Начните использовать Ваш спот<br /> прямо сейчас')?></h2>
                <form action="submit.php" method="POST">
                    <div  class="txt-form"><div  class="txt-form-cl"><input type="text" style="width:325px;" class="txt" name="inputtext" value="" placeholder="Адрес электронной почты" /></div></div>
                    <div  class="txt-form"><div  class="txt-form-cl"><input type="text" style="width:325px;" class="txt" name="inputtext" value="" placeholder="Пароль" /></div></div>
                    <div  class="txt-form"><div  class="txt-form-cl"><input type="text" style="width:325px;" class="txt" name="inputtext" value="" placeholder="Подтверждение пароля" /></div></div>
                    <div  class="txt-form"><div  class="txt-form-cl"><input type="text" style="width:325px;" class="txt" name="inputtext" value="" placeholder="Код активации спота" /></div></div>

                    <input type="checkbox" class="niceCheck"><span class="dop-txt">Я согласен с условиями предоставления сервиса</span>
                    <div class="btn-30"><div><input type="submit"  value="Зарегистрироваться" /></div></div>
                </form>
                <?php else:?>
                <h2>Мои споты</h2><span id="sort-spot"><span><?php echo Yii::t('general', 'По номерам')?></span> / <a href=""><?php echo Yii::t('general', 'По названию')?></a></span>
                <form action="submit.php" method="POST">
                    <div  class="btn-form"><div  class="btn-form-cl"><a href="">492358</a><a href="" class="name-spot">Личный</a></div></div>
                    <div  class="btn-form"><div  class="btn-form-cl"><a href="">492358</a><a href="" class="name-spot">Питомец</a></div></div>
                    <div  class="btn-form"><div  class="btn-form-cl"><a href="">492358</a><a href="" class="name-spot">Ссылка</a></div></div>
                    <div  class="btn-form"><div  class="btn-form-cl"><a href="">492358</a><a href="" class="name-spot">Личный</a></div></div>


                    <span class="dop-txt"><a href=""><?php echo Yii::t('general', 'Показать ещё')?><span></span></a></span>
                    <input type="submit" value="<?php echo Yii::t('general', 'Перейти в личный кабинет')?>" id="btn-lk" />
                </form>
                <?php endif;?>
                <div class="clear"></div>
            </div>
        </div>

        <div class="clear"></div>

        <div id="circle-menu">
            <ul>
                <li id="circle1"><span class="name-circle">Личные споты</span><span class="circle-hint"><span class="hint-back-cursor"></span><span class="hint-name">Личные споты</span><br />Размещайте в спотах информацию о себе и делитесь ей с теми, с кем считаете нужным.</span></li>
                <li class="cml"></li>
                <li id="circle2"><span class="name-circle">Быстрые ссылки</span><span class="circle-hint"><span class="hint-back-cursor"></span><span class="hint-name">Личные споты</span><br />Размещайте в спотах информацию о себе и делитесь ей с теми, с кем считаете нужным.</span></li>
                <li class="cml"></li>
                <li id="circle3"><span class="name-circle">Домашние животные</span><span class="circle-hint"><span class="hint-back-cursor"></span><span class="hint-name">Личные споты</span><br />Размещайте в спотах информацию о себе и делитесь ей с теми, с кем считаете нужным.</span></li>
                <li class="cml"></li>
                <li id="circle4"><span class="name-circle">Общение с клиентами</span><span class="circle-hint"><span class="hint-back-cursor"></span><span class="hint-name">Личные споты</span><br />Размещайте в спотах информацию о себе и делитесь ей с теми, с кем считаете нужным.</span></li>
                <li class="cml"></li>
                <li id="circle5"><span class="name-circle">Купоны и скидки</span><span class="circle-hint"><span class="hint-back-cursor"></span><span class="hint-name">Личные споты</span><br />Размещайте в спотах информацию о себе и делитесь ей с теми, с кем считаете нужным.</span></li>
            </ul>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
        <div id="bottom-menu">
            <ul>
                <li><a href=""  id="but1"></a></li>
                <li><a href=""  id="but2"></a></li>
                <li><a href=""  id="but3"></a></li>
            </ul>
        </div>
        <div class="clear"></div>
    </div>
</div>

