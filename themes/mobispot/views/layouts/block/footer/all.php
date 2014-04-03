<footer class="footer-page">
    <div class="row">
        <div class="large-12 columns">
            <h3></h3>
            <?php $allLang = Lang::getLangArray(); ?>
            <!-- <ul class="lang-dropdown">
                <li class="dropdown">
                    <a class="spot-button" ><?php echo $allLang[Yii::app()->language]; ?></a>
                    <div class="options">
                        <ul>
                            <?php foreach ($allLang as $key => $value): ?>
                                <?php if ($key != Yii::app()->language): ?>
                                    <li>
                                        <a href="/service/lang/<?php echo $key; ?>"><?php echo $value; ?></a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </li>
            </ul> -->
            <ul class="link-list left">
              <!-- <li><a href="/pages/about"><?php echo Yii::t('footer', 'About us') ?></a></li> -->
                <li><a href="/phones"><?php echo Yii::t('footer', 'Phones') ?></a></li>
                <li><a href="/help"><?php echo Yii::t('footer', 'Get help') ?></a></li>
                <!-- <li><a href="http://store.mobispot.com"><?php echo Yii::t('footer', 'Store') ?></a></li>
                --> 
                <!-- <li><a href="/pages/referrals"><?php echo Yii::t('footer', 'Referrals') ?></a></li>
                <li><a href="/pages/api"><?php echo Yii::t('footer', 'API') ?></a></li>
                --><!--  <li><a href="/pages/blog"><?php echo Yii::t('footer', 'Our blog') ?></a></li>
                --></ul>
            <div class="left soc-link">
                <a href="http://www.facebook.com/heyMobispot">&#xe000;</a>
                <span>Hook up</span>
                <a href="https://twitter.com/heymobispot">&#xe001;</a>
                <span>Keep up</span>
            </div>
            <p>
                <?php echo Yii::app()->par->load('copyright');?><br>
                <a href="mailto:sales@mobispot.com">sales@mobispot.com</a><br>
            </p>
        </div>
    </div>
</footer>
<div class="m-result">
    <p></p>
</div>