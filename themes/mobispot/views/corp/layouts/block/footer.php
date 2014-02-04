<footer class="footer-page">
  <div class="row">
    <div class="large-12 columns">
      <?php $allLang=Lang::getLangArray();?>
      <ul class="lang-dropdown">
        <li class="dropdown">
          <a class="spot-button" href="javascript:;"><?php echo $allLang[Yii::app()->language];?></a>
          <div class="options">
            <ul>
            <?php foreach ($allLang as $key=>$value):?>
              <?php if($key!=Yii::app()->language):?>
              <li>
                 <a href="/service/lang/<?php echo $key;?>"><?php echo $value;?></a>
              </li>
              <?php endif;?>
            <?php endforeach;?>
            </ul>
          </div>
        </li>
      </ul>
      <ul class="link-list left">
        <li><span id="j-wallet" class="payment-rules settings-button">
          <?php echo Yii::t('general', 'Условия использования')?>&nbsp;&nbsp;&nbsp;
        </span></li>
        <li>
          <a href="/uploads/oferta.pdf" target="_blank"> <?php echo Yii::t('general', 'Оферта')?></a>
        </li>
        <li>
          <a href="/help"> <?php echo Yii::t('general', 'Помощь')?></a>
        </li>

      </ul>
      <p>
        <?php echo Yii::t('general', '© Мобиспот. Корпоративные сервисы. Все права защищены')?>
      <br>
      <a href="mailto:sales@mobispot.com">sales@mobispot.com</a>
      </p>
    </div>
  <div class="footer-logo clearfix">
    <div class="left">
      <a><img src="/themes/corp/images/logos/visa.png"></a>
      <a><img src="/themes/corp/images/logos/mastercard.png"></a>
    </div>
    <div class="right">
      <a><img src="/themes/corp/images/logos/visa-verified.png"></a>
      <a><img src="/themes/corp/images/logos/mastercard-secure.png"></a>
    </div>
  </div>
</div>
</footer>
<div class="m-result">
  <p></p>
</div>
