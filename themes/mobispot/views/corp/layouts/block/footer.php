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
          <?php echo Yii::t('corp_general', 'Условия использования')?>&nbsp;&nbsp;&nbsp;
        </span></li>
        <li>
          <a href="/uploads/oferta.pdf" target="_blank"> <?php echo Yii::t('corp_general', 'Оферта')?></a>
        </li>
        <li>
          <a href="/help"> <?php echo Yii::t('corp_general', 'Помощь')?></a>
        </li>

      </ul>
      <p>
        <?php echo Yii::t('corp_general', '© Мобиспот. Корпоративные сервисы. Все права защищены')?>
      <br>
      <a href="mailto:sales@mobispot.com">sales@mobispot.com</a>
      </p>
    </div>
  </div>
  <div class="row">
    <div class="large-12 columns footer-logo clearfix">
      <div class="left">
        <img src="/themes/corp/images/logos/visa.png">
        <img src="/themes/corp/images/logos/mastercard.png">
      </div>
      <div class="right">
        <img src="/themes/corp/images/logos/visa-verified.png">
        <img src="/themes/corp/images/logos/mastercard-secure.png">
      </div>
    </div>
  </div>
</footer>
<div class="m-result">
  <p></p>
</div>