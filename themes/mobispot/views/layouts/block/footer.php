<footer class="footer-page">
  <div class="row">
    <div class="twelve columns">
      <h3><?php echo Yii::t('footer', 'Footer title')?></h3>
      <?php $allLang=Lang::getLangArray();?>
      <ul class="lang-dropdown">
        <li class="dropdown toggle-active">
          <a class="spot-button" href="javascript:;"><?php echo $allLang[Yii::app()->language];?></a>
          <ul class="options">
            <?php foreach ($allLang as $key=>$value):?>
            <?php if($key!=Yii::app()->language):?>
            <li>
              <a href="/service/lang/<?php echo $key;?>"><?php echo $value;?></a>
            </li>
          <?php endif;?>
            <?php endforeach;?>
          </ul>
        </li>
      </ul>
      <ul class="link-list left">
        <li><a href="/pages/about"><?php echo Yii::t('footer', 'About us')?></a></li>
        <li><a href="/pages/phones"><?php echo Yii::t('footer', 'Phones')?></a></li>
        <li><a href="/pages/help"><?php echo Yii::t('footer', 'Help center')?></a></li>
        <li><a href="http://store.mobispot.com"><?php echo Yii::t('footer', 'Store')?></a></li>
        <li><a href="/pages/referrals"><?php echo Yii::t('footer', 'Referrals')?></a></li>
        <li><a href="/pages/api"><?php echo Yii::t('footer', 'API')?></a></li>
        <li><a href="/pages/blog"><?php echo Yii::t('footer', 'Our blog')?></a></li>
      </ul>
      <div class="right soc-link">
        <span><?php echo Yii::t('footer', 'Hook Up')?></span>
        <a href="#" class="i-soc-fac">&nbsp;</a>
        <br />
        <span><?php echo Yii::t('footer', 'Keep Up')?></span>
        <a href="#" class="i-soc-twi">&nbsp;</a>
      </div>
      <p>

      © 2013 Mobispot. Ltd. All rights reserved<br>
      <a href="mailto:sales@mobispot.com">sales@mobispot.com</a><br>
      </p>
    </div>
  </div>
</footer>