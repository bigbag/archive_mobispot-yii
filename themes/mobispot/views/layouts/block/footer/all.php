<footer class="footer-page content">
    <ul class="left info-links">
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
                <li class="<?php echo ('it' == Yii::app()->language)?'current-lang':'' ?>">
                    <a href="/service/lang/it">
                        <img src="/themes/mobispot/img/lang-icon_it.png">Italiano
                    </a>
                </li>
                <!-- <li class="<?php //echo ('zh_tw' == Yii::app()->language)?'current-lang':'' ?>">
                    <a href="/service/lang/zh_tw">
                        <img src="/themes/mobispot/img/lang-icon_zh_tw.png">中文繁體
                    </a>
                </li> -->
            </ul>
            <span class="current">
                <img src="/themes/mobispot/img/lang-icon_<?php echo Yii::app()->language ?>.png">
            </span>
        </li>
    </ul>
    <ul class="soc-link right">
        <li><a class="icon" href="https://twitter.com/heymobispot">&#xe001;</a></li>
        <li><a class="icon" href="http://www.facebook.com/heyMobispot">&#xe000;</a></li>

    </ul>
</footer>
