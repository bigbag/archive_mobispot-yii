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
                    <a href="mailto:hola@mobispot.com?subject=%D0%A5%D0%BE%D1%87%D1%83%20%D1%82%D1%80%D0%BE%D0%B9%D0%BA%D1%83" class="troika-btn">
                        <?php echo Yii::t('general', 'Напишите&nbsp;нам'); ?>
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
                <h1><?php echo Yii::t('general', 'Тройка, которую<br>ждали'); ?></h1>
                <span><?php echo Yii::t('general', 'Пользуйтесь городским транспортом, открывайте двери в офисе, делайте покупки и получайте скидки - все одной картой с вашим уникальным дизайном'); ?>
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
            <li><a class="tobusiness" href="#business"><?php echo Yii::t('general', 'Для бизнеса'); ?></a></li>
            <li><a href="mailto:hola@mobispot.com"><?php echo Yii::t('general', 'Напишите нам'); ?></a></li>
            <li><a href="http://mobispot.com"><?php echo Yii::t('general', 'Wearable NFC'); ?></a></li>
        </ul>
    </div>
    
    <div id="troika-info" class="full-screen">
        <div id="info"></div>
        <h1><?php echo Yii::t('general', 'Карта с вашим дизайном'); ?></h1>
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
                <h4><?php echo Yii::t('general', 'Катайтесь'); ?></h4>
                <p><?php echo Yii::t('general', 'Карта работает как<br>стандартная &ldquo;Тройка&rdquo;*'); ?></p>
            </td>
            <td width="33%">
                <h4><?php echo Yii::t('general', 'Открывайте двери'); ?></h4>
                <p><?php echo Yii::t('general', 'Больше не надо носить<br>отдельный пропуск в офис**'); ?></p>
            </td>
            <td>
                <h4><?php echo Yii::t('general', 'Делайте покупки'); ?></h4>
                <p><?php echo Yii::t('general', 'Расплачивайтесь картой за<br>товары и услуги внутри офиса'); ?></p>
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
                <h4><?php echo Yii::t('general', 'Получайте скидки'); ?></h4>
            </td>
            <td>
                <h4><?php echo Yii::t('general', 'Впечатляйте дизайном'); ?></h4>
            </td>
        </tr>
        <tr>
            <td width="50%">
                <p><?php echo Yii::t('general', 'Получайте скидки в заведениях рядом с офисом***'); ?></p>
            </td>
            <td>
                <p><?php echo Yii::t('general', 'Создайте карту с вашим<br>уникальным дизайном'); ?></p>
            </td>
        </tr>
        </table>
        <table class="content cards-order">
        <tr>
            <td width="70%" class="no-padding">
                <img src="themes/mobispot/img/troika/2screenpic2.jpg">
            </td>
            <td>
                <h3><?php echo Yii::t('general', 'Получите свою карту'); ?></h3>
                <p><?php echo Yii::t('general', 'Создайте дизайн карты на нашем сайте,<wbr> оформите заказ и наш курьер привезет вам новую &ldquo;Тройку&rdquo;.'); ?></p>
                <a href="mailto:hola@mobispot.com?subject=%D0%A5%D0%BE%D1%87%D1%83%20%D1%82%D1%80%D0%BE%D0%B9%D0%BA%D1%83" class="order-btn">
                    <?php echo Yii::t('general', 'Напишите&nbsp;нам'); ?>
                </a>
            </td>
        </tr>
        </table>
        <div class="note">
            <p><?php echo Yii::t('general', '* Подробная информация о Московской транспортной карте &ldquo;Тройка&rdquo; на '); ?><a href="http://troika.mos.ru/" target="_blank">troika.mos.ru</a></p>
            <p><?php echo Yii::t('general', '** Карта работает с большинством систем контроля доступа, включая Mifare, EM-marine'); ?></p>
            <p><?php echo Yii::t('general', '*** В подключенных точках продаж на территории вашего рабочего кампуса'); ?></p>
        </div>
    </div>
    
    <div id="business-info" class="full-screen"
       style="background-image: url(themes/mobispot/img/troika/back_last.jpg);"
    >
        <div id="business"></div>
        <table class="content">
        <tr>
            <td width="50%" class="left-half">
                <h1><?php echo Yii::t('general', 'Для бизнеса'); ?></h1>
                <h3><?php echo Yii::t('general', 'Бизнес-центры'); ?></h3>
                <p><?php echo Yii::t('general', 'Предоставьте дополнительные услуги внутри<br>офисного центра. Повысьте комфорт<br>и удобство для ваших арендаторов.'); ?></p>
                <h3><?php echo Yii::t('general', 'Компании'); ?></h3>
                <p><?php echo Yii::t('general', 'Избавьте ваших сотрудников от множества карт.<br>Развивайте дополнительные программы лояльности<br>для сотрудников при помощи сервисов &ldquo;Мобиспот&rdquo;.'); ?></p>
                <h3><?php echo Yii::t('general', 'Системные интеграторы'); ?></h3>
                <p><?php echo Yii::t('general', 'Создавайте системы контроля доступа нового уровня.<br>Добавьте новый сервис в линейку своих услуг.'); ?></p>
            </td>
            <td class="right-half">
                <a href="mailto:hola@mobispot.com"><?php echo Yii::t('general', 'Напишите нам'); ?></a>
            </td>
        </tr>
        </table>
        <div class="shadow-cover"></div>
    </div>