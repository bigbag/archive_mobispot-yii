<?php
$this->pageTitle=Yii::t('corp_error', 'Мобиспот. Сбой');

?>
<div class="row">
  <div class="singlebox-margin clearfix">
    <div class="large-5 column">
      <div class="p-error-txt">
        <?php if ($code==404): ?>
          <h2 class="color"><?php echo Yii::t('corp_error', 'К сожалению, такой страницы не существует.')?></h2>
        <?php else:?>
          <h2 class="color">
            <?php echo Yii::t('corp_error', 'Похоже, что-то пошло не так!')?>
          </h2>
        <?php endif;?>
        <p><?php echo Yii::t('corp_error', 'Если Вы считаете, что наш сервис работает некорректно, пожалуйста, напишите нам, и мы все починим.')?>

        </p>
        <footer>
          <a class="color" href="/help"><?php echo Yii::t('corp_error', 'Помощь')?></a>
          <a class="color" href="mailto:help@mobispot.com">help@mobispot.com</a>
          <a class="color" href="#">@heymobispot</a>
        </footer>
      </div>
    </div>
    <div class="large-7 column">
      <div class="error-message">
        <div class="error-text-block">
          <h1><?php echo Yii::t('corp_error', 'OОй!')?></h1>
          <span class="error-code"><?php echo $code; ?></span>
        </div>

      </div>
    </div>
  </div>
</div>