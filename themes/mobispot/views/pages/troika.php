<?php $this->pageTitle = Yii::t('general', 'Карта Тройка'); ?>
<?php $this->blockFooterScript = '<script src="themes/mobispot/js/troika.js"></script>'; ?>

    <header class="header-page" ng-init="host_type='desktop';">
        <div class="hat-bar content">
            <h1 class="logo">
                <a href="http://mobispot.com/">
                    <img itemprop="logo" alt="Mobispot" src="themes/mobispot/img/troika/logo_x2_white.png">
                </a>
            </h1>
            
            <ul class="right">
                <li>
                    <a href="http://mobispot.com/store" class="troika-btn">
                        Заказать&nbsp;карту
                    </a>
                </li>
            </ul>
        </div>

        <div id="message" class="show-block b-message" ng-class="{active: (modal=='message')}">
            <p>{{result.message}}
            </p>
        </div>
    </header>

    <div id="troika-first" class="first-screen" 
        style="background-image: url(themes/mobispot/img/troika/back_first.jpg)">
        <div class="v-centred">
        <table class="content troika">
        <tr>
            <td class="left-half">
                <img width="620" src="themes/mobispot/img/troika/first_screen_pic.png">
            </td>
            <td class="right-half">
                <div class="bottomed">
                <h1>Тройка, которую<br>ждали</h1>
                <span>Карта &ldquo;Тройка&rdquo; от Мобиспот умеет открывать двери и выполнять другие функции на территории вашего офиса. Создайте дизайн, который подходит вам или вашей компании
                </span>
                </div>
            </td>
        </tr>
        </table>
        </div>
        <div class="v-helper"></div>

        <div class="btn-wrapper">
            <a class="info-buttom" href="#info">
                <i class="icon">&#xE613;</i>
            </a>
        </div>
        
        <ul class="help-link">
            <li><a class="tobusiness" href="#business">Для бизнеса</a></li>
            <li><a href="mailto:hola@mobispot.com">Напишите нам</a></li>
            <li><a href="http://mobispot.com">Wearable NFC</a></li>
        </ul>
    </div>
    
    <div id="troika-info" class="full-screen">
        <div id="info"></div>
        <h1>Карта с вашим дизайном</h1>
        <img width="60%"src="themes/mobispot/img/troika/2screenpic.png">
        <table class="content items-3">
        <tr>
            <td width="33%">
                <img width="90px" src="themes/mobispot/img/troika/icon_trans.png">
            </td>
            <td width="33%">
                <img width="90px" src="themes/mobispot/img/troika/icon_lock.png">
            </td>
            <td>
                <img width="90px" src="themes/mobispot/img/troika/icon_pay.png">
            </td>
        </tr>
        <tr>
            <td width="33%">
                <h4>Оплачивай транспорт</h4>
                <p>Карта работает как<br>стандартная &ldquo;Тройка&rdquo;</p>
            </td>
            <td width="33%">
                <h4>Открывай двери</h4>
                <p>Больше не надо носить<br>отдельный пропуск в офис*</p>
            </td>
            <td>
                <h4>Оплачивай покупки</h4>
                <p>Плати за покупки<br>внутри офиса</p>
            </td>
        </tr>
        </table>        
        <table class="content items-2">
        <tr>
            <td width="50%">
                <img width="90px" src="themes/mobispot/img/troika/icon_discont.png">
            </td>
            <td>
                <img width="90px" src="themes/mobispot/img/troika/icon_dsg.png">
            </td>
        </tr>
        <tr>
            <td width="50%">
                <h4>Участвуй в акциях</h4>
                <p>Учавствуйте в акциях<br>внутри вашего офиса</p>
            </td>
            <td>
                <h4>Хвастай дизайном</h4>
                <p>Создай карту с вашим<br>уникальным дизайном</p>
            </td>
        </tr>
        </table>
        <table class="content cards-order">
        <tr>
            <td width="70%" class="no-padding">
                <img src="themes/mobispot/img/troika/2screenpic2.jpg">
            </td>
            <td>
                <h3>Получите свою карту<br>через 3 дня</h3>
                <p>Создайте дизайн карты на нашем сайте,<wbr> оформите заказ и через 3 дня курьер<wbr> привезет вам новую "Тройку".</p>
                <a href="http://mobispot.com/store" class="order-btn">
                    Заказать&nbsp;карту
                </a>
            </td>
        </tr>
        </table>
        <div class="note">
            <p>* карта работает с большинством систем контроля доступа, включая Mifare, EM-marine.</p>
        </div>
        <div class="center-btn">
            <a href="#business" class="tobusiness faster">
                Вы владелец бизнеса?
            </a>
        </div>
    </div>
    
    <div id="business-info" class="full-screen"
       style="background-image: url(themes/mobispot/img/troika/back_last.jpg);"
    >
        <div id="business"></div>
        <table class="content">
        <tr>
            <td width="50%" class="left-half">
                <h1>Для бизнеса</h1>
                <h3>Бизнес-центры</h3>
                <p>Повысьте комфорт и удобство для ваших<br>арендаторов. Предоставьте дополнительные<br>услуги внутри офисного центра.</p>
                <h3>Компании</h3>
                <p>Помогите вашим сотрудникам избавиться от<br>множества карт. Развивайте дополнительные<br> программы лояльности для персонала при<br>помощи нашей карты</p>
                <h3>Системные интеграторы</h3>
                <p>Создавайте системы контроля доступа нового<br>уровня. Добавьте новый сервис в линейку<br>своих услуг.</p>
            </td>
            <td class="right-half">
                <a href="mailto:hola@mobispot.com">Напишите нам</a>
            </td>
        </tr>
        </table>
        <div class="shadow-cover"></div>
    </div>